<?php
	class ContactsController extends Controller {
	   public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_contacts');
           
           $v->title = 'ЦУП: Пользовательские письма';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $MessageList = ContactsModel::Instance()->GetMessageList();
            
            foreach ($MessageList as $k => $val) {
                if (!empty($val['user_id'])) {
                    $MessageList[$k]['userData'] = ContactsModel::Instance()->getUserDateForDetailsPage($val['user_id']);
                    $MessageList[$k]['respond_msg']  = ContactsModel::Instance()->getRespond($val['id']);
                }
            }
            $v->MessageList = $MessageList;
            /*echo '<pre>';
            print_r($data['MessageList']);
            echo '</pre>';*/
            
            $v->useTemplate();
           $this->response($v);
        }
        
        public function action_respond() {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $m_id = Router::getUriParam(2);
            
            if($this->post('subject')) {
                $add = array(
                    'id_message' => $m_id,
                    'user_id' => ($this->post('user_id_to'))?'0':$this->post('user_id_to'),
                    'user_name_to' => $this->post('user_name_to'),
                    'subject' => $this->post('subject'),
                    'email_to' => $this->post('user_email_to'),
                    'message' => $this->post('message'),
                    'date_send' => time()
                );
                
                ContactsModel::Instance()->AddRespond($add);
                $message = 'Message from Administration: <br />'.$this->post('message');
                EmailTPLHelper::SendEmail($this->post('user_email_to'), $this->post('subject'), $message);
                
                $this->redirect(Url::local('contacts'));
            }
        }
        
		public function action_spamlist () {
			if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
			$add = Router::getUriParam(2);
			ContactsModel::Instance()->AddToSpam($add);
		}

        public function action_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $arg = Router::getUriParam(2);
            
            if(ContactsModel::Instance()->delete($arg)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Сообщение удалено';
            }
            
            $this->redirect(Url::local('contacts'));
        }
    }
?>