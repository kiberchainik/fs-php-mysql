<?php
	class StatisticsController extends Controller {
       public function action_index() {
	       $v = new View('site/statistics');
           
           $statistic_text = $this->lang('statistics');
           $v->title = $statistic_text['title'];
           $v->description = $statistic_text['description'];
           $v->keywords = $statistic_text['keywords'];
           $v->og_img = '';
           $v->text_header_text = $statistic_text['header_text'];
           $v->text_registered_user = $statistic_text['registered_user'];
           $v->text_registered_user_text = $statistic_text['registered_user_text'];
           $v->text_portfolio_created = $statistic_text['portfolio_created'];
           $v->text_portfolio_created_text = $statistic_text['portfolio_created_text'];
           $v->text_candidacy_text = $statistic_text['candidacy_text'];
           $v->text_agency = $statistic_text['agency'];
           $v->text_candidats = $statistic_text['candidats'];
           //$v->text_ = $statistic_text[''];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           
           $v->statistics = StatisticsModel::Instance()->getStatisticAgencies();
           
           $v->useTemplate();
	       $this->response($v, true);
	   }
	}
?>