<?php
	class LangController extends Controller {
       public function action_index() {
	       $page = Router::getUriParam('code');
           LangHelper::GetLangId($page);
           $this->redirect($_SERVER['HTTP_REFERER']);
	   }
	}
?>