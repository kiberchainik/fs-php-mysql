<?php
	class FieldsController extends Controller {
        public function action_fieldsgroup () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_fieldsgroup');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->fieldsgroup = PrivateModel::Instance()->getFieldsGroup();
           
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_p_fieldsgroup_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_fieldsgroup_new');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            if($this->post('title')) {
                $fieldDate = array(
                    'title' => $this->post('title'),
                    'description' => $this->post('desc')
                );
                
                PrivateModel::Instance()->addFieldGroup($fieldDate);
            }
            /*echo '<pre>';
            print_r($fieldDate);
            echo '</pre>';*/
            $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_p_fieldsgroup_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_fieldsgroup_edit');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $id = Router::getUriParam(2);
            
            if($this->post('title')) {
                $fieldDate = array(
                    'title' => $this->post('title'),
                    'description' => $this->post('desc'),
                    'id' => $id
                );
                
                PrivateModel::Instance()->UpdDateFieldsGroup($fieldDate, $id);
            }
            
            $v->fieldDate = PrivateModel::Instance()->getFieldGroupData($id);
            //$data['fieldDate']['categoryes'] = PrivateModel::Instance()->getCategoryForFields($id);
            //$data['fieldDate']['types'] = PrivateModel::Instance()->getTypeForFields($id);
            
            /*echo '<pre>';
            print_r($fieldDate);
            echo '</pre>';*/
            $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_p_fieldsgroup_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
            PrivateModel::Instance()->deleteFieldsGroup($id);
            
            $this->redirect(Url::local('fieldsgroup'));
        }
        /*----- /Private fields group -----*/
        
        /*----- Private fields of group -----*/
        public function action_index() {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_fields');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->FieldsList = CategoryModel::Instance()->getFieldsList();
            /*echo '<pre>';
            print_r($data['FieldsList']);
            echo '</pre>';*/
            $v->useTemplate();
	        $this->response($v);
        }
        
        /*public function sort ($sort) {
            $this->AuthUser();
            
            $_SESSION['sort'] = $sort[0];
            
            header('Location: /lptf_admin/fields');
        }*/
        
        public function action_p_fields_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_fields_new');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $v->FieldsGroupList = CategoryModel::Instance()->getFieldsGroupList();
            $v->TypeList = CategoryModel::Instance()->GetTypeList();
            
            if($this->post('namefield')) {
                $fieldDate = array(
                    'placeholder' => $this->post('placeholder'),
                    'type' => $this->post('typefield'),
                    'name' => $this->post('namefield'),
                    'value' => $this->post('valuefield'),
                    'id_style' => $this->post('id_stylefield'),
                    'class_style' => $this->post('class_stylefield')
                );
                if ($this->post('typeCategory') != '0') {
                    $fieldDate['typeCategory'] = $this->post('typeCategory');
                }
                
                if($this->post('id_group')) $id_group = $this->post('id_group');
                else $id_group = '';
                /*echo'<pre>';
                print_r($fieldDate);
                echo'</pre>';*/
                PrivateModel::Instance()->addField($fieldDate, $id_group);
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_p_fields_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_fields_edit');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $id = Router::getUriParam(2);
            $v->FieldsGroupList = CategoryModel::Instance()->getFieldsGroupList();
            $v->TypeList = CategoryModel::Instance()->GetTypeList();
            $v->getFieldsGroupForField = PrivateModel::Instance()->getFieldsGroupForField($id);
            $v->getFieldsForTypeList = PrivateModel::Instance()->getFieldsForTypeList($id);
            $v->fieldDate = PrivateModel::Instance()->getFieldData($id);
            
            
            
            if($this->post('namefield')) {
                
                $fieldDate = array(
                    'placeholder' => $this->post('placeholder'),
                    'type' => $this->post('typefield'),
                    'name' => $this->post('namefield'),
                    'value' => $this->post('valuefield'),
                    'id_style' => $this->post('id_stylefield'),
                    'class_style' => $this->post('class_stylefield')
                );
                
                if ($this->post('typeCategory') != '0') {
                    $fieldDate['typeCategory'] = $this->post('typeCategory');
                }
                
                if($this->post('id_group')) $id_group = $this->post('id_group');
                else $id_group = '';
                /*echo'<pre>';
                print_r($fieldDate);
                echo'</pre>';*/
                PrivateModel::Instance()->UpdFieldDate($fieldDate, $id_group, $id);
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_p_fields_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
            $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->deleteFields($id);
            
            $this->redirect(Url::local('fields'));
        }
	}
?>