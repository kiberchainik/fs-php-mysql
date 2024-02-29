<?php
	class CommentsController extends Controller {
	   public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_comments');
           
           $v->title = 'ЦУП: Пользовательские коммнетраии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->comments = PrivateModel::Instance()->GetComList();
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_comments_respond() {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            
            $add = array(
                'parent_id' => $id,
                'email' => ($u_date['email'])?$u_date['email']:$this->post('email'),
                'name' => ($u_date['name'])?$u_date['name']:$this->post('name'),
                'date' => time(),
                'advert_id' => $this->post('advert_id'),
                'user_id' => ($u_date['u_id'])?$u_date['u_id']:'0',
                'message' => $this->post('message'),
                'moderation' => '0',
                'plus' => '0',
                'minus' => '0'
            );
            
            PrivateModel::Instance()->AddCommentRespond($add);
            $message = 'New reply to comment from Administration: <br />'.$this->post('message');
            EmailTPLHelper::SendEmail($this->post('email'), 'New reply to comment FQ', $message);
            
            $this->redirect(Url::local('comments'));
        }
        
        public function action_comments_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->UpdValidCommentStatus($id);
            $this->redirect(Url::local('comments'));
        }
        
        public function action_comments_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->deleteComment($id);
            $this->redirect(Url::local('comments'));
        }
	}
?>