<?php
	class SavednewsModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function SaveNewsForUser ($id_adv, $id_user) {
            return DBClass::Instance()->insert('save_adverts_for_user', array('id_user' => (int)$id_user, 'id_adv' => (int)$id_adv));
        }
        
        public function SavedAdvert ($id) {
            return DBClass::Instance()->select(
                'save_adverts_for_user',
                array('*'),
                'id_adv = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getListSavedAdvertsForProfile ($id) {
            return DBClass::Instance()->select(
                'adverts as ad, save_adverts_for_user as sa',
                array('ad.id, ad.title, ad.seo, ad.description, ad.validate'),
                'sa.id_user = :user_id and ad.id = sa.id_adv',
                array('user_id' => (int)$id),
                '',
                'title',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function ifIssetSavedNews ($id_p, $id_u) {
            return DBClass::Instance()->select(
                'save_adverts_for_user',
                array('id'),
                'id_adv = :id_p and id_user = :id_u',
                array('id_p' => (int)$id_p, 'id_u' => $id_u),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function trashSavedNews ($id_p, $id_u) {
            return DBClass::Instance()->deleteElement('save_adverts_for_user', array('id_adv' => (int)$id_p, 'id_user' => (int)$id_u), '');
        }
        
        public function DeleteAdvertFromSaved ($id_user, $id_adv) {
            return DBClass::Instance()->deleteElement('save_adverts_for_user', array('id_user' => (int)$id_user, 'id_adv' => (int)$id_adv), '');
        }
	}
?>