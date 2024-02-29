<?php
	class ErrorsController extends Controller {
	   public function action_index() {
	       if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_errors');
           
           $v->title = 'Центр управления палетами!';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           //$text = file_get_contents('/home5/urlpyrtf/public_html/php-errors.log');
           
           $v->errors = file('/home5/urlpyrtf/public_html/log/php-errors.log');
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_clearfile() {
	       if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $f = fopen('/home5/urlpyrtf/public_html/log/php-errors.log', 'w');
           fclose($f);
           
           $this->redirect(Url::local('errors'));
	   }
	}
?>