<?php
	class AdscompanyModel {
        private function __construct(){}
        private static $instance = NULL;
        
        public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
        }
        
        public function getPublicList ($id) {
            return DBClass::Instance()->select(
                'publiccompany',
                array('*'),
                'user_id = :user',
                array('user' => (int)$id),
                '',
                'title',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function NewAds ($data) {
            DBClass::Instance()->insert('publiccompany', $data);
            
            return DBClass::Instance()->getLastId();
        }
        
        public function getClicks ($id) {
            return DBClass::Instance()->select(
                'public_clics',
                array('MAX(date_click) AS date, COUNT(date_click) AS clicks'),
                'id_public = :id GROUP BY (date_click)',
                array('id' => (int)$id),
                '',
                'date_click',
                false,
                '',
                '',
                '2'
            );
        }
        
        public function getUserPublicForEdit ($id) {
            return DBClass::Instance()->select(
                'publiccompany',
                array('*'),
                'id = :id',
                array('id' => (int)$id),
                '',
                '',
                true,
                '',
                '',
                '1'
            );
        }
        
        public function SelectAdsImg ($id) {
            return DBClass::Instance()->select(
                'publiccompany', 
                array('img'),
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
        
        public function SelectAdsId ($id) {
            return DBClass::Instance()->select(
                'publiccompany', 
                array('id'),
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
        
        public function UpdAds ($data) {
            return DBClass::Instance()->update('publiccompany', $data, 'id = :id');
        }
        
        public function AdsLastId () {
            return DBClass::Instance()->getLastId();
        }
        
        public function deleteAds ($id) {
            DBClass::Instance()->deleteElement('publiccompany', array('id' => (int)$id), '');
        }
	}
?>