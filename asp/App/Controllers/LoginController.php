<?php
	class LoginController extends Controller {
       public function action_index() {
	       $v = new View('p_login');
           
           $lang_login = $this->lang('login');
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->err_login = '';
           $v->err_register = '';
           $v->title = $lang_login['title'];
           $v->description = '';
           $v->tab_login = 'active';
           $v->tab_register = '';
           $v->tab_login_cont = 'in active';
           $v->tab_register_cont = '';
           $v->err_description = '';
           $v->text_login = $lang_login['login'];
           $v->text_register = $lang_login['register'];
           $v->text_pass = $lang_login['pass'];
           $v->text_remember = $lang_login['remember'];
           $v->text_forgetpass = $lang_login['forgetpass'];
           $v->text_email = $lang_login['email'];
           $v->text_or_login_whis = $lang_login['or_login_whis'];
           
           if(AuthClass::instance()->isAuth()) $this->redirect('main');
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_singin () {
            $v = new View('p_login');
                
            $lang_login = $this->lang('login');
            $v->title = $lang_login['title'];
            $v->description = '';
            $v->text_login = $lang_login['login'];
            $v->text_register = $lang_login['register'];
            $v->text_pass = $lang_login['pass'];
            $v->tab_login = 'active';
            $v->tab_register = '';
            $v->tab_login_cont = 'in active';
            $v->tab_register_cont = '';
            $v->text_remember = $lang_login['remember'];
            $v->text_forgetpass = $lang_login['forgetpass'];
            $v->text_email = $lang_login['email'];
            $v->text_or_login_whis = $lang_login['or_login_whis'];
            
            $v->header = $this->module('Header');
            $v->footer = $this->module('Footer');
            
            try {
                if($this->post('login') === NULL || $this->post('pass') === NULL) throw new Exception('Field is empty!');
                
                try {
                    AuthClass::instance()->login($this->post('login'), $this->post('pass'));
                    $this->redirect(Url::local('main'));
                } catch(AuthException $e) {
                    $v->err_title = 'Login error';
                    $v->err_login = $e->getMessage();
                }
            } catch (Exception $e) {
                $v->err_title = 'Login error';
                $v->err_login = $e->getMessage();
            }
            
            $v->useTemplate();
            $this->response($v);
       }
       
       public function action_logout () {
            AuthClass::instance()->logout();
            $this->redirect('login');
       }
    }
?>