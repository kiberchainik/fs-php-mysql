<?php
	class InterestsController extends Controller {
        public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_interests');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->interestsList = PrivateModel::Instance()->GetInterestsList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_interests_new');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'interest' => $this->post('interest')
                );
                
                if(PrivateModel::Instance()->addInterests($addDate));
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_interests_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользовательские интересы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->interestsData = PrivateModel::Instance()->GetInterestsData($id);
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'interest' => $this->post('interest')
                );
                
                PrivateModel::Instance()->editInterests($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteInterests($id);
           $this->redirect(Url::local('portfolio_interests'));
        }
    }
?>