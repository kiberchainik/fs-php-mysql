<?php
	class CountryController extends Controller {
       public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('country/p_country');
           
           $v->title = 'ЦУП: Список стран';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->c_list = CountryModel::Instance()->getCountryList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_information_new');
           
           $v->title = 'ЦУП: Информация';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           if($this->post('page_description')[1]['title']) {
                $addDate = array(
                    'seo' => HTMLHelper::TranslistLetterRU_EN($this->post('page_description')[1]['title']),
                    'date' => time()
                );
            
                PrivateModel::Instance()->AddNewPage($addDate, $this->post('page_description'));
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_information_edit');
           
           $v->title = 'ЦУП: Редактирование';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           $id = Router::getUriParam(2);
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->pageData = PrivateModel::Instance()->GetPageData($id);
           
           if($this->post('page_description')[1]['title']) {
                $editDate = array(
                    'id' => $id,
                    'seo' => HTMLHelper::TranslistLetterRU_EN($this->post('page_description')[1]['title']),
                    'date' => time()
                );
            
                PrivateModel::Instance()->UpdatePage($editDate, $id, $this->post('page_description'));
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
           PrivateModel::Instance()->deleteInfoPage($id);
           
           $this->redirect(Url::local('information'));
        }
	}
?>