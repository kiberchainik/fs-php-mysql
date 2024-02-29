<?php
	class BranchModel extends Model {
        private function __construct(){}
        private static $instance = NULL;
       
        public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
        }
        
        public function getListBranchForUser($id) {
            return DBClass::Instance()->select(
                'branch',
                array('*'),
				'id_user = :id',
				array('id' => (int)$id),
				'',
				'name_company',
				true,
				'',
				'',
				'2'
            );
        }
        
        public function getListBranch($id) {
            return DBClass::Instance()->select(
                'branch',
                array('*'),
				'id_user = :id',
				array('id' => $id),
				'',
				'',
				'',
				'',
				'',
				'2'
            );
        }

       //добавление новой вакансии
       public function newBranch($data) {
            DBClass::Instance()->insert('branch', $data);
       }
       
       public function getLogoBranch ($id) {
            return DBClass::Instance()->select(
                'branch',
                array('img'),
                'id = :id_b',
                array('id_b' => (int)$id),
                '',
                '',
                '',
                '',
				'',
                '1'
            );
       }
       
       public function countBranchOfUser ($id) {
            return DBClass::Instance()->getCount(
                'branch',
                'id_user = :id',
                array('id' => (int)$id),
                'id'
            );
        }
        
        public function branchSelect ($id_usr) {
            return DBClass::Instance()->select(
                'branch',
                array('id'),
                'id_user = :id_user and default_br = 1',
                array('id_user' => (int)$id_usr),
                '',
                '',
                '',
                '',
                '',
				'',
                '1'
            );
        }
        
        public function selectNameFilial ($id) {
            return DBClass::Instance()->select(
                'branch',
                array('name_company'),
                'id = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        /*public function branchDefault ($data) {
            return $this->dbPDO->update('branch', $data, 'id = :id');
        }*/

       //редактироване вакансий
       public function UpdBranch ($data) {
            return DBClass::Instance()->update('branch', $data, 'id = :id');
       }
       
       public function deleteBranch ($id) {
            DBClass::Instance()->deleteElement('branch', array('id' => $id), '');
       }
	}
?>