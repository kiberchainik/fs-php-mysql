<?php
	class CompanyModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function GetCategoryList($limit = '') {
            return DBClass::Instance()->select(
                'type_company_description as cd', 
                array('cd.id_type, cd.name, (select count(id_user) from '.DBClass::Instance()->config['db_pref'].'user_type_company where id_type_company = cd.id_type) as company_count'), 
                'id_lang = :lang_id',
                array('lang_id' => (int)$_SESSION['lid']),
                '',
                'name',
                true,
                $limit,
                '',
                '2'
            );
        }
        
        public function selectNameCompany ($id) {
            return DBClass::Instance()->select(
                'user_date', 
                array('company_name'), 
                'user_id = :id and type_person = 4',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        /*public function getListCompanyForCategory($id_category) {
            return DBClass::Instance()->select(
                'user_date as u, type_company as tc, user_type_company as utc', 
                array('u.user_id, u.company_name, u.user_img, u.company_link, u.about'), 
                'utc.id_user = u.user_id AND utc.id_type_company = tc.id AND tc.id = :id_category',
                array('id_category' => (int)$id_category),
                '',
                'company_name',
                '',
                '15',
                '',
                '2'
            );
        }*/
        
        public function getCompanyPage ($pagenum, $const = 5, $subCatId = '') {
            
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
            
            if(!empty($subCatId)){
                $from = ', type_company as tc, user_type_company as utc';
                $subCatIdWhere = ' and utc.id_user = ud.user_id AND utc.id_type_company = tc.id AND tc.id = :id_category';
                $params = array('id_category' => $subCatId);
            } else {
                $from = '';
                $subCatIdWhere = '';
                $params = array();
            }
            
            return DBClass::Instance()->select(
                'users as u, user_date as ud'.$from,
                array('u.login, ud.user_id, ud.company_name, ud.user_img, ud.company_link, ud.about'), 
                'ud.type_person = \'4\' and u.id = ud.user_id'.$subCatIdWhere,
                $params, 
                '', 
                'company_name', 
                true,
                $const,
                $offset,
                '2'
            );
        }
        
        public function getCompanyCount ($const = 5, $subCatId = '') {
            if(!empty($subCatId)){
                $from = ', '.DBClass::Instance()->config['db_pref'].'type_company as tc, '.DBClass::Instance()->config['db_pref'].'user_type_company as utc';
                $subCatIdWhere = ' and utc.id_user = ud.user_id AND utc.id_type_company = tc.id AND tc.id = :id_category';
                $params = array('id_category' => (int)$subCatId);
            } else {
                $from = '';
                $params = array();
                $subCatIdWhere = '';
            }
            
            $count = DBClass::Instance()->getCount(
                'users as u, '.DBClass::Instance()->config['db_pref'].'user_date as ud'.$from,
                'ud.type_person = 4 and u.id = ud.user_id '.$subCatIdWhere,
                $params,
                'ud.user_id'
            );
            
            return ceil($count['numCount']/$const);
       }
        
        public function getListCompany($limit = '') {
            return DBClass::Instance()->select(
                'user_date', 
                array('user_id, company_name, user_img, company_link, about'), 
                'type_person = 4',
                array(),
                '',
                'company_name',
                '',
                $limit,
                '',
                '2'
            );
        }
        
        public function getDataCompany ($id) {
            return DBClass::Instance()->select(
                'users  
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_date ON '.DBClass::Instance()->config['db_pref'].'users.id = '.DBClass::Instance()->config['db_pref'].'user_date.user_id
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type ON '.DBClass::Instance()->config['db_pref'].'user_type.index = '.DBClass::Instance()->config['db_pref'].'user_date.type_person
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_company ON '.DBClass::Instance()->config['db_pref'].'user_type_company.id_user = '.DBClass::Instance()->config['db_pref'].'user_date.user_id
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'type_company_description ON '.DBClass::Instance()->config['db_pref'].'type_company_description.id_lang = 1 AND '.DBClass::Instance()->config['db_pref'].'type_company_description.id_type = '.DBClass::Instance()->config['db_pref'].'user_type_company.id_type_company 
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_description ON '.DBClass::Instance()->config['db_pref'].'user_type_description.id_user_type = '.DBClass::Instance()->config['db_pref'].'user_date.type_person and '.DBClass::Instance()->config['db_pref'].'user_type_description.id_lang = :lang_id',
                array(DBClass::Instance()->config['db_pref'].'user_date.*, '.DBClass::Instance()->config['db_pref'].'users.login, '.DBClass::Instance()->config['db_pref'].'users.onlineSatus, '.DBClass::Instance()->config['db_pref'].'users.email, '.DBClass::Instance()->config['db_pref'].'user_type.type, '.DBClass::Instance()->config['db_pref'].'user_type_description.name as userTypeName, '.DBClass::Instance()->config['db_pref'].'type_company_description.name as companyName, '.DBClass::Instance()->config['db_pref'].'type_company_description.id_type as idTypeCompany'),
                '('.DBClass::Instance()->config['db_pref'].'users.id = :id or '.DBClass::Instance()->config['db_pref'].'users.login = :id or '.DBClass::Instance()->config['db_pref'].'user_date.company_name = :id) and '.DBClass::Instance()->config['db_pref'].'user_date.type_person = 4',
                array('id' => $id, 'lang_id' => (int)$_SESSION['lid']),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getListAdvertsProfile ($id_user) {
            return DBClass::Instance()->select(
                'adverts as ad left join '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai on ai.id_adv = ad.id and ai.main = 1',
                array('ad.id, ad.idUser, ad.title, ad.seo, ad.description, ad.add_date, ai.src'),
                'ad.idUser = :user_id and ad.validate = 1',
                array('user_id' => (int)$id_user),
                '',
                '',
                false,
                '',
                '',
                '2'
            );
        }
        
        public function getListVacanciesForUser($id) {
            return DBClass::Instance()->select(
                'vacancies',
                array('id, id_user, seo, title, short_desc, date_add'),
				'id_user = :id',
				array('id' => (int)$id),
				'',
				'title',
				true,
				'',
                '',
				'2'
            );
        }
        
        public function getListBranchOfCompany($id) {
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
	}
?>