<?php
	class VacancelocalModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function GetCategoryListWithoutParetnIdWithCountVacanciesForCategory($loc = '', $limit = '') {
            return DBClass::Instance()->select(
                'categoryvacancies as cv, categoryvacancies_description as cvd',
                array('cv.id, cvd.seo, cv.parent_id, cvd.title, (select count(id) from '.DBClass::Instance()->config['db_pref'].'vacancies where id_category = cv.id and location = :loc) as vacancies_count'),
                'cvd.category_id = cv.id AND cvd.lang_id = :lang_id',
                array('lang_id' => (int)$_SESSION['lid'], 'loc' => $loc),
                '',
                'title',
                'false',
                $limit,
                '',
                '2'
            );
        }
        
        public function getVacanciesPageLocation ($pagenum, $loc, $const = 5, $subCatId = '') {
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
            
            if($offset < $const) $offset = '';
            
            if(!empty($subCatId)){
                $subCatIdWhere = 'and (v.id_category = :id_category or cd.seo = :id_category)';
                $params = array('lang' => (int)$_SESSION['lid'], 'loc' => $loc, 'id_category' => $subCatId);
            } else {
                $subCatIdWhere = '';
                $params = array('lang' => (int)$_SESSION['lid'], 'loc' => $loc);
            }
            
            return DBClass::Instance()->select(
                'vacancies as v left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ud.user_id = v.id_user left join '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description as cd on v.id_category = cd.category_id and cd.lang_id = :lang',
                array('v.id, v.seo, v.title, v.date_add, v.short_desc, ud.user_id, ud.name, ud.lastname, ud.user_img, cd.title as category_title, cd.category_id as category_id'),
                'v.valid_status = 1 and v.location = :loc and v.id_category = cd.category_id '.$subCatIdWhere,
				$params,
                '',
                'date_add',
                '',
                $const,
                $offset,
                '2'
            );
       }
       
       public function getVacanciesCountLocation ($loc, $const = 5, $subCatId = '') {
            if(!empty($subCatId)){
                $subCatIdWhere = 'and (v.id_category = :id_category or cvd.seo = :id_category)';
                $params = array('loc' => $loc, 'lang' => (int)$_SESSION['lid'], 'id_category' => $subCatId);
            } else {
                $subCatIdWhere = '';
                $params = array('loc' => $loc, 'lang' => (int)$_SESSION['lid']);
            }
            
            $count = DBClass::Instance()->getCount(
                'vacancies as v, '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description as cvd',
                'v.valid_status = 1 and v.location = :loc and v.id_category = cvd.category_id and cvd.lang_id = :lang '.$subCatIdWhere,
                $params,
                'v.id'
            );
            
            return ceil($count['numCount']/$const);
       }
	}
?>