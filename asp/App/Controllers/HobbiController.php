<?php
	class HobbiController extends Controller {
        public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_hobbi');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->hobbiList = PrivateModel::Instance()->GetHobbiList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_hobbi_new');
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
                    'hobbi' => $this->post('hobbi')
                );
                
                PrivateModel::Instance()->addHobbi($addDate);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_portfolio_hobbi_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользовательские интересы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->hobbiData = PrivateModel::Instance()->GetHobbiData($id);
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'hobbi' => $this->post('hobbi')
                );
                
                PrivateModel::Instance()->editHobbi($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteHobbi($id);
           $this->redirect(Url::local('portfolio_hobbi'));
        }
    }
?>