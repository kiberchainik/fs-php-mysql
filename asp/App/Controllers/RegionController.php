<?php
	class RegionController extends Controller {
       public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('region/p_region');
           
           $v->title = 'ЦУП: Список регионов';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->r_list = RegionModel::Instance()->getRegionList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('region/p_new_region');
           
           $v->title = 'ЦУП: Новый регион';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->c_list = CountryModel::Instance()->getCountryList();
           
           if(isset($_POST['r_name']) and isset($_POST['id_c'])) {
               $data = array(
                    'id_country' => $this->post('id_c'),
                    'active' => 1
               );
               RegionModel::Instance()->AddNewRegion($data, $this->post('r_name'));
           }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('region/p_edit_region');
           
           $v->title = 'ЦУП: Редактирование';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $id = Router::getUriParam(2);
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->c_list = CountryModel::Instance()->getCountryList();
           $v->r_data = RegionModel::Instance()->GetRegionData($id);
           
           if($this->post('r_data')[1]['name']) {
                $edit_r = array(
                    'id' => $id,
                    'id_country' => $this->post('id_c'),
                    'active' => 1
                );
            
                RegionModel::Instance()->UpdateRegion($edit_r, $id, $this->post('r_data'));
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
           
           RegionModel::Instance()->deleteRegion($id);
           
           $this->redirect(Url::local('region'));
        }
	}
?>