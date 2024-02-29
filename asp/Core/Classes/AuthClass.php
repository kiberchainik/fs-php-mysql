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
       
       public function login ($login, $pass, $save = false) {
            $user = DBClass::Instance()->select('users', array('id, login, pass, admin, userType'), 'login = :login', array('login' => $login), '', '', '', '', '', '1');

            if(empty($user)) throw new AuthException('User <b>'.$login.'</b> not exists or wrong!');
            else {
                if($user['admin'] != '1' and $user['userType'] != '1') throw new AuthException('For <b>'.$login.'</b> access is denied!');
            }
            
            if(!$this->validPass($pass, $user['pass'])) throw new AuthException('Password is wrong!');
            else $this->createSession((int)$user['id'], $save);
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
            
            if(!$this->sesionTimeTest($token)) return false;
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
            
            if(!$this->user or ($this->user['admin'] != '1' and $this->user['userType'] != '1')) return false;
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