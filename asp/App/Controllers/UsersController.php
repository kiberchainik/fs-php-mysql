<?php
	class UsersController extends Controller {
	   public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_allusers');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getUsersCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->UserList = PrivateModel::Instance()->getUserList($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('users'));
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_life_search_user () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	        } else $this->redirect(Url::local('login'));
            $user = Router::getUriParam(2); // p. num
            $search_result = PrivateModel::Instance()->lifeSearchUser($user);
            echo json_encode($search_result);
        }
        
        public function action_details () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_users_details');
           $login = Router::getUriParam(2);
           $v->title = 'ЦУП: Детали пользователя';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->userDate = PrivateModel::Instance()->getUserDateForDetailsPage($login);
           $v->UserAdverts = PrivateModel::Instance()->getUserAdverts($v->userDate['id']);
           $v->review = PrivateModel::Instance()->getUserReview($v->userDate['id']);
           $v->portfolio = PrivateModel::Instance()->getUserPortfolio($v->userDate['id']);
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $login = Router::getUriParam(2);
           $getUserId = PrivateModel::Instance()->getUserId($login);
           
           PrivateModel::Instance()->deleteUser($getUserId['id']);
           
           $ifUserHaveAdv = PrivateModel::Instance()->getUserAdverts($getUserId['id']);
           if(!empty($ifUserHaveAdv)) {
               foreach ($ifUserHaveAdv as $k) {
                    AdvertsModel::Instance()->deleteAdvert($k['id']);
               }
           }
           DelHelper::DeleteImages('users/'.$getUserId);
           $this->redirect(Url::local('users'));
        }
        
        public function action_lock () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $this->redirect(Url::local('users'));
        }
    }
?>