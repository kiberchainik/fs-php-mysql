<?php
	class InformationController extends Controller {
       public function action_index() {
	       $v = new View('site/information');
           $lang_info = $this->lang('information');
           
           $v->title = $lang_info['title'];
           $v->description = $lang_info['description'];
           $v->keywords = $v->info['keywords'];
           $v->og_img = '';
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->mainmenu = $this->module('MainMenu');
           
           $v->info = InformationModel::Instance()->GetInformation();
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_page () {
           $v = new View('site/full_information');
           $lang_info = $this->lang('information');
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->mainmenu = $this->module('MainMenu');
           //$v->leftsidebar = $this->module('LeftSidebar');
           
           $page = Router::getUriParam(2);
           $v->info = InformationModel::Instance()->GetInformationData($page);
           
           $v->title = $v->info['title'];
           $v->description = $v->info['description'];
           $v->keywords = $v->info['keywords'];
           $v->og_img = '';
           
           $v->useTemplate();
	       $this->response($v);
       }
	}
?>