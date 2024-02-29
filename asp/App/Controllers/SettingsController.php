<?php
	class SettingsController extends Controller {
        public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_settings');
           
           $v->title = 'ЦУП: Настройка портала';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->settings = PrivateModel::Instance()->GetSettings();
           //$v->lang = PrivateModel::Instance()->GetLangNum();
           $v->langs = PrivateModel::Instance()->GetLangList();
           
           if($this->post('title')) {
                if(isset($_FILES['logo']) and !empty($_FILES['logo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['logo'], 'siteLogo');
                else $image = '';
                
                $addDate = array();
                
                $addDate['title'] = $this->post('title');
                $addDate['keywords'] = $this->post('keywords');
                $addDate['description'] = $this->post('description');
                $addDate['lang_default'] = $this->post('lang_default');
                $addDate['logo'] = $image;
                $addDate['tec_work'] = $this->post('tec_work');
                $addDate['admin_name'] = $this->post('admin_name');
                $addDate['admin_mobile'] = $this->post('admin_mobile');
                $addDate['admin_email'] = $this->post('admin_email');
                $addDate['admin_adres'] = $this->post('admin_adres');
                
                if (!$v->settings) $save = PrivateModel::Instance()->insertSettingsData($addDate);
                else {
                    $addDate['id'] = '1';
                    $save = PrivateModel::Instance()->updSettingsData($addDate);
                }
                
                /*echo '<pre>';
                print_r($addDate);
                echo '</pre>';*/
            }
           
           $v->useTemplate();
           $this->response($v);
        }
    }
?>