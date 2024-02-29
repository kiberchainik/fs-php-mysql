<?php
	class AdscompanyController extends Controller {
	   public function action_index() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $valid_status = AuthClass::instance()->getUser();
           if($valid_status['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           
	       $v = new View('account/adscompany');
           $lang_ads = $this->lang('adscompany');
           
           $v->title = $lang_ads['title'];
           $v->description = '';
           $v->keywords = '';
           $v->add = $lang_ads['add'];
           $v->not_news = $lang_ads['not_ads'];
           $v->moder = $lang_ads['moder'];
           $v->public = $lang_ads['public'];
           $v->dont_show = $lang_ads['dont_show'];
           $v->show_ok = $lang_ads['show_ok'];
           $v->clicks = $lang_ads['clicks'];
           $v->text_edit = $lang_ads['text_edit'];
           $v->text_delete = $lang_ads['text_delete'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $v->adsList = AdscompanyModel::Instance()->getPublicList($valid_status['u_id']);
           
           $getClicks = array();
           foreach ($v->adsList as $k => $i) {
               $getClicks[$i['title']]['click'] = AdscompanyModel::Instance()->getClicks($i['id']);
           }
           $v->getClicks = $getClicks;
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_newads(){
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $valid_status = AuthClass::instance()->getUser();
           if($valid_status['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           
           $v = new View('account/new_ads');
           $lang_ads = $this->lang('adscompany');
           
           $v->title = $lang_ads['title'];
           $v->description = '';
           $v->keywords = '';
           $v->text_title = $lang_ads['text_title'];
           $v->text_keywords = $lang_ads['text_keywords'];
           $v->text_description = $lang_ads['text_description'];
           $v->text_images_advert = $lang_ads['text_images_advert'];
           $v->text_full_description = $lang_ads['text_full_description'];
           $v->text_link_company = $lang_ads['text_link_company'];
           $v->text_or = $lang_ads['text_or'];
           $v->text_select_advert_vacance = $lang_ads['text_select_advert_vacance'];
           $v->text_select_advert = $lang_ads['text_select_advert'];
           $v->text_select_vacance = $lang_ads['text_select_vacance'];
           $v->text_select = $lang_ads['text_select'];
           $v->text_show_period = $lang_ads['text_show_period'];
           $v->text_mobile = $lang_ads['text_mobile'];
           $v->text_email = $lang_ads['text_email'];
           $v->text_save = $lang_ads['save'];
           $v->lang_code = HeaderModel::Instance()->GetLangCode($_SESSION['lid']);
           $v->email = $valid_status['email'];
           $v->mobile = $valid_status['mobile'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $v->advertsOfUser = AdvertsModel::Instance()->getListAdvertsProfile($valid_status['u_id']);
           $v->vacanceOfUser = VacanciesModel::Instance()->getListProfileVacanciesForAds($valid_status['u_id']);
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_edit() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $p_page = Router::getUriParam(2);
           if(empty($p_page)) {
                $v->adsData = 'Public company dont exists!';
           } else {
                $valid_status = AuthClass::instance()->getUser();
                if($valid_status['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           
                $v = new View('account/editads');
                $lang_ads = $this->lang('adscompany');
                
                $v->title = $lang_ads['title'];
                $v->description = '';
                $v->keywords = '';
                $v->text_title = $lang_ads['text_title'];
                $v->text_keywords = $lang_ads['text_keywords'];
                $v->text_description = $lang_ads['text_description'];
                $v->text_images_advert = $lang_ads['text_images_advert'];
                $v->text_full_description = $lang_ads['text_full_description'];
                $v->text_link_company = $lang_ads['text_link_company'];
                $v->text_or = $lang_ads['text_or'];
                $v->text_select_advert_vacance = $lang_ads['text_select_advert_vacance'];
                $v->text_select_advert = $lang_ads['text_select_advert'];
                $v->text_select_vacance = $lang_ads['text_select_vacance'];
                $v->text_select = $lang_ads['text_select'];
                $v->text_show_period = $lang_ads['text_show_period'];
                $v->text_mobile = $lang_ads['text_mobile'];
                $v->text_email = $lang_ads['text_email'];
                $v->text_save = $lang_ads['save'];
                $v->lang_code = HeaderModel::Instance()->GetLangCode($_SESSION['lid']);
                
                $v->adsData = AdscompanyModel::Instance()->getUserPublicForEdit($p_page);
                $v->advertsOfUser = AdvertsModel::Instance()->getListAdvertsProfile($valid_status['u_id']);
                $v->vacanceOfUser = VacanciesModel::Instance()->getListProfileVacanciesForAds($valid_status['u_id']);
           }
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_save () {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $u_date = AuthClass::instance()->getUser();
           if($u_date['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           
           $lang_ads = $this->lang('adscompany');
           
           $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            $ads = array();
            
            if(!$this->post('title')) {
                $msg['errors']['title'] = $lang_ads['error_empty_title'];
            } else {
                $ads['data']['title'] = $this->post('title');
            }
            
            if(!$this->post('keywords')) $msg['errors']['keywords'] = $lang_ads['error_empty_keywords'];
            else $ads['data']['keywords'] = $this->post('keywords');
            
            if(!$this->post('description')) $msg['errors']['description'] = $lang_ads['error_empty_description'];
            else $ads['data']['short_desc'] = $this->post('description');
            
            if(!$this->post('email')) {
                $ads['data']['email'] = $u_date['email'];
            } else {
                if(!HTMLHelper::validEmail($this->post('email'))) $msg['errors']['email'] = $lang_ads['error_email_wrong'];
                else $ads['data']['email'] = $this->post('email');
            }
            
            if(!$this->post('mobile')) $ads['data']['mobile'] = $u_date['mobile'];
            else $ads['data']['mobile'] = $this->post('mobile');
            
            if(!$this->post('link_company') and $this->post('advert_vacance') == '0') {
                $msg['errors']['link_company'] = $lang_ads['error_publication'];
            } else {
                if ($this->post('link_company') and $this->post('advert_vacance') != '0') $msg['errors']['link_company'] = $lang_ads['error_double_link'];
                
                if($this->post('link_company') and $this->post('advert_vacance') == '0') {
                    if(HTMLHelper::validLinks($this->post('link_company'))) {
                        $ads['data']['company_url'] = $this->post('link_company');   
                    } else $msg['errors']['company_url'] = $lang_ads['error_link'];
                }
                
                if (!$this->post('link_company') and $this->post('advert_vacance') != '0'){
                    $ads['data']['seo_publication'] = $this->post('advert_vacance');
                    $ads['data']['company_url'] = '';
                }
            }
            
            if(!$this->post('show_date_start') or !$this->post('show_date_end')) $msg['errors']['show_date_start'] = $lang_ads['text_show_period'];
            else {
                $ads['data']['show_date_start'] = strtotime($this->post('show_date_start'));
                $ads['data']['show_date_end'] = strtotime($this->post('show_date_end'));
            }
            
            if(empty($msg['errors'])) {
                if($this->post('adsId')) {
                    $ads['data']['id'] = $this->post('adsId');
                    
                    if($_FILES['images_ads']['name']) {
                        $ads['data']['img'] = UploadHelper::UploadOneImage($_FILES['images_ads'], 'public/'.$this->post('adsId'));
                    } else {
                        $adsimg = AdscompanyModel::Instance()->SelectAdsImg($this->post('adsId'));
                        
                        if(empty($adsimg['img'])) $msg['errors']['images_ads'] = $lang_ads['empty_images_ads'];
                        else $ads['data']['img'] = $adsimg['img'];
                    }
                    
                    if (empty($msg['errors'])) {
                        AdscompanyModel::Instance()->UpdAds($ads['data']);
                        $msg['success'][] = $lang_ads['added_success'];
                    }
                } else {
                    $ads['data']['user_id'] = $u_date['u_id'];
                    $ads['data']['date_add'] = time();
                    $ads['data']['clicks'] = '0';
                    $last_id = AdscompanyModel::Instance()->NewAds($ads['data']);
                    if($_FILES['images_ads']['name']) {
                        $ads['data']['img'] = UploadHelper::UploadOneImage($_FILES['images_ads'], 'public/'.$last_id);
                        $ads['data']['id'] = $last_id;
                        
                        AdscompanyModel::Instance()->UpdAds($ads['data']);
                    } else $msg['errors']['images_ads'] = $lang_ads['empty_images_ads'];
                    
                    echo json_encode($msg);
                }
            }
       }
       
       public function action_delete () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
            
            $p_page = Router::getUriParam(2);
            if(empty($p_page)) {
                $this->redirect(Url::local('profile'));
            } else {
                $u_date = AuthClass::instance()->getUser();
                if($u_date['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
                
                $result_delete = DelHelper::DeleteImages('public/'.$p_page);
                
                if($result_delete) {
                    AdscompanyModel::Instance()->deleteAds($p_page);
                    $this->redirect('/adscompany');
                }
            }
        }
    }
?>