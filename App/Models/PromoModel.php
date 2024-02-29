<?php
	class PromoModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function GetCategoryListWithoutParetnId() {
            return DBClass::Instance()->select(
                'promo_category as c, promo_category_desc as cd', 
                array('c.id, c.seo, cd.title, c.icon, (select count(id) from tori_category where parent_id = c.id) as parent'), 
                'c.id = cd.id_promo_cat and cd.lang_id = :lang_id and c.parent_id = :parent_id',
                array('lang_id' => (int)$_SESSION['lid'], 'parent_id' => 0),
                '',
                'title',
                'false',
                '',
                '',
                '2'
            );
        }
        
        public function ParentSubCategoryList ($id_category, $lang) {
            return DBClass::Instance()->select(
                'promo_category as c, promo_category_desc as cd',
                array('c.id, cd.title'),
                'cd.id_promo_cat = c.id AND cd.lang_id = :lang_id AND c.parent_id = :parent_id',
                array('lang_id' => $lang, 'parent_id' => (int)$id_category),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
        }
    }
?>