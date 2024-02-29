<?php
	class MainController extends Controller {
	   public function action_index() {
	       $v = new View('site/main');

           $settings = MainModel::Instance()->GetSettings();
           $v->title = $settings['title'];
           $v->keywords = $settings['keywords'];
           $v->description = $settings['description'];
           $v->og_img = 'https://'.$_SERVER['HTTP_HOST'].'/Media/images/siteLogo/fq.png';
           
           $v->header = $this->module('Header');
           $v->conteiner = $this->module('Home');
           $v->footer = $this->module('Footer');
           
           $v->useTemplate();
	       $this->response($v);
	   }
	}
?>