<?php
	class UsersonlineModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function sql_update ($wine, $REMOTE_ADDR) {
            return DBClass::Instance()->DBAdmin('DELETE FROM tori_users_online WHERE `unix`+'.$wine.' < '.time().' OR `ip` = \''.$REMOTE_ADDR.'\'');
       }
       
       public function sql_insert ($REMOTE_ADDR) {
            return DBClass::Instance()->DBAdmin('INSERT INTO tori_users_online VALUES("","'.$REMOTE_ADDR.'","'.time().'")');   
       }
       
       public function sql_sel () {
            return DBClass::Instance()->select(
                'users_online',
                array('id'),
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
	}
?>