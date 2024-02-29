<?php
	class ContactsController extends Controller {
	   public function action_index() {
	       $v = new View('site/contacts');
           $contacts = $this->lang('contacts');
           
           $v->title = $contacts['title'];
           $v->description = $contacts['description'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->leftsidebar = $this->module('LeftSidebar');
           
           if(AuthClass::instance()->isAuth()) {
                $u_date = AuthClass::instance()->getUser();
                $v->authUser = $u_date['u_id'];
                $v->authUserEmail = $u_date['email'];
                $v->name = $u_date['lastname'].' '.$u_date['name'];
           } else {
                $v->authUserId = '';
                $v->authUserEmail = '';
                $v->name = '';
           }
           
           $v->text_name = $contacts['name'];
           $v->text_subject = $contacts['subject'];
           $v->text_message = $contacts['message'];
           $v->text_send = $contacts['send'];
           $v->text_error_captcha = $contacts['error_captcha'];
           
           $v->contacts = ContactsModel::Instance()->getContacts();
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_support () {
            if(AuthClass::instance()->isAuth()) $u_date = AuthClass::instance()->getUser();
            
            $msg = array(
                'errors' => array(),
                'success' => ''
            );
            
            $text_contacts = $this->lang('contacts');
            $text_emailtpl = $this->lang('emailtpl');
            
            require_once (DOCROOT.'Helpers/autoload.php');
            if ($this->post('g-recaptcha-response')) {
                // создать экземпляр службы recaptcha, используя секретный ключ
                $recaptcha = new \ReCaptcha\ReCaptcha('6LeU_mMfAAAAAEOQ2MV0olYTXKLbTeY2l47CT_bh');
                // получить результат проверки кода recaptcha
                $resp = $recaptcha->verify($this->post('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
                // если результат положительный, то...
                if ($resp->isSuccess()){
                    if (!$this->post('name')) $msg['errors']['name'] = $text_contacts['error_empty_name'];
                    if (!$this->post('subject')) $msg['errors']['subject'] = $text_contacts['error_empty_subject'];
                    if (!$this->post('email')) $msg['errors']['email'] = $text_contacts['error_empty_email'];
                    else {
                        if(!HTMLHelper::validEmail($this->post('email'))) {
                            $msg['errors']['email'] = $text_contacts['error_format_email'];
                        }
                    }
                    //if(isset($post['authUserId']) and empty($post['authUserId'])) $msg['errors'][] = $addadvert['error_send_message'];
                    if(!$this->post('message')) $msg['errors']['message'] = $text_contacts['error_empty_text'];
                    
                    if(empty($msg['errors'])) {
                        $message = array(
                            'user_id' => (!AuthClass::instance()->isAuth())?'0':$u_date['u_id'],
                            'name_from' => $this->post('name'),
                            'email_from' => $this->post('email'),
                            'subject' => $this->post('subject'),
                            'message' => '<b>Message:</b> '.$this->post('message').'<br />From: '.$this->post('email'),
                            'date' => time()
                        );
                        
                        ContactsModel::Instance()->addMessageFromContacts($message);
                        
                        $replace_body = array(
                            '{usenName}' => $this->post('name'),
                            '{from_email}' => $this->post('email'),
                            '{message}' => $this->post('message')
                        );
                        $reg_body = str_replace(array_keys($replace_body), array_values($replace_body), $text_contacts['new_email_from_contacts_body']);
                        
                        $replace = array(
                            '{title}' => $text_contacts['new_email_from_contacts_title'],
                            '{body}' => $reg_body,
                            '{btn}' => $text_contacts['new_email_from_contacts_btn']
                        );
                        $message_HTML = str_replace(array_keys($replace), array_values($replace), $text_emailtpl['contacts']);
        
                        $message_without_HTML = $text_contacts['new_email_from_contacts_title'].$reg_body;
                        $send = EmailTPLHelper::SendEmail('support@findsol.it', $this->post('subject'), $message_HTML, $message_without_HTML);
                        
                        $msg['success'] = $text_contacts['send_success'];
                    }
                } else $msg['errors']['error_captcha'] = $text_contacts['error_captcha'];
            } else $msg['errors']['empty_captcha'] = $text_contacts['empty_captcha'];
            /*echo '<pre>';
            print_r($post);
            echo '</pre>';*/
            echo json_encode($msg);
       }
    }
?>