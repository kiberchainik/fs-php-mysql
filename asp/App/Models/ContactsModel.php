<?php
	class ContactsModel extends Model {
        private function __construct(){}
        private static $instance = NULL;
        
        public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
        }
        
        public function GetMessageList () {
            return DBClass::Instance()->select(
                'contacts',
                array('*'),
                '',
                array(),
                '',
                'name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function getRespond ($id) {
            return DBClass::Instance()->select(
                'contacts_respond',
                array('message'),
                'id_message = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function AddToSpam ($data) {
            DBClass::Instance()->insert('spamlist', $data);
            DBClass::Instance()->deleteElement('contacts', array('email_from' => $data['email']), '');
        }
        
        public function AddRespond ($data) {
            DBClass::Instance()->insert('contacts_respond', $data);
            DBClass::Instance()->update('contacts', array('read_status' => 1, 'id' => $data['id_message']), 'id = :id');
        }
        
        public function getUserDateForDetailsPage ($login) {
            return DBClass::Instance()->select(
                'users LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_date ON '.DBClass::Instance()->config['db_pref'].'user_date.user_id = '.DBClass::Instance()->config['db_pref'].'users.id LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_description ON '.DBClass::Instance()->config['db_pref'].'user_type_description.id_user_type = '.DBClass::Instance()->config['db_pref'].'users.userType AND '.DBClass::Instance()->config['db_pref'].'user_type_description.id_lang = \'1\'',
                array(DBClass::Instance()->config['db_pref'].'users.id, '.DBClass::Instance()->config['db_pref'].'users.validStatus, '.DBClass::Instance()->config['db_pref'].'users.login, '.DBClass::Instance()->config['db_pref'].'users.email, '.DBClass::Instance()->config['db_pref'].'users.onlineSatus, '.DBClass::Instance()->config['db_pref'].'user_date.about, '.DBClass::Instance()->config['db_pref'].'user_date.name, '.DBClass::Instance()->config['db_pref'].'user_date.lastname, '.DBClass::Instance()->config['db_pref'].'user_date.mobile, '.DBClass::Instance()->config['db_pref'].'user_date.country, '.DBClass::Instance()->config['db_pref'].'user_date.region, '.DBClass::Instance()->config['db_pref'].'user_date.town, '.DBClass::Instance()->config['db_pref'].'user_date.address, '.DBClass::Instance()->config['db_pref'].'user_date.patent, '.DBClass::Instance()->config['db_pref'].'user_date.user_img, '.DBClass::Instance()->config['db_pref'].'user_type_description.name AS nameType'),
                DBClass::Instance()->config['db_pref'].'users.login = :login or '.DBClass::Instance()->config['db_pref'].'users.id = :login',
                array('login' => $login),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function delete ($id) {
            DBClass::Instance()->deleteElement('contacts', array('id' => (int)$id), '');
        }
	}
?>