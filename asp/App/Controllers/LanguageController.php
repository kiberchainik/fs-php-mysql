<?php
	class LanguageController extends Controller {
       public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_language');
           
           $v->title = 'ЦУП: Настройка языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $v->LangList = PrivateModel::Instance()->GetLangList();
            
            $v->useTemplate();
           $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_language_new');
           
           $v->title = 'ЦУП: Настройка портала';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           if($this->post('nameLang')) {
                $addDate = array(
                    'title' => $this->post('nameLang'),
                    'code' => $this->post('codeLang'),
                    'status' => (!$this->post('statusSetup'))?'0':'1'
                );
                
                PrivateModel::Instance()->AddNewLanguage($addDate);
            }
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_language_edit');
           
           $v->title = 'ЦУП: Редактирование языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $id = Router::getUriParam(2);
           $v->langDate = PrivateModel::Instance()->GetLangData($id);
            
           if($this->post('nameLang')) {
                $addDate = array(
                    'id' => $id,
                    'title' => $this->post('nameLang'),
                    'code' => $this->post('codeLang'),
                    'status' => (!$this->post('statusSetup'))?'0':'1'
                );
                
                PrivateModel::Instance()->SaveNewLanguage($addDate, $id);
            }
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_trash ($arg) {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
           PrivateModel::Instance()->deletelang($id);
            
           $this->redirect(Url::local('language'));
        }
	}
?>