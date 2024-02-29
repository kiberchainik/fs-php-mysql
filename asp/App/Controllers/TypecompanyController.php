<?php
	class TypecompanyController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_typecompany');
           
           $v->title = 'ЦУП: Все типы компаний';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
            $v->TypeList = PrivateModel::Instance()->GetTypeCompanyList();
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_typecompany_new');
           
           $v->title = 'ЦУП: Добавление нового типа компании';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
            
           if($this->post('nameType')) {
                $addDate = array(
                    'active' => ($this->post('deactivate') == '0')?'0':'1',
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->AddNewTypeCompany($addDate);
            }
           
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_typecompany_edit');
           
           $v->title = 'ЦУП: Редактирование типа компании';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->id = Router::getUriParam(2);
           $TypeData = PrivateModel::Instance()->GetTypeCompanyData($v->id);
            
            foreach ($TypeData as $k => $val) {
                $attType[$val['id_lang']] = array (
                    'name' => $val['name']
                );
            }
            $v->typeData = $attType;
           
           if ($this->post('nameType')) {
                $addDate = array(
                    'active' => ($this->post('deactivate') == '0')?'0':'1',
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->UpdDateTypeCompany($addDate, $v->id);
            }
            $v->GetActiveTypeAdverts = PrivateModel::Instance()->GetActiveTypeCompany($v->id);
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_delete () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
            if(!PrivateModel::Instance()->deletetype($id)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Категория удалена';
            }
            
            $this->redirect(Url::local('typeadverts'));
        }
    }
?>