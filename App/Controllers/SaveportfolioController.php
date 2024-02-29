<?php
	class SaveportfolioController extends Controller {
        public function action_index() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           $u_data = AuthClass::instance()->getUser();
           if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
           
           $v = new View('account/saved_portfolio');
           $savednews = $this->lang('saveportfolio');
           
           $v->title = $savednews['title'];
           $v->description = '';
           $v->keywords = '';
           $v->text_adverts_dont_found = $savednews['text_adverts_dont_found'];
           
           $v->header = $this->module('Header');
           $v->profilemenu = $this->module('ProfileMenu');
           $v->footer = $this->module('Footer');
           
           $v->u_data = AuthClass::instance()->getUser();
           
           $v->portfolio_saved = SaveportfolioModel::Instance()->getListSavedPortfolioForProfile($v->u_data['u_id']);
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_save () {
            $lang_save = $this->lang('savednews');
            $p_Id = $this->post('p_id');
            
            $msg = array(
                'error' => '',
                'success' => '',
            );
            
            if(!AuthClass::instance()->isAuth()) {
                $msg['error'] = $lang_save['warning_register'];
            } else {
                $u_date = AuthClass::instance()->getUser();
                
                $res = SaveportfolioModel::Instance()->ifIssetSavedPortfolio($p_Id, $u_date['u_id']);

                if(empty($res['id'])) {
                    if($u_date['u_id'] != $p_Id) {
                        if(!SaveportfolioModel::Instance()->SaveportfolioForUser($p_Id, $u_date['u_id'])) $msg['success'] = 'Saved';
                        else $msg['error'] = $lang_save['error_saved'];
                    } else $msg['error'] = $lang_save['error_saved_news'];
                } else {
                    $msg['error'] = 'Alredy saved!';
                }
            }
            
            echo json_encode($msg);
        }
        
        public function action_trash () {
            if(!AuthClass::instance()->isAuth()) {
                $msg['error'] = $lang_save['warning_register'];
            } else {
                $u_date = AuthClass::instance()->getUser();
                $p_Id = (int)Router::getUriParam(2);
                
                $res = SaveportfolioModel::Instance()->ifIssetSavedPortfolio($p_Id, $u_date['u_id']);
                if(!empty($res['id'])) {
                    SaveportfolioModel::Instance()->trashSavedPortfolio($p_Id, $u_date['u_id']);
                }
            }
            $this->redirect(Url::local('saveportfolio'));
        }
	}
?>