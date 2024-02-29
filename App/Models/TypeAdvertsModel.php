<?php
	class TypeAdvertsModel extends Model {
        private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
        
        public function TypesOfCategoryList($id_category, $lang) {
            return DBClass::Instance()->select(
                'type_adverts as ta, type_adverts_description as tad, category_typeadverts as cta', 
                array('tad.id_type, tad.name'), 
                'cta.id_category = :id_category and cta.id_type = tad.id_type and tad.id_lang = :id_lang and ta.active = :active and ta.id = tad.id_type', 
                array('id_lang' => (int)$lang, 'active' => 1, 'id_category' => (int)$id_category),
                '',
                'name',
                'false',
                '',
                '',
                '2');
        }
        
        public function getTypeOfAdvert ($id, $id_adv) {
            return DBClass::Instance()->select(
                'type_adverts as ta, type_adverts_description as tad, adverts as a', 
                array('tad.name'), 
                'a.id_type = :id_type and a.id = :id_adv and a.id_type = tad.id_type and tad.id_lang = :id_lang and ta.active = :active and ta.id =  a.id_type', 
                array('id_lang' => (int)$_SESSION['lang_id'], 'id_adv' => (int)$id_adv, 'active' => 1, 'id_type' => (int)$id),
                '',
                'name',
                'false',
                '',
                '',
                '1');
        }
        
        public function GetCountTypesAdverts () {
            return DBClass::Instance()->getCount('type_adverts');
        }
	}
?>