<?php
	class CommentsController extends Controller {
	   public function action_index() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $v = new View('account/comments');
           $lang_comments = $this->lang('comments');
           
           $v->title = $lang_comments['title'];
           $v->description = '';
           $v->keywords = '';
           $v->text_not_comments = $lang_comments['not_com_for_user'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $u_date = AuthClass::instance()->getUser();
           $v->commentsList = CommentsModel::Instance()->getAllCommentsForUserAdverts($u_date['u_id']);
           
           /*$page = (int)Router::getUriParam('page');
           $count = UsersModel::Instance()->getUsersCount();
           if($page < 1 or $page > $count) throw new RouteException('Invalide num page {'.$page.'}', 404);*/
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_new () {
            $lang_comments = $this->lang('comments');
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            if (!$this->post('lastname')) $msg['errors']['name'] = $lang_comments['error_empty_name'];
            if (!$this->post('authUserEmailFrom')) $msg['errors']['email'] = $lang_comments['error_empty_email'];
            else {
                if(!HTMLHelper::validEmail($this->post('authUserEmailFrom'))) {
                    $msg['errors']['email'] = $lang_comments['error_format_email'];
                }
            }
            
            $email_to = UsersModel::Instance()->getUserEmail($this->post('authorId'));
            if(empty($email_to['email'])) $msg['errors']['general_error'] = $lang_comments['error_send_message'];
            
            if(!$this->post('advId')) $msg['errors']['general_error'] = $lang_comments['error_send_message'];
            elseif(($this->post('authUserEmailFrom') == $this->post('authorEmail'))) $msg['errors']['general_error'] = $lang_comments['error_user_send'];
            
            if(AuthClass::instance()->isAuth()) {
                $u_id = AuthClass::instance()->getUser();
                
                if($u_id['u_id'] == $this->post('authorId')) $msg['errors']['textMessage'] = $lang_comments['error_empty_text'];
                else $authUserId = $u_id['u_id'];
                
            } else $authUserId = '0';
            
			if ($this->post('recommend') == '1') {
				$data['AdvertData']['recommend'] += 1;
				AdvertsModel::Instance()->UpdRecommendAdvert($data['AdvertData']['recommend'], $data['AdvertData']['id']);
			}
            if(!$this->post('textMessage')) $msg['errors']['textMessage'] = $lang_comments['error_empty_text'];
            if(empty($msg['errors'])) {
                $message = array(
                    'advert_id' => $this->post('advId'),
                    'name' => $this->post('lastname'),
                    'email' => $this->post('authUserEmailFrom'),
                    'user_id' => $authUserId,
                    'message' => $this->post('textMessage'),
                    'date' => time()
                );
                
                CommentsModel::Instance()->NewCommForAdvFromGuest($message);
                $sendMessage = EmailTPLHelper::SendEmail($this->post('authorEmail'), $lang_comments['message_from_site'].$this->post('advertTitle'), $this->post('textMessage'));
                $msg['success'][] = $lang_comments['send_success'];
            }
            /*echo '<pre>';
            print_r($post);
            echo '</pre>';*/
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