<?php
	class PromoModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function getCategoryList () {
            return DBClass::Instance()->select(
                'category as c, category_description as cd',
                array('c.*, cd.title, cd.description, (select count('.DBClass::Instance()->config['db_pref'].'category_advert.id_advert) from '.DBClass::Instance()->config['db_pref'].'category_advert, '.DBClass::Instance()->config['db_pref'].'category where '.DBClass::Instance()->config['db_pref'].'category_advert.id_category = '.DBClass::Instance()->config['db_pref'].'category.id) as numAdvert'),
                'cd.category_id = c.id and cd.lang_id = 1',
                array(),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function ParentCategoryList () {
            $category = DBClass::Instance()->select(
                'promo_category as pc LEFT JOIN '.DBClass::Instance()->config['db_pref'].'promo_category_desc as pcd ON pcd.id_promo_cat = pc.id AND pcd.lang_id = \'1\'',
                array('pc.id, pc.parent_id, pcd.title'),
                '',
                array(),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
            
            $category_num = count($category);
            $cat = array();
            
        	for ($i = 0; $i < $category_num; $i ++) {
        	   $cat[$category[$i]['id']] = $category[$i];
        	}
            return $cat;
        }
        
        public function GetCategoryData($id) {
            $categoryData = DBClass::Instance()->select(
                'promo_category',
                array('*'),
                'id = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
            
            $query = DBClass::Instance()->select(
                'lang LEFT JOIN '.DBClass::Instance()->config['db_pref'].'promo_category_desc as pcd ON pcd.id_promo_cat = :id',
                array('pcd.title, pcd.description, pcd.keywords, pcd.lang_id'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and pcd.lang_id = '.DBClass::Instance()->config['db_pref'].'lang.id',
                array('id' => (int)$id, 'lang_status' => '1'),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
            
            foreach($query as $k => $v) {
                $rezult[$v['lang_id']] = array(
                    'title' => $v['title'],
                    'description' => $v['description'],
                    'keywords' => $v['keywords']
                );
            }
            
            $categoryData['category_description'] = $rezult;
            return $categoryData;
       }
       
       public function UpdateCategory ($data, $id, $category_description) {
            DBClass::Instance()->update('promo_category', $data, 'id = :id');
            
            DBClass::Instance()->deleteElement('promo_category_desc', array('id_promo_cat' => (int)$id));
            foreach($category_description as $k => $v){
                DBClass::Instance()->insert('promo_category_desc', array('id_promo_cat'  => (int)$id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
        }
        
        public function AddNewCategory ($Data, $cd) {
            DBClass::Instance()->insert('promo_category', $Data);
            $category_id = DBClass::Instance()->getLastId();
            
            foreach($cd as $k => $v){
                DBClass::Instance()->insert('promo_category_desc', array('id_promo_cat' => (int)$category_id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
        }
       
       public function getSeotitle ($id) {
            return DBClass::Instance()->select(
                'promo_category',
                array('seo'),
                'id = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function deletecategory ($id) {
            DBClass::Instance()->deleteElement('promo_category', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('promo_category_desc', array('id_promo_cat' => (int)$id));
        }
    }
?>