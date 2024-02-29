<?php
	class ModerationController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_adverts_moderation');
           
           $v->title = 'ЦУП: Все объявления';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->adverts = PrivateModel::Instance()->getAdvertListForModeration();
           
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_upd_valid () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $p_page = Router::getUriParam(2);
           
            PrivateModel::instance()->UpdValidStatus(array('validate' => 1, 'id' => $p_page));
            $this->redirect(Url::local('moderation'));
        }
	}
?>