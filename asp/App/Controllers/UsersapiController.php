<?php
	class UsersapiController extends Controller {
	   public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_users_api');
           
           $v->title = 'ЦУП: Api доступ';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getAPIUsersCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->UserList = PrivateModel::Instance()->getAPIUserList($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('users'));
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
           PrivateModel::Instance()->deleteUserAPI($id);
           
           $this->redirect(Url::local('usersapi'));
        }
    }
?>