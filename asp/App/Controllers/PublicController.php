<?php
	class PublicController extends Controller {
	   public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_public');
           
           $v->title = 'ЦУП: Пользовательская реклама';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->public = PublicModel::Instance()->GetPublicList();
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_updstatus () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           $statusofpublic = PublicModel::Instance()->GetStatusOfPublic($id);
           
           if($statusofpublic['valid_status'] == '0') PublicModel::Instance()->UpdStatusOfPublic(array('id' => $id, 'valid_status' => '1'));
           else PublicModel::Instance()->UpdStatusOfPublic(array('id' => $id, 'valid_status' => '0'));
           
           $this->redirect(Url::local('public'));
        }
        
        public function action_updshowstatus () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           $status = PublicModel::Instance()->GetStatusShowOfPublic($id);
           
           if($status['show_status'] == '0') PublicModel::Instance()->UpdShowStatusOfPublic(array('id' => $id, 'show_status' => '1'));
           else PublicModel::Instance()->UpdShowStatusOfPublic(array('id' => $id, 'show_status' => '0'));
           
           $this->redirect(Url::local('public'));
        }
        
        public function action_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            DelHelper::DeleteFile('images/blog/articles/'.$img[4].'/'.$img[5]);
            PublicModel::Instance()->deletePublicCompany($id);
            
            $this->redirect(Url::local('public'));
        }
    }
?>