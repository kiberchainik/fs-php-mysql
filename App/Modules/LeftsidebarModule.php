<?php
	class LeftSidebarModule extends Controller {
	   public function action_index() {
	       $v = new View('site/leftsidebar');
           $current_page = Router::getUriParam(0);
           
           $v->mainmenu = $this->module('MainMenu');
           $v->blogMenu = $this->module('BlogMenu');
           
	       $this->response($v);
	   }
	}
?>