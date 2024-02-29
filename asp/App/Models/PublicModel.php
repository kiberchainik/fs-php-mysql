<?php
	class PublicModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function GetPublicList () {
            return DBClass::Instance()->select(
                'publiccompany as p left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ud.user_id = p.user_id',
                array('p.*, ud.name as user_name, ud.lastname as user_lastname, ud.company_name, ud.patent, ud.user_img'),
                '',
                array(),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetStatusOfPublic ($id) {
            return DBClass::Instance()->select(
                'publiccompany',
                array('valid_status'),
                'id = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function UpdStatusOfPublic ($upd) {
            return DBClass::Instance()->update('publiccompany', $upd, 'id = :id');
        }
        
        public function GetStatusShowOfPublic ($id) {
            return DBClass::Instance()->select(
                'publiccompany',
                array('show_status'),
                'id = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function UpdShowStatusOfPublic ($upd) {
            return DBClass::Instance()->update('publiccompany', $upd, 'id = :id');
        }
        
        public function deletePublicCompany ($id) {
            DBClass::Instance()->deleteElement('publiccompany', array('id' => (int)$id));
        }
	}
?>