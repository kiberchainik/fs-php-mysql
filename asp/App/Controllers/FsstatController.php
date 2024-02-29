<?php
	class FsstatController extends Controller {
       public function action_index() {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('statistic');
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           $v->title = $lang_login['title'];
           $v->description = '';
           
           $v->userstatistics = MainModel::Instance()->getStatisticsUser();
           
           $v->useTemplate();
	       $this->response($v);
	   }
    }
?>