<?php
	class FilterModule extends Controller {
	   public function action_index() {
	       $v = new View('site/filter');
           
           $lang_filter = $this->lang('filter');
           
           $page = Router::getUriParam(2);
           $v->filter = FilterModel::Instance()->getFilter($page);
           $v->page = $page;
           
	       $this->response($v);
	   }
	}
?>