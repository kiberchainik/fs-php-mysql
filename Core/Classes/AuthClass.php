<?php
	class AuthClass {
	     const SALT_LEN = 10;
       const SALT_POS = 12;
       const SESSION_LIVE_TIME = 10800;
       const SESSION_LIVE_TIME_BIG = 864000;
       const SESSION_COOKIE_NAME = 'SESID';
       private $user = NULL;
       private $user_site_settings = NULL;
       
       private function __construct() {}
       private static $instance = NULL;
       
       public static function instance () {
            return self::$instance === NULL ? self::$instance = new self() : self::$instance;
       } 
       
       private function GUID() {
            if (function_exists('com_create_guid') === true) {
                return str_replace('-', trim(com_create_guid(), '{}'));
            }
        
            return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
       }
       
	   private function generateSalt () {
	       $s1 = md5(rand(1000000, 9999999));
           $s2 = sha1(time().rand());
           
           return substr(md5($s1.$s2), 0, self::SALT_LEN);
	   }
       
       private function passHash($pass, $salt) {
            $h1 = hash('sha256', $salt.$pass.$salt);
            $h2 = hash('sha256', $pass.$salt.$pass);
            $res = hash('sha256', $h1.$h2);
            
            return substr_replace($res, $salt, self::SALT_POS, self::SALT_LEN);
       }
       
       private function repairSalt ($hash) {
            return substr($hash, self::SALT_POS, self::SALT_LEN);
       }
       
       private function validPass ($pass, $hash) {
            $salt = $this->repairSalt($hash);
            $hash2 = $this->passHash($pass, $salt);
            
            return $hash === $hash2;
       }
       
       private function createSession ($user_id, $save = false) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = md5($_SERVER['HTTP_USER_AGENT']);
            $token = $this->GUID();
            $exp = time() + ($save ? self::SESSION_LIVE_TIME_BIG : self::SESSION_LIVE_TIME);
            
            DBClass::Instance()->insert('tokens', array(
                'user_id' => $user_id,
                'user_ip' => $ip,
                'user_agent' => $agent,
                'expires' => $exp,
                'login_time' => time(),
                'token' => $token
            ));
            
            setcookie(self::SESSION_COOKIE_NAME, $token, $exp, URLROOT.'/');
       }
       
       private function sesionTimeTest ($token) {
            if($token['expires'] < time()) {
                DBClass::Instance()->deleteElement('tokens', array('id' => $token['id']));
                return false;
            }
            
            $lt = $token['expires'] - $token['login_time'];
            if(($token['login_time'] + $lt/2) < time()) {
                setcookie(self::SESSION_COOKIE_NAME, $token['expires'], time()+$lt, URLROOT.'/');
                
                DBClass::Instance()->update('tokens',array('token' => $token['token'], 'expires' => time()+$lt, 'id' => $token['id']), 'id = :id');
                
            }
            
            return true;
       }
       
       public function registerUser ($login, $pass, $email, $user_type) {
            $g_pass = $this->passHash($pass, $this->generateSalt());
            
            $user = DBClass::Instance()->getCount('users', 'login = :login', array('login' => $login), 'id');
            $email_num = DBClass::Instance()->getCount('users', 'email = :email', array('email' => $email), 'id');
            
            if(!HTMLHelper::validEmail($email)) throw new AuthException('error_email');
            if(!HTMLHelper::validLogin($login)) throw new AuthException('error_login');
            
            if($user_type != '4' and $user_type != '5') throw new AuthException('type_is_wrong');
            if($email_num['numCount'] > 0) throw new AuthException('email_exist');
            if($user['numCount'] > 0) throw new AuthException('login_exist');
            
            if($user['numCount'] > 0) $this->login($login, $pass);
            else {
                $uData['login'] = $login; //������� ��������
                $uData['email'] = $email;
                $uData['date_reg'] = time();
                $uData['pass'] = $g_pass;
                
                DBClass::Instance()->insert('users', $uData);
                
                $last_id = DBClass::Instance()->getLastId();

                $udData['user_id'] = $last_id;
                $udData['type_person'] = $user_type;
                DBClass::Instance()->insert('user_date', $udData);
                
                $this->createSession($last_id);
            }
       }
       
       public function changePassword($login, $old_pass, $new_pass) {
            $user = DBClass::Instance()->select('users', array('id, pass'), 'login = :login', array('login' => $login), '', '', '', '', '', '1');

            if(empty($user)) throw new AuthException('user_not_exist');
            if(!$this->validPass($old_pass, $user['pass'])) return '<p class="error_list_icon">Old password is not correct!</p>';
            //echo $user['id'];
            $new_pass = $this->passHash($new_pass, $this->generateSalt());
            DBClass::Instance()->update('users', array('login' => $login, 'pass' => $new_pass), 'login = :login');
            
            setcookie(self::SESSION_COOKIE_NAME, '', time()-1, URLROOT.'/');
            $this->createSession((int)$user['id']);
            return '<p class="addedSuccess">Your password changed successfully</p>';
       }
       
       public function recovery ($email, $new_pass) {
            $new_pass = $this->passHash($new_pass, $this->generateSalt());
            DBClass::Instance()->update('users', array('email' => $email, 'pass' => $new_pass), 'email = :email');
       }
       
       public function login ($login, $pass) {
            $user = DBClass::Instance()->select('users', array('id, login, pass'), 'login = :login', array('login' => $login), '', '', '', '', '', '1');

            if(empty($user)) throw new AuthException('user_not_exist');
            if(!$this->validPass($pass, $user['pass'])) throw new AuthException('pass_is_wrong');
            $this->createSession((int)$user['id']);
       }
       
       public function isAuth () {
            if(empty($_COOKIE[self::SESSION_COOKIE_NAME])) return false;
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = md5($_SERVER['HTTP_USER_AGENT']);
            
            $token = DBClass::Instance()->select(
                'tokens',
                array('*'),
                'token = :token and user_ip = :user_ip and user_agent = :user_agent',
                array('token' => $_COOKIE[self::SESSION_COOKIE_NAME],'user_ip' => $ip,'user_agent' => $agent),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
            
            if(!$token) return false;
            
            if(!$this->sesionTimeTest($token)) header('Location login');
            $this->user = DBClass::Instance()->select(
                'users as u LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_date as ud ON u.id = ud.user_id',
                array('u.id as u_id, u.login, u.admin, u.userType, u.email, u.validStatus, ud.name, ud.lastname, ud.mobile, ud.about, ud.user_img, ud.type_person, ud.company_link'),
                'u.id = :id',
                array('id' => $token['user_id']),
                '',
                'u_id',
                '',
                '',
                '',
                '1'
            );
            
            $this->user_site_settings = DBClass::Instance()->select('user_settings', array('*'), 'user_id = :id', array('id' => $this->user['u_id']), '', '', '', '1', '', '2');
            if(!$this->user) header('Location login');
            else return true;
       }
       
       public function getUser() {
            return $this->user;
       }
       
       public function getUserSiteSettings() {
            return $this->user_site_settings;
       }
       
       public function logout ($all = false) {
            if(!$this->isAuth()) return;
            if($all) {
                DBClass::Instance()->deleteElement('tokens', array('user_id' => (int)$this->user['id']));
            } else {
                DBClass::Instance()->deleteElement('tokens', array('user_id' => (int)'1'));
                setcookie(self::SESSION_COOKIE_NAME, '', time()-1, URLROOT.'/');
            }
       }
	}
?>