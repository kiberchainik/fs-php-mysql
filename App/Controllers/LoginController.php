<?php
	class LoginController extends Controller {
       public function action_index() {
	       $v = new View('site/login');
           
           $lang_login = $this->lang('login');
           $profile = $this->lang('profile');
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->err_login = '';
           $v->og_img = '';
           $v->err_register = '';
           $v->title = $lang_login['title'];
           $v->description = $lang_login['title'];
           $v->keywords = '';
           $v->tab_login = 'active';
           $v->tab_register = '';
           $v->tab_login_cont = 'in active';
           $v->tab_register_cont = '';
           $v->err_description = '';
           $v->text_login = $lang_login['login'];
           $v->text_register = $lang_login['register'];
           $v->text_pass = $lang_login['pass'];
           $v->text_select_type_person = $profile['edit_select_type_person'];
           $v->text_remember = $lang_login['remember'];
           $v->text_forgetpass = $lang_login['forgetpass'];
           $v->text_email = $lang_login['email'];
           $v->text_or_login_whis = $lang_login['or_login_whis'];
           
           $v->type_person = ProfileModel::Instance()->GetTypesPerson();
           //print_r($v->type_person);
           $v->btn_google_auth = $this->googleUserOption();
           $v->btn_fb_auth = $this->fbUserOption();
           $v->btn_insta_auth = $this->instaUserOption();
           
           if(AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local('profile'));
	       }
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_singin () {
            $v = new View('site/login');
                
            $lang_login = $this->lang('login');
            $profile = $this->lang('profile');
            $v->title = $lang_login['title'];
            $v->description = '';
            $v->og_img = '';
            $v->keywords = '';
            $v->text_login = $lang_login['login'];
            $v->text_register = $lang_login['register'];
            $v->text_pass = $lang_login['pass'];
            $v->tab_login = 'active';
            $v->text_select_type_person = $profile['edit_select_type_person'];
            $v->tab_register = '';
            $v->tab_login_cont = 'in active';
            $v->tab_register_cont = '';
            $v->text_remember = $lang_login['remember'];
            $v->text_forgetpass = $lang_login['forgetpass'];
            $v->text_email = $lang_login['email'];
            $v->text_or_login_whis = $lang_login['or_login_whis'];
            $v->err_login = '';
            $v->err_register = '';
            $v->btn_google_auth = $this->googleUserOption();
            $v->btn_fb_auth = $this->fbUserOption();
            $v->btn_insta_auth = $this->instaUserOption();
            $v->header = $this->module('Header');
            $v->footer = $this->module('Footer');
            $v->type_person = ProfileModel::Instance()->GetTypesPerson();
            
            try {
                if($this->post('login') === NULL || $this->post('pass') === NULL) throw new Exception('Field is empty!');
                
                try {
                    AuthClass::instance()->login($this->post('login'), $this->post('pass'));
                    $this->redirect(Url::local('profile'));
                } catch(AuthException $e) {
                    $v->err_title = 'Login error';
                    $v->err_login = $lang_login[$e->getMessage()];
                }
            } catch (Exception $e) {
                $v->err_title = 'Login error';
                $v->err_login = $e->getMessage();
            }
            
            $v->useTemplate();
            $this->response($v);
       }
       
       public function action_singup () {
            $v = new View('site/login');
            $lang_login = $this->lang('login');
            $profile = $this->lang('profile');
            $emailtpl = $this->lang('emailtpl');
            
            $v->header = $this->module('Header');
            $v->footer = $this->module('Footer');
            
            $v->title = $lang_login['title'];
            $v->description = '';
            $v->err_login = '';
            $v->err_register = '';
            $v->og_img = '';
            $v->keywords = '';
            $v->text_login = $lang_login['login'];
            $v->text_register = $lang_login['register'];
            $v->text_pass = $lang_login['pass'];
            $v->text_select_type_person = $profile['edit_select_type_person'];
            $v->tab_login = '';
            $v->tab_register = 'active';
            $v->tab_login_cont = '';
            $v->tab_register_cont = 'in active';
            $v->text_remember = $lang_login['remember'];
            $v->text_forgetpass = $lang_login['forgetpass'];
            $v->text_email = $lang_login['email'];
            $v->text_or_login_whis = $lang_login['or_login_whis'];
            $v->btn_google_auth = $this->googleUserOption();
            $v->btn_fb_auth = $this->fbUserOption();
            
            $v->type_person = ProfileModel::Instance()->GetTypesPerson();
            
            try {
                if(!$this->post('login')) throw new AuthException('empty_login');
                if(!$this->post('pass')) throw new AuthException('empty_pass');
                if(!$this->post('email')) throw new AuthException('empty_email');
                if(!$this->post('user_type')) throw new AuthException('empty_user_type');
                
                AuthClass::instance()->registerUser($this->post('login'), $this->post('pass'), $this->post('email'), $this->post('user_type'));

                $reg_body = sprintf($lang_login['register_welcome_body'], $this->post('login'));
                $replace = array(
                    '{title}' => $lang_login['register_welcome_title'],
                    '{body}' => $reg_body,
                    '{btn}' => $lang_login['register_welcome_btn']
                );
                $message = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);
                  
                EmailTPLHelper::SendEmail($this->post('email'), $lang_login['register_welcome_title'], $message, $text);
                $this->redirect(Url::local('profile/edit'));
                } catch(AuthException $e) {
                    $v->err_title = 'Register error';
                    $v->err_register = $lang_login[$e->getMessage()];
                    $v->err_login = '';
                }
            $v->useTemplate();
            $this->response($v);
       }
       
       public function action_recovery() {
	       $v = new View('site/recovery');
           
           if(AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local('profile'));
	       }
           
           $lang_login = $this->lang('login');
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->err_login = '';
           $v->err_register = '';
           $v->keywords = '';
           $v->og_img = '';
           $v->title = $lang_login['title'];
           $v->description = '';
           $v->text_recovery_login = $lang_login['recovery_login'];
           $v->text_recovery = $lang_login['recovery'];
           $v->text_email = $lang_login['email'];
           
           $v->useTemplate();
           $this->response($v);
	   }
        
        private function googleUserOption () {
            $params = array(
            	'client_id'     => '708585083346-9eiak3l4eon7948iqahchqkcggo68tmj.apps.googleusercontent.com',
            	'redirect_uri'  => 'https://findsol.it/login/google_auth',
            	'response_type' => 'code',
            	'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            	'state'         => '123'
            );
             
            $url = 'https://accounts.google.com/o/oauth2/auth?'.urldecode(http_build_query($params));
            return $url;
        }
       
       public function action_google_auth () {
            if (isset($_GET['code'])) {
        	// ���������� ��� ��� ��������� ������ (POST-������).
            	$params = array(
            		'client_id'     => '708585083346-9eiak3l4eon7948iqahchqkcggo68tmj.apps.googleusercontent.com',
            		'client_secret' => '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',
            		'redirect_uri'  => 'https://findsol.it/login/google_auth',
            		'grant_type'    => 'authorization_code',
            		'code'          => $_GET['code']
            	);
                
            	$ch = curl_init('https://accounts.google.com/o/oauth2/token');
            	curl_setopt($ch, CURLOPT_POST, 1);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            	curl_setopt($ch, CURLOPT_HEADER, false);
            	$data = curl_exec($ch);
            	curl_close($ch);

            	$data = json_decode($data, true);
                
            	if (!empty($data['access_token'])) {
            		// ����� ��������, �������� ������ ������������.
            		$params = array(
            			'access_token' => $data['access_token'],
            			'id_token'     => $data['id_token'],
            			'token_type'   => 'Bearer',
            			'expires_in'   => 3599
            		);

            		$info = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?' . urldecode(http_build_query($params)));
            		$info = json_decode($info, true);
            		$login = explode('@', $info['email']);
            		
            		$user = ProfileModel::Instance()->getUserLoginEmail($login[0], $info['email']);
            		//print_r($user);
            		if($this->validPass($info['id'], $user['pass'])) {
            		  AuthClass::instance()->login($login[0], $info['id']);
            		  $this->redirect(Url::local('profile'));
            		} else {
                        //Array ( [id] => 101053675475598843001 [email] => kiberchainik@gmail.com [verified_email] => 1 [name] => Александр Иванов [given_name] => Александр [family_name] => Иванов [picture] => https://lh3.googleusercontent.com/a/AEdFTp7GDSU6M-8dPzbr0r8JIrRh9xOVs_gkBz18GZQP=s96-c [locale] => ru ) 
                        AuthClass::instance()->registerUser($login[0], $info['id'], $info['email'], '5');
                        
                        $newUserId = ProfileModel::Instance()->getNewUserId($login[0]);
                        $data = array(
                            'user_id' => $newUserId['id'],
                            'name' => $info['given_name'],
                            'lastname' => $info['family_name'],
                            'user_img' => $info['picture']
                        );
                        ProfileModel::Instance()->editProfile($data);
                        
                        //Send email about google auth success
                        $lang_login = $this->lang('login');
                        $emailtpl = $this->lang('emailtpl');
                        $reg_body = sprintf($lang_login['social_register_welcome_body'], $info['name'], 'Google', $info['id']);
                        $replace = array(
                            '{title}' => $lang_login['register_welcome_title'],
                            '{body}' => $reg_body,
                            '{btn}' => $lang_login['register_welcome_btn']
                        );
                        $message = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);
                        EmailTPLHelper::SendEmail($info['email'], $lang_login['social_reg_subject'].'Google', $message, sprintf($lang_login['reg_message'], $login[0], $info['id']));
                        
                        $this->redirect(Url::local('profile'));
                    }
                } else echo('Token is empty!');
           } else echo('It is problem!');
       }
       
       private function fbUserOption () {
            $client_id = '5343780585713271'; // Client ID
            $client_secret = 'bc0181fb039fd264ed0bab37c9f3d348'; // Client secret
            $redirect_uri = 'https://findsol.it/login/fb_auth'; // Redirect URIs
            
            $params = array(
                'client_id'     => $client_id,
                'redirect_uri'  => $redirect_uri,
                'response_type' => 'code',
                'scope'         => 'email'
            );
            $url = 'https://www.facebook.com/dialog/oauth?'.urldecode(http_build_query($params));
            return $url;
        }
       
       public function action_fb_auth () {
            if (isset($_GET['code'])) {
                $params = urldecode(http_build_query(array(
                    "client_id"    => '5343780585713271',
                    "redirect_uri"   => 'https://findsol.it/login/fb_auth',
                    "client_secret"  => 'bc0181fb039fd264ed0bab37c9f3d348',
                    "code"           => $_GET['code']
                )));
                
                $ch = curl_init('https://graph.facebook.com/oauth/access_token');
            	curl_setopt($ch, CURLOPT_POST, 1);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            	curl_setopt($ch, CURLOPT_HEADER, false);
            	$fb_user_date = curl_exec($ch);
            	curl_close($ch);
                
                $fb_user_date = json_decode($fb_user_date, true);
                
                if (isset($fb_user_date['access_token'])) {
                    $params = array(
                        'access_token' => $fb_user_date['access_token'],
                        'fields'       => 'id,email,first_name,last_name,picture'
                    );
                   
                    $userInfoContent = file_get_contents('https://graph.facebook.com/me?' . urldecode(http_build_query($params)));
                    $userInfo = json_decode($userInfoContent, true);
                    $login = explode('@', $userInfo['email']);
                    //Array ( [id] => 1623550284685613 [email] => kibersnails@gmail.com [first_name] => Alexandr [last_name] => Patrachi )
                    $user = ProfileModel::Instance()->getUserLoginEmail($login[0], $userInfo['email']);
                    $user_fb_img = 'https://graph.facebook.com/'.$userInfo['id'].'/picture?width=500&height=500';
                    
                    if($this->validPass($userInfo['id'], $user['pass'])) {
                        AuthClass::instance()->login($login[0], $userInfo['id']);
        		    } else {
                        AuthClass::instance()->registerUser($login[0], $userInfo['id'], $userInfo['email'], '5');
                        
                        $newUserId = ProfileModel::Instance()->getNewUserId($login[0]);
                        
                        $image = file_get_contents($user_fb_img);
                        mkdir('Media/images/users/'.$newUserId['id'].'/');
                        file_put_contents('Media/images/users/'.$newUserId['id'].'/'.$login[0].'.jpg', $image);
                        
                        $data = array(
                            'user_id' => $newUserId['id'],
                            'name' => $userInfo['first_name'],
                            'lastname' => $userInfo['last_name'],
                            'user_img' => 'Media/images/users/'.$newUserId['id'].'/'.$login[0].'.jpg'
                        );
                        ProfileModel::Instance()->editProfile($data);
                        
                        //Send email about google auth success
                        $lang_login = $this->lang('login');
                        $emailtpl = $this->lang('emailtpl');
                        $reg_body = sprintf($lang_login['social_register_welcome_body'], $userInfo['first_name'], 'Facebook', $userInfo['id']);
                        $replace = array(
                            '{title}' => $lang_login['register_welcome_title'],
                            '{body}' => $reg_body,
                            '{btn}' => $lang_login['register_welcome_btn']
                        );
                        $message = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);
                        EmailTPLHelper::SendEmail($userInfo['email'], $lang_login['reg_subject'].'Facebook', $message, sprintf($lang_login['reg_message'], $login[0], $userInfo['id']));
        		    }
                    $this->redirect(Url::local('profile'));
                } else echo('Token is empty!');
            } else $this->redirect(Url::local('login'));
       }
       
       private function instaUserOption () {
            $client_id = '1245374162811928'; // Client ID
            $redirect_uri = 'https://findsol.it/login/insta_auth'; // Redirect URIs
             
            $url = 'https://api.instagram.com/oauth/authorize?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&scope=user_profile,user_media&response_type=code';
            
            return $url;
        }
       
       public function action_insta_auth () {
            if(AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local('profile'));
	        }
            
            $v = new View('site/logininsta');
            $lang_login = $this->lang('login');
            
            $v->type_person = ProfileModel::Instance()->GetTypesPerson();
            
            $v->header = $this->module('Header');
            $v->footer = $this->module('Footer');
            $v->og_img = '';
            $v->err_register = '';
            $v->title = 'Instagram registration';
            $v->description = 'Instagram registration';
            $v->keywords = '';
            $v->userinstalogin = '';
            
            $v->text_login = $lang_login['login'];
            $v->text_register = $lang_login['register'];
            $v->text_pass = $lang_login['pass'];
            $v->text_select_type_person = '';
            $v->text_email = $lang_login['email'];
            
            if (isset($_GET['code'])) {
                $params = urldecode(http_build_query(array(
                    "client_id"    => '1245374162811928',
                    "redirect_uri"   => 'https://findsol.it/login/insta_auth',
                    "client_secret"  => '06117a8ac1225f01f1ce222c5fd5070a',
                    'grant_type'      => 'authorization_code',
                    "code"           => $_GET['code']
                )));
                
                $apiHost = 'https://api.instagram.com/oauth/access_token';
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiHost);
            	curl_setopt($ch, CURLOPT_POST, 1);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            	curl_setopt($ch, CURLOPT_HEADER, false);
            	$user_date = curl_exec($ch);
            	curl_close($ch);
                
                $user_date = json_decode($user_date, true);
                
                /*Array(
                    [access_token] => IGQVJYcHNJWkRnRGhta21LVTl1Umd6N2lxU0MtcmNBYzFob01PRlg4NlRqRWdlZAEpDeUR5UFN4STBwNHdNWTE2OGVYMHhQajJSVlFEM2V3VG1EX2g1aEhrcVBaZADN3cGdnS3gxM0E4ck1YcGc3TEZA0dUVEaXUxaGdSamgw
                    [user_id] => 7433421340081323
                )*/
                if (isset($user_date['access_token'])) {
                   $params = array(
                        'access_token' => $user_date['access_token'],
                        'fields'       => 'id,username'
                    );
                   
                    $userInfoContent = file_get_contents('https://graph.instagram.com/me?' . urldecode(http_build_query($params)));
                    $userInfo = json_decode($userInfoContent, true);
                    $v->userinstalogin = $userInfo['username'];
                    //$login = explode('@', $userInfo['email']);
                    //Array ( [id] => 1623550284685613 [email] => kibersnails@gmail.com [first_name] => Alexandr [last_name] => Patrachi )
                    /*$user = ProfileModel::Instance()->getUserLoginEmail($login[0], $userInfo['email']);
                    
                    if($this->validPass($userInfo['id'], $user['pass'])) {
                        AuthClass::instance()->login($login[0], $userInfo['id']);
        		    } else {
                        AuthClass::instance()->registerUser($login[0], $userInfo['id'], $userInfo['email'], '5');
                        
                        $newUserId = ProfileModel::Instance()->getNewUserId($login[0]);
                        $data = array(
                            'user_id' => $newUserId['id'],
                            'name' => $userInfo['first_name'],
                            'lastname' => $userInfo['last_name']
                        );
                        ProfileModel::Instance()->editProfile($data);
                        
                        //Send email about google auth success
                        $lang_login = $this->lang('login');
                        $emailtpl = $this->lang('emailtpl');
                        $reg_body = sprintf($lang_login['social_register_welcome_body'], $userInfo['first_name'], 'Facebook', $userInfo['id']);
                        $replace = array(
                            '{title}' => $lang_login['register_welcome_title'],
                            '{body}' => $reg_body,
                            '{btn}' => $lang_login['register_welcome_btn']
                        );
                        $message = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);
                        EmailTPLHelper::SendEmail($userInfo['email'], $lang_login['reg_subject'].'Facebook', $message, sprintf($lang_login['reg_message'], $login[0], $userInfo['id']));
        		    }
                    $this->redirect(Url::local('profile'));*/
                } else $v->err_register = 'Token is empty!';
            } else $this->redirect(Url::local('login'));
            
            $v->useTemplate();
            $this->response($v);
       }
       
       private function twitterUserOption () {
            $CONSUMER_KEY = 'vpGfs0OyOkOxUJJuMwh7pg92I';
            $CONSUMER_SECRET = 'oOzwVUKKP8xcn4tRKID8wFCjNCjQWiMimjirWfgZDvEed1H58k';
            $Bearer_Token = 'AAAAAAAAAAAAAAAAAAAAAPmbewEAAAAAsRTAFsIHJ%2FpWktefcQYlorTnNc0%3D5pFjspBbOzZf2IuIagLqHX3JWOmJbSVOEdt7uOL6OyQIwFIARr';
            $Access_Token = '1546448026226548736-WWTlmhMYnDRBgEltVXOVAqLOZpW4vI';
            
            $REQUEST_TOKEN_URL = 'https://api.twitter.com/oauth/request_token';
            $AUTHORIZE_URL = 'https://api.twitter.com/oauth/authorize';
            $ACCESS_TOKEN_URL = 'https://api.twitter.com/oauth/access_token';
            $ACCOUNT_DATA_URL = 'https://api.twitter.com/1.1/users/show.json';
            
            $CALLBACK_URL = 'https://findsol.it/login/twitter_auth';
                                                                                    
            // ��������� ������ (��� ������������)
            $oauth_nonce = md5(uniqid(rand(), true)); // ae058c443ef60f0fea73f10a89104eb9
            
            // ����� ����� ����� ����������� ������ (� ��������)
            $oauth_timestamp = time(); // 1310727371
            
            $oauth_base_text = "GET&";
            $oauth_base_text .= urlencode($REQUEST_TOKEN_URL)."&";
            $oauth_base_text .= urlencode("oauth_callback=".urlencode($CALLBACK_URL)."&");
            $oauth_base_text .= urlencode("oauth_consumer_key=".$CONSUMER_KEY."&");
            $oauth_base_text .= urlencode("oauth_nonce=".$oauth_nonce."&");
            $oauth_base_text .= urlencode("oauth_signature_method=HMAC-SHA1&");
            $oauth_base_text .= urlencode("oauth_timestamp=".$oauth_timestamp."&");
            $oauth_base_text .= urlencode("oauth_version=1.0");
            
            $oauth_signature = base64_encode(hash_hmac("sha1", $oauth_base_text, $CONSUMER_SECRET."&", true));
            
            $post = urlencode(http_build_query(
                array(
                        'oauth_callback' => $CALLBACK_URL, 
                        'oauth_consumer_key' => $CONSUMER_KEY, 
                        'oauth_nonce' => $oauth_nonce, 
                        'oauth_signature' => $oauth_signature, 
                        'oauth_signature_method' => 'HMAC-SHA1', 
                        'oauth_timestamp' => $oauth_timestamp, 
                        'oauth_version' => '1.0', 
                ) 
            ));
            
            $options = ['Content-Type: application/x-www-form-urlencoded\r\n Authorization: OAuth oauth_consumer_key="'.$CONSUMER_KEY.'", oauth_nonce="'.$oauth_nonce.'", oauth_signature="'.$oauth_signature.'", oauth_signature_method="HMAC-SHA1", oauth_timestamp="'.$oauth_timestamp.'", oauth_version="1.0"'];
            
            $ch = curl_init($REQUEST_TOKEN_URL);
        	curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, $options);
        	$fb_user_date = json_decode(curl_exec($ch));
        	curl_close($ch);
            //var_dump($fb_user_date);
        }
       
       public function action_twitter_auth () {
            if (!empty($_GET['oauth_token']) && !empty($_GET['oauth_verifier'])) {
                // ������� ������� ��� ��������� ������ �������
            
                $oauth_nonce = md5(uniqid(rand(), true));
                $oauth_timestamp = time();
                $oauth_token = $_GET['oauth_token'];
                $oauth_verifier = $_GET['oauth_verifier'];
            
            
                $oauth_base_text = "GET&";
                $oauth_base_text .= urlencode(ACCESS_TOKEN_URL)."&";
            
                $params = array(
                    'oauth_consumer_key=' . CONSUMER_KEY . '&',
                    'oauth_nonce=' . $oauth_nonce . '&',
                    'oauth_signature_method=HMAC-SHA1' . '&',
                    'oauth_token=' . $oauth_token . '&',
                    'oauth_timestamp=' . $oauth_timestamp . '&',
                    'oauth_verifier=' . $oauth_verifier . '&',
                    'oauth_version=1.0'
                );
            
                $key = CONSUMER_SECRET . '&' . $oauth_token_secret;
                $oauth_base_text = 'GET' . '&' . urlencode(ACCESS_TOKEN_URL) . '&' . implode('', array_map('urlencode', $params));
                $oauth_signature = base64_encode(hash_hmac("sha1", $oauth_base_text, $key, true));
            
                // �������� ����� �������
                $params = array(
                    'oauth_nonce=' . $oauth_nonce,
                    'oauth_signature_method=HMAC-SHA1',
                    'oauth_timestamp=' . $oauth_timestamp,
                    'oauth_consumer_key=' . CONSUMER_KEY,
                    'oauth_token=' . urlencode($oauth_token),
                    'oauth_verifier=' . urlencode($oauth_verifier),
                    'oauth_signature=' . urlencode($oauth_signature),
                    'oauth_version=1.0'
                );
                $url = ACCESS_TOKEN_URL . '?' . implode('&', $params);
            
                $response = file_get_contents($url);
                parse_str($response, $response);
            
            
                // ��������� ������� ��� ���������� �������
                $oauth_nonce = md5(uniqid(rand(), true));
                $oauth_timestamp = time();
            
                $oauth_token = $response['oauth_token'];
                $oauth_token_secret = $response['oauth_token_secret'];
                $screen_name = $response['screen_name'];
            
                $params = array(
                    'oauth_consumer_key=' . CONSUMER_KEY . '&',
                    'oauth_nonce=' . $oauth_nonce . '&',
                    'oauth_signature_method=HMAC-SHA1' . '&',
                    'oauth_timestamp=' . $oauth_timestamp . '&',
                    'oauth_token=' . $oauth_token . '&',
                    'oauth_version=1.0' . '&',
                    'screen_name=' . $screen_name
                );
                $oauth_base_text = 'GET' . '&' . urlencode(ACCOUNT_DATA_URL) . '&' . implode('', array_map('urlencode', $params));
            
                $key = CONSUMER_SECRET . '&' . $oauth_token_secret;
                $signature = base64_encode(hash_hmac("sha1", $oauth_base_text, $key, true));
            
            	// �������� ������ � ������������
                $params = array(
                    'oauth_consumer_key=' . CONSUMER_KEY,
                    'oauth_nonce=' . $oauth_nonce,
                    'oauth_signature=' . urlencode($signature),
                    'oauth_signature_method=HMAC-SHA1',
                    'oauth_timestamp=' . $oauth_timestamp,
                    'oauth_token=' . urlencode($oauth_token),
                    'oauth_version=1.0',
                    'screen_name=' . $screen_name
                );
            
                $url = ACCOUNT_DATA_URL . '?' . implode('&', $params);
            
                $response = file_get_contents($url);
                $user_data = json_decode($response, true);
            }
       }
       
       private function passHash($pass, $salt) {
            $h1 = hash('sha256', $salt.$pass.$salt);
            $h2 = hash('sha256', $pass.$salt.$pass);
            $res = hash('sha256', $h1.$h2);
            
            return substr_replace($res, $salt, 12, 10);
       }
       
       private function repairSalt ($hash) {
            return substr($hash, 12, 10);
       }
       
       private function validPass ($pass, $hash) {
            $salt = $this->repairSalt($hash);
            $hash2 = $this->passHash($pass, $salt);
            
            return $hash === $hash2;
       }
       
       public function action_logout () {
            AuthClass::instance()->logout();
            $this->redirect($_SERVER['HTTP_REFERER']);
       }
    }
?>