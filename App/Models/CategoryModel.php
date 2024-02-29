<?php
	class CategoryModel extends Model {
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
                '2'
            );
        }
        
        public function getAdvertsForCategoryCount ($const = 5, $subCat = '') {
            if(!empty($subCat)){
                $from = ', '.DBClass::Instance()->config['db_pref'].'category_advert as ca, '.DBClass::Instance()->config['db_pref'].'category as c';
                $subCatIdWhere = ' and (c.seo = :id_category or c.id = :id_category) and c.id = ca.id_category and ca.id_advert = a.id';
                $params = array('id_category' => $subCat);
            } else {
                $from = '';
                $subCatIdWhere = '';
                $params = array();
            }
            
            $count = DBClass::Instance()->getCount(
                'adverts as a'.$from,
                'a.validate = 1 '.$subCatIdWhere,
                $params,
                'a.id'
            );
            
            return ceil($count['numCount']/$const);
       }
        
        public function getAdvertDataForCategoryPage ($pagenum, $const = 5, $subCat = '') {
            
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
            
            if(!empty($subCat)){
                $from = 'category as c, category_advert as ca, ';
                $subCatIdWhere = ' and (c.seo = :seo or c.id = :seo) and ca.id_category = c.id and a.id = ca.id_advert';
                $params = array('seo' => $subCat);
            } else {
                $from = '';
                $subCatIdWhere = '';
                $params = array();
            }
            
            return DBClass::Instance()->select(
                $from.'adverts as a LEFT JOIN '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai ON ai.main = 1 and ai.id_adv = a.id',
                array('a.id, a.title, a.seo, a.description, a.validate, ai.src'),
                'a.validate = 1'.$subCatIdWhere,
                $params,
                '',
                'title',
                true,
                $const,
                $offset,
                '2'
            );
        }
        
        public function getDataSubCategory ($id) {
            return DBClass::Instance()->getCount(
                'adverts as a, '.DBClass::Instance()->config['db_pref'].'category as c, '.DBClass::Instance()->config['db_pref'].'category_advert as ca',
                'c.seo = :seo and ca.id_category = c.id and a.id = ca.id_advert and a.validate = 1',
                array('seo' => $id),
                'title'
            );
        }
        
        public function getCategoryesForAdvert ($id) {
            $data = array();
            
            $data['mainCategory'] = DBClass::Instance()->select(
                'category_advert as ca, category as c, category_description as cd',
                array('c.seo, ca.id_category, cd.title'),
                'ca.id_advert = :ca_id and ca.mainCategory = 1 and c.id = ca.id_category and cd.category_id = ca.id_category and cd.lang_id = :lang',
                array('ca_id' => (int)$id, 'lang' => (int)$_SESSION['lid']),
                '',
                'title',
                '',
                '',
                '',
                '1'
            );
            
            $data['subCategory'] = DBClass::Instance()->select(
                'category_advert as ca, category as c, category_description as cd',
                array('c.seo, c.parent_id, ca.id_category, cd.title'),
                'ca.id_advert = :ca_id and ca.mainCategory = 0 and c.id = ca.id_category and cd.category_id = ca.id_category and cd.lang_id = :lang',
                array('ca_id' => (int)$id, 'lang' => (int)$_SESSION['lid']),
                '',
                'parent_id', 
                'true',
                '',
                '',
                '2'
            );
            
            return $data;
        }
        
        public function Selects ($mainCategory, $subCategory) {
            return DBClass::Instance()->select(
                'category as c, category_description as cd',
                array('c.id, cd.title'),
                'c.parent_id = :id_parent and c.id = cd.category_id and cd.lang_id = :lang',
                array('id_parent' => (int)$mainCategory, 'lang' => (int)$_SESSION['lid']),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getTitleCategoryVacancies ($id) {
            return DBClass::Instance()->select(
                'categoryvacancies_description as cd',
                array('cd.title'),
                '(cd.seo = :id or cd.category_id = :id) and cd.lang_id = :lang',
                array('id' => $id, 'lang' => (int)$_SESSION['lid']),
                '',
                'title',
                '',
                '',
                '',
                '1'
            );
        }
	}
?>