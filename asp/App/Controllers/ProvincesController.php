<?php
	class ProvincesController extends Controller {
       public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('provinces/p_provinces');
           
           $v->title = 'ЦУП: Список провинций';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->p_list = ProvincesModel::Instance()->getProvincesList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_region() {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           if($this->post('c_id')) {
                $r_list = ProvincesModel::Instance()->getRegionListOfCountry($this->post('c_id'));
                echo json_encode($r_list);
           } else {
                echo json_encode(array('id' => 0, 'name' => 'Регионов нет!'));
           }
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('provinces/p_new_provinces');
           
           $v->title = 'ЦУП: Новая провинция';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->c_list = CountryModel::Instance()->getCountryList();
           
           /*echo'<pre>';
           print_r($_POST);
           echo'</pre>';*/
           
           if(isset($_POST['p_name'])) {
               $data = array(
                    'id_country' => $this->post('id_c'),
                    'id_region' => $this->post('id_r'),
                    'active' => 1
               );
               ProvincesModel::Instance()->AddNewProvinces($data, $this->post('p_name'));
           }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('provinces/p_edit_provinces');
           
           $v->title = 'ЦУП: Редактирование';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $id = Router::getUriParam(2);
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->c_list = CountryModel::Instance()->getCountryList();
           
           $v->p_data = ProvincesModel::Instance()->GetProvincesData($id);
           
           /*echo'<pre>';
           print_r($_POST);
           echo'</pre>';*/
           
           if($this->post('p_data')[1]['name']) {
                $edit_p = array(
                    'id' => $id,
                    'id_country' => $this->post('id_c'),
                    'id_region' => $this->post('id_r'),
                    'active' => 1
                );
            
                ProvincesModel::Instance()->UpdateProvinces($edit_p, $id, $this->post('p_data'));
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
           
           ProvincesModel::Instance()->deleteRProvinces($id);
           
           $this->redirect(Url::local('provinces'));
        }
	}
?>