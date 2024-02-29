<?php
	class MessagesModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function getMessagesFromAdmin ($id) {
            return DBClass::Instance()->select(
                'message_for_user_from_admin',
                array('*'),
                'id_user = :id and read_status = 0',
                array('id' => (int)$id),
                '',
                'subject',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getAllMessagesFromUsers ($id) {
            return DBClass::Instance()->select(
                'messages_for_users as mfu left join '.DBClass::Instance()->config['db_pref'].'users as u on mfu.user_id_from = u.id left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on mfu.user_id_from = ud.user_id',
                array('mfu.*, u.login, u.email, ud.name, ud.lastname, ud.type_person, ud.user_img'),
                'id_user = :id',
                array('id' => (int)$id),
                '',
                'subject',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getAllMessagesForUsers ($id) {
            return DBClass::Instance()->select(
                'messages_for_users as mfu left join '.DBClass::Instance()->config['db_pref'].'users as u on mfu.user_id_from = u.id left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on mfu.user_id_from = ud.user_id',
                array('mfu.*, u.login, u.email, ud.name, ud.lastname, ud.type_person, ud.user_img'),
                'user_id_from = :id',
                array('id' => (int)$id),
                '',
                'subject',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function countMessagesFormAdmin ($id) {
            return DBClass::Instance()->getCount(
                'message_for_user_from_admin',
                'read_status = 0 and id_user = :id',
                array('id' => (int)$id),
                'id'
            );
        }
        
        public function countMessagesForUser ($id) {
            return DBClass::Instance()->getCount(
                'messages_for_users',
                'read_status = 0 and id_user = :id',
                array('id' => (int)$id),
                'id'
            );
        }
        
        public function updStatusMessage ($data) {
            return DBClass::Instance()->update('message_for_user_from_admin', $data, 'id = :id');
        }
        
        public function updStatusMessageFromUser ($data) {
            return DBClass::Instance()->update('messages_for_users', $data, 'id = :id');
        }
        
        public function RespondMessageFromContacts ($data) {
            return DBClass::Instance()->insert('messages_for_users_respond', $data);
        }
        
        public function getRespondMessages ($id, $email_to) {
            return DBClass::Instance()->select(
                'messages_for_users_respond',
                array('*'),
                'id_user_from = :id and email_to = :email_to',
                array('id' => (int)$id, 'email_to' => $email_to),
                '',
                'send_date',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function deleteMessageFromUser ($data) {
            DBClass::Instance()->deleteElement('messages_for_users', $data, '');
        }
	}
?>