<?php
	class SavednewsController extends Controller {
        public function action_index() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $v = new View('account/savednews');
           $savednews = $this->lang('savednews');
           
           $v->title = $savednews['title'];
           $v->description = '';
           
           $v->header = $this->module('Header');
           $v->profilemenu = $this->module('ProfileMenu');
           $v->footer = $this->module('Footer');
           $v->text_company = $savednews['company'];
           $v->text_adverts_dont_found = $savednews['adverts_dont_found'];
           $v->profile_data = AuthClass::instance()->getUser();
           
           $profile_saved_adverts = SavednewsModel::Instance()->getListSavedAdvertsForProfile($v->profile_data['u_id']);
           foreach ($profile_saved_adverts as $k => $ad) {
                $listImgsAdverts = ProfileModel::Instance()->getListImagesAdvert($profile_saved_adverts[$k]['id']);
                if($listImgsAdverts['count'] > 0) $profile_saved_adverts[$k]['imgs'] = $listImgsAdverts['list'];
            }
            $v->profile_adverts = $profile_saved_adverts;
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_save () {
            $lang_save = $this->lang('savednews');
            $advId = $this->post('advid');
            $authorid = $this->post('u_id');
            
            $msg = array(
                'error' => '',
                'success' => '',
            );
            
            if(!AuthClass::instance()->isAuth()) {
                $msg['error'] = $lang_save['warning_register'];
            } else {
                $u_date = AuthClass::instance()->getUser();
                
                if($u_date['u_id'] != $authorId) {
                    if(!SavednewsModel::Instance()->SaveNewsForUser($advId, $u_date['u_id'])) $msg['success'] = $lang_save['saved_success'];
                    else $msg['error'] = $lang_save['error_saved'];
                } else $msg['error'] = $lang_save['error_saved_news'];
            }
            
            echo json_encode($msg);
        }
        
        public function action_trash () {
            if(!AuthClass::instance()->isAuth()) {
                $msg['error'] = $lang_save['warning_register'];
            } else {
                $u_date = AuthClass::instance()->getUser();
                $p_Id = (int)Router::getUriParam(2);
                
                $res = SavednewsModel::Instance()->ifIssetSavedNews($p_Id, $u_date['u_id']);
                if(!empty($res['id'])) {
                    SavednewsModel::Instance()->trashSavedNews($p_Id, $u_date['u_id']);
                }
            }
            $this->redirect(Url::local('saveportfolio'));
        }
	}
?>