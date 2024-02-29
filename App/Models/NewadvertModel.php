<?php
	class NewadvertModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function GetCategoryListWithoutParetnId() {
            return DBClass::Instance()->select(
                'category as c, category_description as cd', 
                array('c.id, c.seo, c.mediaSet, cd.title, c.imgicon, c.icon, (select count(id) from tori_category where parent_id = c.id) as parent'), 
                'c.id = cd.category_id and cd.lang_id = :lang_id and c.parent_id = :parent_id',
                array('lang_id' => (int)$_SESSION['lid'], 'parent_id' => 0),
                '',
                'title',
                'false',
                '',
                '',
                '2');
        }
        
        public function ParentSubCategoryList ($id_category, $lang) {
            return DBClass::Instance()->select(
                'category as c, category_description as cd',
                array('c.id, c.marker, cd.title'),
                'cd.category_id = c.id AND cd.lang_id = :lang_id AND c.parent_id = :parent_id',
                array('lang_id' => $lang, 'parent_id' => (int)$id_category),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
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
                '2'
            );
        }
        
        public function getFieldValues($id_field, $lang) {
            return DBClass::Instance()->select(
                'fields_value', 
                array('*'), 
                'id_field = :id_field and id_lang = :id_lang', 
                array('id_lang' => (int)$lang, 'id_field' => (int)$id_field),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getFieldsListForAdd ($id_cat, $id_type, $lang_id) {
            return DBClass::Instance()->select(
                'fields_category, fields_data, fields_types, fields_placeholder',
                array(DBClass::Instance()->config['db_pref'].'fields_data.*, 
                    '.DBClass::Instance()->config['db_pref'].'fields_category.id_group, 
                    '.DBClass::Instance()->config['db_pref'].'fields_placeholder.placeholder'),
                
                      DBClass::Instance()->config['db_pref'].'fields_placeholder.id_lang = :id_lang 
                AND '.DBClass::Instance()->config['db_pref'].'fields_placeholder.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id 
                AND '.DBClass::Instance()->config['db_pref'].'fields_category.id_category = :id_category 
                AND '.DBClass::Instance()->config['db_pref'].'fields_category.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id 
                AND '.DBClass::Instance()->config['db_pref'].'fields_types.id_type = :id_type 
                AND '.DBClass::Instance()->config['db_pref'].'fields_types.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id',
                
                array('id_lang' => (int)$lang_id, 'id_category' => (int)$id_cat, 'id_type' => (int)$id_type),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getFieldsListForEdit ($id_cat, $id_type, $id_adv, $lang_id) {
            return DBClass::Instance()->select(
                'fields_category, fields_data, fields_types, fields_placeholder, adverts_fields',
                array(DBClass::Instance()->config['db_pref'].'fields_data.*, 
                '.DBClass::Instance()->config['db_pref'].'fields_category.id_group, 
                '.DBClass::Instance()->config['db_pref'].'fields_placeholder.placeholder, 
                '.DBClass::Instance()->config['db_pref'].'adverts_fields.field_value as advert_field_value'),
                
                      DBClass::Instance()->config['db_pref'].'fields_placeholder.id_lang = :id_lang 
                AND '.DBClass::Instance()->config['db_pref'].'fields_placeholder.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id 
                AND '.DBClass::Instance()->config['db_pref'].'fields_category.id_category = :id_category 
                AND '.DBClass::Instance()->config['db_pref'].'fields_category.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id 
                AND '.DBClass::Instance()->config['db_pref'].'fields_types.id_type = :id_type 
                AND '.DBClass::Instance()->config['db_pref'].'fields_types.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id 
                AND '.DBClass::Instance()->config['db_pref'].'adverts_fields.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id 
                AND '.DBClass::Instance()->config['db_pref'].'adverts_fields.id_advert = :id_advert',
                
                array('id_lang' => (int)$lang_id, 'id_category' => (int)$id_cat, 'id_type' => (int)$id_type, 'id_advert' => $id_adv),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function addAdverts ($data) {
            DBClass::Instance()->insert('adverts', $data['data']);
            
            $last_id = DBClass::Instance()->getLastId();
            
            if(isset($data['subCategory']) or !empty($data['subCategory'])) {
                DBClass::Instance()->insert('category_advert', array('id_category' => (int)$data['mainCategory'], 'id_advert' => (int)$last_id, 'mainCategory' => 1));
                
                if(count($data['subCategory']) > 1) {
                    // Функция array_values() делает все ключи в виде цифр и упорядочивает их
                    // Последний ключ
                    $lastSubCategory = count(array_values($data['subCategory']))-1;
                    
                    foreach ($data['subCategory'] as $k => $v) {
                        if ($k != $lastSubCategory) DBClass::Instance()->insert('category_advert', array('id_category' => (int)$v, 'id_advert' => (int)$last_id));
                        else DBClass::Instance()->insert('category_advert', array('id_category' => (int)$v, 'id_advert' => (int)$last_id, 'mainCategoryAdvert' => 1));
                    }
                } else DBClass::Instance()->insert('category_advert', array('id_category' => (int)$data['subCategory'][0], 'id_advert' => (int)$last_id, 'mainCategoryAdvert' => 1));
            } else DBClass::Instance()->insert('category_advert', array('id_category' => (int)$data['mainCategory'], 'id_advert' => (int)$last_id, 'mainCategoryAdvert' => 1));
            
            
            /*$imgs = unserialize($data);
            foreach ($imgs as $k => $v) {
                if($k == '0') $main = '1';
                DBClass::Instance()->insert('advert_imgs', array('id_adv' => (int)$last_id, 'name_img_file' => substr($v, -15, -4), 'src' => $v, 'title' => '', 'desc' => '', 'main' => $main));
            }*/
            
            return $last_id;
        }
        
        public function updAdvertImgs($data, $adv_id) {
            $img = unserialize($data);
            
            foreach ($img as $k => $v) {
                if($k == 0) DBClass::Instance()->insert('advert_imgs', array('id_adv' => (int)$adv_id, 'name_img_file' => substr($v, -21, -4), 'src' => $v, 'main' => '1'));
                else DBClass::Instance()->insert('advert_imgs', array('id_adv' => (int)$adv_id, 'name_img_file' => substr($v, -21, -4), 'src' => $v));
            }
            
            if(isset($data['cover'])) DBClass::Instance()->insert('advert_imgs', array('id_adv' => (int)$adv_id, 'name_img_file' => substr($data['cover'], -21, -4), 'src' => $data['cover'], 'cover' => '1'));
        }
        
        public function addAdvertFields ($data) {
            foreach ($data as $k => $v) DBClass::Instance()->insert('adverts_fields', $v);
        }
	}
?>