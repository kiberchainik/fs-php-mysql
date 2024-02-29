<?php
	class TypeadvertsController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_typeadverts');
           
           $v->title = 'ЦУП: Все типы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
            $v->TypeList = PrivateModel::Instance()->GetTypeList();
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_typeadverts_new');
           
           $v->title = 'ЦУП: Добавление нового типа';
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
                
                if(!PrivateModel::Instance()->AddNewType($addDate)) {
                    return 'Тип объявления добавлен';
                } else {
                    return 'Ошибка записи в базу';
                }
            }
           
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_typeadverts_edit');
           
           $v->title = 'ЦУП: Редактирование типа';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->id = Router::getUriParam(2);
           $TypeData = PrivateModel::Instance()->GetTypeData($v->id);
            
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
                
                PrivateModel::Instance()->UpdDate($addDate, $v->id);
            }
            $v->GetActiveTypeAdverts = PrivateModel::Instance()->GetActiveTypeAdverts($v->id);
            
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