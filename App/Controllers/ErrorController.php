<?php
	class ErrorController extends Controller {
	   public function action_index() {
    	   $v = new View('site/404');
           $lang_comments = $this->lang('404');
           
           $v->title = $lang_comments['title'];
           $v->description = '';
           $v->keywords = '';
           $v->og_img = '';
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $u_date = AuthClass::instance()->getUser();
           
           $v->useTemplate();
	       $this->response($v);
	   }
	}
?>