<?php
	class PortfolioController extends Controller {
        public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio');
           
           $v->title = 'ЦУП: Резюме на сайте';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getPortfolioCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->portfolioList = PrivateModel::Instance()->getAllPortfolio($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('portfolio'));
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_life_search_portfolio () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchPortfolio($this->post('user'));
            
            echo json_encode($search_result);
        }
	}
?>