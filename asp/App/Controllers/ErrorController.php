<?php
	class ErrorController extends Controller {
	   public function action_index () {
	       $v = new View('404');
           $error = $this->lang('404');
           
           $v->title = 'Error page';
           $v->description = '';
           
           $v->header = $this->module('Header');
           $v->conteiner = $this->module('Home');
           $v->footer = $this->module('Footer');
           
           $v->useTemplate();
	       $this->response($v);
	   }
	}
?>