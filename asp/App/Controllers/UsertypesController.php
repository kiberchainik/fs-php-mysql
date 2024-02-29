<?php
	class UsertypesController extends Controller {
        public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_usertypes');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->TypeList = PrivateModel::Instance()->GetUsersTypeList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_usertypes_new');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           if($this->post('nameType')) {
                $addDate = array(
                    'index' => $this->post('index'),
                    'type' => $this->post('type'),
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->AddNewUserType($addDate);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_usertypes_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->TypeData = PrivateModel::Instance()->GetUserTypeData($id);
            $TypeDataDescription = PrivateModel::Instance()->GetUserTypeDataDescription($id);
            
            foreach ($TypeDataDescription as $k => $val) {
                $TypeDataDescription[$val['id_lang']] = array (
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'id_user_type' => $val['id_user_type']
                );
            }
            $v->TypeDataDescription = $TypeDataDescription;
            
            if ($this->post('nameType')) {
                $addDate = array(
                    'index' => $this->post('index'),
                    'type' => $this->post('type'),
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->updUserTypeDate($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteUserType($id);
           
           $this->redirect(Url::local('usertypes'));
        }
	}
?>