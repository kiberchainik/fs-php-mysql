<?php
	class FilemanagerController extends Controller {
	   public function action_index() {
	       if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('fm');
           
           $v->title = 'Файловый менеджер FindSolution!';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->useTemplate();
	       $this->response($v);
	   }
	}
?>