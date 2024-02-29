<?php
	class VacanciesModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
        /*public function getListVacanciesForMain($limit) {
            return DBClass::Instance()->select(
                'vacancies as v, user_date as ud, categoryvacancies as cv, categoryvacancies_description as cd',
                array('v.id, v.seo, v.title, v.short_desc, v.views, v.date_add, ud.user_id, ud.name, ud.lastname, ud.user_img, cd.title as category_title, cv.seo as category_seo'),
				'v.id_category = cd.category_id and v.id_category = cv.id and cd.lang_id = :lang and ud.user_id = v.id_user and valid_status = 1 and views != 0',
				array('lang' => (int)$_SESSION['lid']),
				'',
				'views',
				true,
				$limit,
                '',
				'2'
            );
        }*/
        
        public function getLisNewVacanciesForMain() {
            return DBClass::Instance()->select(
                'vacancies as v left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ud.user_id = v.id_user left join '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description as cd on v.id_category = cd.category_id and cd.lang_id = :lang',
                array('v.id, v.title, v.date_add, v.short_desc, v.location, v.valid_status, ud.user_id, ud.name, ud.lastname, ud.user_img, cd.title as category_title, cd.category_id as category_id'),
                'valid_status = 0 ',
				array('lang' => (int)$_SESSION['lid']),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getNumVacanciesOfUser ($u_id) {
            return DBClass::Instance()->getCount('vacancies', 'id_user = :id', array('id' => $u_id));
        }
        
        public function getTitleOfVacance($id) {
            return DBClass::Instance()->select(
                'vacancies as v',
                array('v.title, v.seo'),
				'v.id = :id',
				array('id' => (int)$id),
				'',
				'',
				'',
				'',
                '',
				'1'
            );
        }
        
        /*public function getLisNewVacanciesForMain() {
            return DBClass::Instance()->select(
                'vacancies as v, user_date as ud, categoryvacancies as cv, categoryvacancies_description as cd',
                array('v.id, v.seo, v.title, v.short_desc, v.views, v.date_add, ud.user_id, ud.name, ud.lastname, cd.title as category_title, cv.seo as category_seo, cd.category_id as category_id'),
				'v.id_category = cd.category_id and v.id_category = cv.id and cd.lang_id = :lang and ud.user_id = v.id_user and valid_status = 1',
				array('lang' => (int)$_SESSION['lid']),
				'',
				'date_add',
				'',
				'12',
				'2'
            );
        }*/
        
        public function GetCategoryListWithoutParetnId($limit = '') {
            $category = DBClass::Instance()->select(
                'categoryvacancies as cv, categoryvacancies_description as cvd',
                array('cv.id, cv.seo, cv.parent_id, cvd.title'),
                'cvd.category_id = cv.id AND cvd.lang_id = :lang_id',
                array('lang_id' => (int)$_SESSION['lid']),
                '',
                'title',
                'false',
                $limit,
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
        
        public function GetCategoryListWithoutParetnIdWithCountPortfolioList($limit = '') {
            return DBClass::Instance()->select(
                'categoryvacancies as cv, categoryvacancies_description as cvd',
                array('cv.id, cv.seo, cv.parent_id, cvd.title, (select count(id_portfolio) from '.DBClass::Instance()->config['db_pref'].'categori_portfolio where id_category = cv.id) as port_count'),
                'cvd.category_id = cv.id AND cvd.lang_id = :lang_id',
                array('lang_id' => (int)$_SESSION['lid']),
                '',
                'title',
                'false',
                $limit,
                '',
                '2'
            );
        }
        
        public function GetCategoryListWithoutParetnIdWithCountVacanciesForCategory($limit = '') {
            return DBClass::Instance()->select(
                'categoryvacancies as cv, categoryvacancies_description as cvd',
                array('cv.id, cv.seo, cv.parent_id, cvd.title, (select count(id) from '.DBClass::Instance()->config['db_pref'].'vacancies where id_category = cv.id) as vacancies_count'),
                'cvd.category_id = cv.id AND cvd.lang_id = :lang_id',
                array('lang_id' => (int)$_SESSION['lid']),
                '',
                'title',
                'false',
                $limit,
                '',
                '2'
            );
        }

       public function getVacanciesPage ($pagenum, $const = 5, $subCatId = '') {
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
            
            if(!empty($subCatId)){
                $subCatIdWhere = 'and v.id_category = :id_category';
                $params = array('lang' => (int)$_SESSION['lid'], 'id_category' => $subCatId);
            } else {
                $subCatIdWhere = '';
                $params = array('lang' => (int)$_SESSION['lid']);
            }
            
            return DBClass::Instance()->select(
                'vacancies as v left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ud.user_id = v.id_user left join '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description as cd on v.id_category = cd.category_id and cd.lang_id = :lang',
                array('v.id, v.title, v.date_add, v.short_desc, v.location, v.valid_status, ud.user_id, ud.name, ud.lastname, ud.user_img, cd.title as category_title, cd.category_id as category_id'),
                'valid_status = 1 '.$subCatIdWhere,
				$params,
                '',
                'title',
                true,
                $const,
                $offset,
                '2'
            );
       }
       
       public function getVacanciesCount ($const = 5, $subCatId = '') {
            if(!empty($subCatId)){
                $subCatIdWhere = 'and id_category = :id_category';
                $params = array('id_category' => $subCatId);
            } else {
                $subCatIdWhere = '';
                $params = array();
            }
            
            $count = DBClass::Instance()->getCount(
                'vacancies',
                'valid_status = 1 '.$subCatIdWhere,
                $params
            );
            
            return ceil($count['numCount']/$const);
       }

       public function getListProfileVacancies($id) {
            return DBClass::Instance()->select(
                'vacancies as v, categoryvacancies_description as cd',
                array('v.*, cd.title as category_title, cd.category_id as cat_id'),
				'v.id_user = :user_id and v.id_category = cd.category_id and cd.lang_id = :lang',
				array('user_id' => $id, 'lang' => (int)$_SESSION['lid']),
				'',
				'title',
				true,
				'',
				'',
				'2'
            );
        }
        
        public function getListProfileVacanciesForAds($id_user) {
            return DBClass::Instance()->select(
                'vacancies',
                array('id, title, seo'),
				'id_user = :user_id',
				array('user_id' => $id_user),
				'',
				'title',
				true,
				'',
				'',
				'2'
            );
        }
        
        public function getCountSeoVacance ($seo) {
            return DBClass::Instance()->getCount('vacancies', 'seo = :seo', array('seo' => $seo), 'seo');
        }

       //���������� ����� ��������
       public function AddNewVacance($data) {
            DBClass::Instance()->insert('vacancies', $data);
            
            return DBClass::Instance()->getLastId();
       }

       //������������� ��������
       public function UpdVacancies ($data) {
            return DBClass::Instance()->update('vacancies', $data, 'id = :id');
       }
       
       public function UpdRequirements ($requirements, $id) {
            DBClass::Instance()->deleteElement('requirements', array('id_vacancy' => $id), '');
            foreach ($requirements as $rm) {
                DBClass::Instance()->insert('requirements', $rm);
            }
       }
       
       public function deleteVacancies ($id) {
            DBClass::Instance()->deleteElement('vacancies', array('id' => $id), '');
            DBClass::Instance()->deleteElement('requirements', array('id_vacancy' => $id), '');
       }
       
       public function AddRequirements ($requirements) {
            foreach ($requirements as $rm) {
                DBClass::Instance()->insert('requirements', $rm);
            }
       }
       
       public function getDataVacancies ($id) {
            return DBClass::Instance()->select(
                'vacancies as v left join '.DBClass::Instance()->config['db_pref'].'users as u on v.id_user = u.id left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on v.id_user = ud.user_id  left join '.DBClass::Instance()->config['db_pref'].'branch as ub on ud.user_id = ub.id_user and ub.id = v.id_filial',
                array('v.*, u.login, u.email, ud.address, ud.name, ud.patent, ud.company_name, ud.company_link, ud.lastname, ud.mobile, ud.user_img, ud.type_person, ub.name_company as filial_name, ub.adres as filial_address, ub.phone as filial_phone, ub.email as filial_email, ub.url_company as filial_url_company, ub.img as filial_img'),
                'v.id = :id or v.seo = :id',
                array('id' => $id, 'lang' => (int)$_SESSION['lid']),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function getDataVacanciesForEdit($id, $id_user) {
            return DBClass::Instance()->select(
                'vacancies as v ',
                array('v.*'),
                'v.id = :id and v.id_user = :id_user',
                array('id' => $id, 'id_user' => $id_user),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function getAuthorId($id) {
            return DBClass::Instance()->select(
                'vacancies',
                array('id_user'),
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
       
       public function getListVacanciesOfUser($id) {
            return DBClass::Instance()->select(
                'vacancies as v, categoryvacancies_description as cd, user_date as ud',
                array('v.id, v.title, v.short_desc, ud.user_id, ud.name, ud.lastname, cd.title as category_title, cd.category_id as category_id'),
				'v.id_category = cd.category_id and cd.lang_id = :lang and v.id_user = :id',
				array('lang' => (int)$_SESSION['lid'], 'id' => (int)$id),
				'',
				'title',
				true,
				'',
				'2'
            );
        }

        public function getListVacanciesForUser($id) {
            return DBClass::Instance()->select(
                'vacancies',
                array('id, title, seo, short_desc, date_add, views, show_status, valid_status'),
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
        
        public function getRequirementsOfVacancy ($id) {
            $result = DBClass::Instance()->select(
                'requirements',
                array('*'),
                'id_vacancy = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
            
            $requirements = array();
            foreach($result as $k => $v) {
                $requirements[$v['name_rm']] = array(
                    'name_rm' => $v['name_rm'],
                    'value_rm' => $v['value_rm'],
                    'status_rm' => $v['status_rm']
                );
            }
            
            return $requirements;
        }
        
        public function getRequirementsOfVacancyNEC ($id) {
            $result = DBClass::Instance()->select(
                'requirements',
                array('*'),
                'id_vacancy = :id and status_rm = \'necessarily\'',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
            
            $requirements = array();
            foreach($result as $k => $v) {
                $requirements[$v['name_rm']] = array(
                    'name_rm' => $v['name_rm'],
                    'value_rm' => $v['value_rm'],
                    'status_rm' => $v['status_rm']
                );
            }
            
            return $requirements;
        }
        
        public function getRequirementsOfVacancyDES ($id) {
            $result = DBClass::Instance()->select(
                'requirements',
                array('*'),
                'id_vacancy = :id and status_rm = \'desirable\'',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
            
            $requirements = array();
            foreach($result as $k => $v) {
                $requirements[$v['name_rm']] = array(
                    'name_rm' => $v['name_rm'],
                    'value_rm' => $v['value_rm'],
                    'status_rm' => $v['status_rm']
                );
            }
            
            return $requirements;
        }
        
        public function GetCategoryData ($id) {
            return $this->dbPDO->select(
                'categoryvacancies as c, categoryvacancies_description as cd', 
                array('c.id, c.parent_id, cd.title'), 
                '(c.seo = :id or c.id = :id) and c.id = cd.category_id and cd.lang_id = :lang_id',
                array('id' => $id, 'lang_id' => (int)$_SESSION['lid']),
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getVacanciesDataForCategory ($param, $start, $num) {
            return $this->dbPDO->select(
                'categoryvacancies as cv, vacancies as v left join '.DB_PREF.'user_date as ud on v.id_user = ud.user_id',
                array('v.id, v.title, v.short_desc, ud.user_id, ud.name, ud.lastname'),
                '(cv.seo = :seo or cv.id = :seo) and v.id_category = cv.id and v.valid_status = 1',
                array('seo' => $param),
                '',
                'title',
                true,
                $start.', '.$num,
                '2'
            );
        }
        
        public function getVacanciesDataForCategoryCount ($param) {
            return $this->dbPDO->getCount(
                'categoryvacancies as cv, '.DB_PREF.'vacancies as v left join '.DB_PREF.'user_date as ud on v.id_user = ud.user_id',
                '(cv.seo = :seo or cv.id = :seo) and v.id_category = cv.id and v.valid_status = 1',
                array('seo' => $param),
                'title'
            );
        }
        
        public function UpdViewsVacancies ($views, $id) {
            DBClass::Instance()->update('vacancies', array('views' => (int)$views, 'id' => (int)$id), 'id = :id');
        }
        
        public function UpdStatusVacancies ($id, $status) {
            $this->dbPDO->update('vacancies', array('show_status' => (int)$status, 'id' => (int)$id), 'id = :id');
        }
	}
?>