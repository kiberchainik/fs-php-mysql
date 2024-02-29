<?php
	class ContactsModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
        public function getContacts (){
            return DBClass::Instance()->select('settings', array('admin_name, admin_mobile, admin_email, admin_adres'), '', '', '', '', '', '', '', '1');
        }
        
        public function addMessageFromContacts ($data){
            return DBClass::Instance()->insert('contacts', $data);
        }
    }
?>