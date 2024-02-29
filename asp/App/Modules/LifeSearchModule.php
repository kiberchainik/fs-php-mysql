<?php
	class LifeSearchModule extends Controller {
	   public function action_index() {
	       $v = new View('lifesearch');
           
           $lang_livesearch = $this->lang('lifesearch');
           
           $v->text_where_search = $lang_livesearch['text_where_search'];
           $v->text_users = $lang_livesearch['text_users'];
           $v->text_adverts = $lang_livesearch['text_adverts'];
           $v->text_allportfolio = $lang_livesearch['text_portfolio'];
           $v->text_vacancies = $lang_livesearch['text_vacancies'];

	       $this->response($v);
	   }
	}
?>