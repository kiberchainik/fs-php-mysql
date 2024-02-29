<?php
	class AssestsController extends Controller {
        public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_assests');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->assestsList = PrivateModel::Instance()->GetAssestsList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_assests_new');
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
                    'assests' => $this->post('assests')
                );
                
                PrivateModel::Instance()->addAssests($addDate);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_assests_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользовательские интересы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->assestsData = PrivateModel::Instance()->GetAssestsData($id);
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'assests' => $this->post('assests')
                );
                
                PrivateModel::Instance()->editAssests($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteAssests($id);
           $this->redirect(Url::local('portfolio_assests'));
        }
    }
?>