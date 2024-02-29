<?php
	class PrivateModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function GetLangNum () {
            $lang['data'] = DBClass::Instance()->select(
                'lang', 
                array('*'), 
                'status = :status', 
                array('status' => '1'),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
            
            $lang['count'] = count($lang['data']);
            
            if($lang['data'] == '0') return false;
            else return $lang;
        }
       
        public function getPostDateForMessage ($table, $id_post) {
            return DBClass::Instance()->select(
                $table,
                array('id, title, seo'),
                'id = :id',
                array('id' => (int)$id_post),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function SendMessageFromAdmin ($data) {
            return DBClass::Instance()->insert('message_for_user_from_admin', $data);
        }
       
       /*----- Private Home -----*/
       public function getCountLegalUsers () {
            return DBClass::Instance()->getCount(
                'user_date',
                'type_person = 4',
                array(),
                'id'
            );
       }
       
       public function getCountIndividualUsers () {
            return DBClass::Instance()->getCount(
                'user_date',
                'type_person = 5',
                array(),
                'id'
            );
       }
       
       public function getCountPortfolioUsers () {
            return DBClass::Instance()->getCount(
                'portfolio',
                '',
                array(),
                'id'
            );
       }
       
       public function getCountAdvertsUsers () {
            return DBClass::Instance()->getCount(
                'adverts',
                '',
                array(),
                'id'
            );
       }
       
       public function getCountVacanciesUsers () {
            return DBClass::Instance()->getCount(
                'vacancies',
                '',
                array(),
                'id'
            );
       }
       
       public function getListMessages () {
            return DBClass::Instance()->select(
                'contacts',
                array('*'),
                '',
                array(),
                '',
                'read_status',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function getNoteData () {
            return DBClass::Instance()->select('note', array('*'), '', '','','','','', '', '1');
        }
        
        public function SaveNode ($upd, $id) {
            if($id == '') return DBClass::Instance()->insert('note', $upd);
            else return DBClass::Instance()->update('note', $upd, 'id = :id');
        }
        /*----- /Private Home -----*/
        
        /*----- Private Category -----*/
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
                'category LEFT JOIN '.DBClass::Instance()->config['db_pref'].'category_description ON '.DBClass::Instance()->config['db_pref'].'category_description.category_id = '.DBClass::Instance()->config['db_pref'].'category.id AND '.DBClass::Instance()->config['db_pref'].'category_description.lang_id = \'1\'',
                array(DBClass::Instance()->config['db_pref'].'category.id, '.DBClass::Instance()->config['db_pref'].'category.parent_id, '.DBClass::Instance()->config['db_pref'].'category_description.title'),
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
                'category',
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
                'lang LEFT JOIN '.DBClass::Instance()->config['db_pref'].'category_description ON '.DBClass::Instance()->config['db_pref'].'category_description.category_id = :id',
                array(DBClass::Instance()->config['db_pref'].'category_description.title, '.DBClass::Instance()->config['db_pref'].'category_description.description, '.DBClass::Instance()->config['db_pref'].'category_description.keywords, '.DBClass::Instance()->config['db_pref'].'category_description.lang_id'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and '.DBClass::Instance()->config['db_pref'].'category_description.lang_id = '.DBClass::Instance()->config['db_pref'].'lang.id',
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
       
       public function getFieldsGroupList () {
            return DBClass::Instance()->select(
                'fields_group',
                array('*'),
                '',
                '',
                '', 
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getFieldsGroupListForCategory ($id) {
            return DBClass::Instance()->select(
                'fields_category',
                array('id_group'),
                'id_category = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getFieldsList ($sort = '') {
            return DBClass::Instance()->select(
                'fields_data as fd, fields_placeholder as fp, fields_fieldsgroup as ffg, fields_group as fg',
                array('DISTINCT fd.id, fd.type, fg.title, fp.placeholder'),
                'fp.id_lang = :id AND fp.id_field = fd.id AND ffg.id_field = fd.id AND ffg.id_fieldsgroup = fg.id',
                array('id' => 1),
                '', 
                'title',
                $sort,
                '',
                '',
                '2'
            );
        }
        
        public function GetTypeList () {
            return DBClass::Instance()->select(
                'type_adverts as ta, type_adverts_description as tad',
                array('ta.active, tad.*'),
                'ta.id = tad.id_type and tad.id_lang = :lang_id',
                array('lang_id' => 1),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetTypeListForCategory ($id) {
            return DBClass::Instance()->select(
                'category_typeadverts',
                array('id_type'),
                'id_category = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getListFieldsForCategory ($id) {
            return DBClass::Instance()->select(
                'fields_fieldsgroup, fields_data, fields_placeholder',
                array('DISTINCT ('.DBClass::Instance()->config['db_pref'].'fields_data.id), '.DBClass::Instance()->config['db_pref'].'fields_data.type, '.DBClass::Instance()->config['db_pref'].'fields_placeholder.placeholder'),
                DBClass::Instance()->config['db_pref'].'fields_fieldsgroup.id_fieldsgroup = :id and '.DBClass::Instance()->config['db_pref'].'fields_fieldsgroup.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id and '.DBClass::Instance()->config['db_pref'].'fields_placeholder.id_field = '.DBClass::Instance()->config['db_pref'].'fields_fieldsgroup.id_field and '.DBClass::Instance()->config['db_pref'].'fields_placeholder.id_lang = 1',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function getFieldsForCategory ($id_cat, $id_group) {
            return DBClass::Instance()->select(
                'fields_category',
                array('id_field'),
                'id_category = :id_cat and id_group = :id_group',
                array('id_cat' => (int)$id_cat, 'id_group' => (int)$id_group),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function UpdateCategory ($data, $TypeId, $id, $advertFields, $FieldsGoupId, $category_description) {
            DBClass::Instance()->update('category', $data, 'id = :id');
            
            DBClass::Instance()->deleteElement('category_description', array('category_id' => (int)$id));
       
            if ($advertFields != '') {
                DBClass::Instance()->deleteElement('fields_category', array('id_category' => (int)$id));
                foreach ($advertFields as $af) {
                    DBClass::Instance()->insert('fields_category', array('id_field' => (int)$af, 'id_group' => $FieldsGoupId, 'id_category' => (int)$id));
                }
            }
            
            foreach($category_description as $k => $v){
                DBClass::Instance()->insert('category_description', array('category_id'  => (int)$id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
            
            if ($TypeId != '') {
                DBClass::Instance()->deleteElement('category_typeadverts', array('id_category' => (int)$id));
                foreach($TypeId as $k => $v){
                    DBClass::Instance()->insert('category_typeadverts', array('id_category' => (int)$id, 'id_type' => (int)$v));
                }
            }
            
            $q = DBClass::Instance()->select(
                'category_path',
                array('*'),
                'id_path = :path',
                array('path' => (int)$id),
                '',
                'level',
                true,
                '',
                '',
                '2'
            );
            
            if(!empty($q)) {
                foreach ($q as $v) {
                    DBClass::Instance()->deleteElement('category_path', array('id_category' => (int)$v['id_category'], 'level' => (int)$v['level']), 'level', '<');
                    
                    $path = array();
                    
                    $new_parents = DBClass::Instance()->select(
                        'category_path',
                        array('*'),
                        'id_category = :parent_id',
                        array('parent_id' => (int)$data['parent_id']),
                        '',
                        'level',
                        true,
                        '',
                        '2'
                    );
                    
                    foreach ($new_parents as $result) {
    					$path[] = $result['path_id'];
    				}
                    
                    $new_parents = DBClass::Instance()->select(
                        'category_path',
                        array('*'),
                        'id_category = :id_category',
                        array('id_category' => (int)$v['id_category']),
                        '',
                        'level',
                        true,
                        '',
                        '',
                        '2'
                    );
                    
                    $level = 0;
                    
                    foreach ($path as $path_id) {
                        DBClass::Instance()->replace('category_path', array('id_category' => (int)$v['id_category'], 'id_path' => (int)$path_id, 'level' => (int)$level));
    
    					$level++;
    				}
                }
            } else {
                DBClass::Instance()->deleteElement('category_path', array('id_category' => (int)$id), '');
                
                $level = 0;
                
                $query = DBClass::Instance()->select(
                    'category_path',
                    array('*'),
                    'id_category = :parent_id',
                    array('parent_id' => (int)$data['parent_id']),
                    '',
                    'level',
                    true,
                    '',
                    '',
                    '2'
                );

    			foreach ($query as $result) {
                    DBClass::Instance()->insert('category_path', array('id_category' => (int)$id, 'id_path' => $result['id_path'], 'level' => (int)$level));
    				$level++;
    			}

                DBClass::Instance()->update('category_path', array('id_category' => (int)$id, 'id_path' => (int)$id, 'level' => (int)$level));
            }
        }
        
        public function AddNewCategory ($Data, $TypeId, $advertFields, $cd) {
            DBClass::Instance()->insert('category', $Data);
            $category_id = DBClass::Instance()->getLastId();
            
            if ($advertFields != '') {
                foreach ($advertFields as $af) {
                    DBClass::Instance()->insert('fields_category', array('id_field' => (int)$af, 'id_category' => (int)$category_id));
                }
            }
            
            foreach($cd as $k => $v){
                DBClass::Instance()->insert('category_description', array('category_id' => (int)$category_id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
            
            if ($TypeId != '') {
                foreach($TypeId as $k => $v){
                    DBClass::Instance()->insert('category_typeadverts', array('id_category' => (int)$category_id, 'id_type' => (int)$v));
                }
            }
            
            $level = 0;
            
            $q = DBClass::Instance()->select(
                'category_path',
                array('*'),
                'id_category = :parent_id',
                array('parent_id' => (int)$Data['parent_id']),
                '',
                'level',
                true,
                '',
                '',
                '2'
            );
            
            foreach($q as $v) {
                DBClass::Instance()->insert('category_path', array('id_category' => (int)$category_id, 'id_path' => $v['id_path'], 'level' => (int)$level));
                $level++;
            }
            
            DBClass::Instance()->insert('category_path', array('id_category' => (int)$category_id, 'id_path' => (int)$category_id, 'level' => (int)$level));
        }
       
       public function deletecategory ($id) {
            DBClass::Instance()->deleteElement('category', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('fields_category', array('id_category' => (int)$id));
            DBClass::Instance()->deleteElement('category_description', array('category_id' => (int)$id));
            DBClass::Instance()->deleteElement('category_typeadverts', array('id_category' => (int)$id));
        }
        /*----- /Private Category -----*/
        
        /*----- Private Type adverts -----*/
        public function AddNewType ($data) {
            DBClass::Instance()->insert('type_adverts', array('active' => $data['active']));
            
            $type_id = DBClass::Instance()->getLastId();
            
            foreach ($data['name'] as $k => $v) {
                DBClass::Instance()->insert('type_adverts_description', array('name' => $v['name'], 'id_lang' => (int)$k, 'id_type' => (int)$type_id));
            }
        }
        
        public function UpdDate ($data, $id) {
            //print_r($data);
            DBClass::Instance()->update('type_adverts', array('active' => $data['active'], 'id' => (int)$id), 'id = :id');
            
            DBClass::Instance()->deleteElement('type_adverts_description', array('id_type' => (int)$id));
            foreach ($data['name'] as $k => $v) {
                DBClass::Instance()->insert('type_adverts_description', array('name' => $v['name'], 'id_lang' => (int)$k, 'id_type' => (int)$id));
            }
        }
        
        public function GetTypeData ($id) {
            return DBClass::Instance()->select(
                'type_adverts_description', 
                array('*'), 
                'id_type = :id', 
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetActiveTypeAdverts ($id) {
            return DBClass::Instance()->select(
                'type_adverts', 
                array('active'), 
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
        
        public function deletetype ($id) {
            DBClass::Instance()->deleteElement('type_adverts', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('category_typeadverts', array('id_type' => (int)$id));
            DBClass::Instance()->deleteElement('type_adverts_description', array('id_type' => (int)$id));
        }
        /*----- /Private Type adverts -----*/
        
        /*----- Private Type company -----*/
        public function GetTypeCompanyList () {
            return DBClass::Instance()->select(
                'type_company as ta, type_company_description as tad',
                array('ta.active, tad.*'),
                'ta.id = tad.id_type and tad.id_lang = :lang_id',
                array('lang_id' => 1),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function AddNewTypeCompany ($data) {
            DBClass::Instance()->insert('type_company', array('active' => $data['active']));
            
            $type_id = DBClass::Instance()->getLastId();
            
            foreach ($data['name'] as $k => $v) {
                DBClass::Instance()->insert('type_company_description', array('name' => $v['name'], 'id_lang' => (int)$k, 'id_type' => (int)$type_id));
            }
        }
        
        public function UpdDateTypeCompany ($data, $id) {
            //print_r($data);
            DBClass::Instance()->update('type_company', array('active' => $data['active'], 'id' => (int)$id), 'id = :id');
            
            DBClass::Instance()->deleteElement('type_company_description', array('id_type' => (int)$id));
            foreach ($data['name'] as $k => $v) {
                DBClass::Instance()->insert('type_company_description', array('name' => $v['name'], 'id_lang' => (int)$k, 'id_type' => (int)$id));
            }
        }
        
        public function GetTypeCompanyData ($id) {
            return DBClass::Instance()->select(
                'type_company_description', 
                array('*'), 
                'id_type = :id', 
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetActiveTypeCompany ($id) {
            return DBClass::Instance()->select(
                'type_company', 
                array('active'), 
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
        
        public function deletetypeCompany ($id) {
            DBClass::Instance()->deleteElement('type_company', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('category_typecompany', array('id_type' => (int)$id));
            DBClass::Instance()->deleteElement('type_company_description', array('id_type' => (int)$id));
        }
        /*----- /Private Type company -----*/
        
        /*----- Private category of vacancie -----*/
        public function ParentCategoryVacancieList () {
            $category = DBClass::Instance()->select(
                'categoryvacancies LEFT JOIN '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description ON '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.category_id = '.DBClass::Instance()->config['db_pref'].'categoryvacancies.id AND '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.lang_id = \'1\'',
                array(DBClass::Instance()->config['db_pref'].'categoryvacancies.id, '.DBClass::Instance()->config['db_pref'].'categoryvacancies.parent_id, '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.title'),
                '',
                '',
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
        
        public function AddNewCategoryVacancie ($Data, $cd) {
            DBClass::Instance()->insert('categoryvacancies', $Data);
            $category_id = DBClass::Instance()->getLastId();
            
            foreach($cd as $k => $v){
                DBClass::Instance()->insert('categoryvacancies_description', array('category_id' => (int)$category_id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
        }
        
        public function GetCategoryVacancieData($id) {
            $categoryData = DBClass::Instance()->select(
                'categoryvacancies',
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
                'lang LEFT JOIN '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description ON '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.category_id = :id',
                array(DBClass::Instance()->config['db_pref'].'categoryvacancies_description.title, '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.description, '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.keywords, '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.lang_id'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description.lang_id = '.DBClass::Instance()->config['db_pref'].'lang.id',
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
       
       public function UpdateCategoryVacancie ($data, $id, $category_description) {
            DBClass::Instance()->update('categoryvacancies', $data, 'id = :id');
            
            DBClass::Instance()->deleteElement('categoryvacancies_description', array('category_id' => (int)$id));
            
            foreach($category_description as $k => $v){
                DBClass::Instance()->insert('categoryvacancies_description', array('category_id'  => (int)$id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
        }
        
        public function deletecategoryvacancies ($id) {
            DBClass::Instance()->deleteElement('categoryvacancies', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('categoryvacancies_description', array('category_id' => (int)$id));
        }
        /*----- /Private category of vacancie -----*/
        
        /*----- Private adverts -----*/
        public function GetAdvertsList () {
	       return DBClass::Instance()->select(
                'adverts left join '.DBClass::Instance()->config['db_pref'].'user_date on '. DBClass::Instance()->config['db_pref'].'adverts.idUser = '.DBClass::Instance()->config['db_pref'].'user_date.user_id left join '.DBClass::Instance()->config['db_pref'].'users on '.DBClass::Instance()->config['db_pref'].'adverts.idUser = '.DBClass::Instance()->config['db_pref'].'users.id',
                array(DBClass::Instance()->config['db_pref'].'adverts.*, '.DBClass::Instance()->config['db_pref'].'users.login, '.DBClass::Instance()->config['db_pref'].'users.email, '.DBClass::Instance()->config['db_pref'].'user_date.name, '.DBClass::Instance()->config['db_pref'].'user_date.lastname'),
                '',
                '',
                '',
                'title',
                '',
                '',
                '',
                '2'
           );
	   }
       
       public function lifeSearchAdverts ($search_tag, $cat_id) {
            if($cat_id == '') {
                
                return DBClass::Instance()->select(
                    'adverts as a LEFT JOIN '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai ON ai.main = 1 and ai.id_adv = a.id',
                    array('a.id, a.title, a.seo, a.description, a.validate, ai.src'),
                    'MATCH(a.title, a.description, a.keywords, a.textAdvert) AGAINST (:query IN BOOLEAN MODE)',
                    array('query' => '*'.$search_tag.'*'),
                    '',
                    'title',
                    true,
                    '',
                    '',
                    '2'
                );
            } else {
                return DBClass::Instance()->select(
                    'category as c, category_advert as ca, adverts as a LEFT JOIN '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai ON ai.main = 1 and ai.id_adv = a.id',
                    array('a.id, a.title, a.seo, a.description, a.validate, ai.src'),
                    'MATCH(a.title, a.description, a.keywords, a.textAdvert) AGAINST (:query IN BOOLEAN MODE) and c.id = :cat_id and ca.id_category = c.id and a.id = ca.id_advert',
                    array('query' => '*'.$search_tag.'*', 'cat_id' => $cat_id),
                    '',
                    'title',
                    true,
                    '',
                    '',
                    '2'
                );
            }
       }
       
       public function countAdvertsForPage ($const = 5) {
            $count = DBClass::Instance()->getCount(
                'adverts as a',
                '',
                array(),
                'a.id'
            );
            
            return ceil($count['numCount']/$const);
       }
       
       public function getAdvertListForPage ($pagenum, $const = 5) {
            
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
            
            return DBClass::Instance()->select(
                'users as u, adverts as a LEFT JOIN '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai ON ai.main = 1 and ai.id_adv = a.id',
                array('a.id, a.idUser, a.title, a.seo, a.description, a.validate, ai.src, u.email'),
                'a.idUser = u.id',
                array(),
                '',
                'title',
                true,
                $const,
                $offset,
                '2'
            );
        }
        
        public function UpdValidStatus ($data) {
            return DBClass::Instance()->update('adverts', $data, 'id = :id');
        }
       /*----- /Private adverts -----*/
       
       /*----- Private vacancies -----*/
       public function getVacanciesPage ($pagenum, $const = 5) {
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
            
            return DBClass::Instance()->select(
                'users as u, vacancies as v left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ud.user_id = v.id_user left join '.DBClass::Instance()->config['db_pref'].'categoryvacancies_description as cd on v.id_category = cd.category_id and cd.lang_id = 1',
                array('v.id, v.id_user, v.title, v.date_add, v.short_desc, v.valid_status, ud.user_id, ud.name, ud.lastname, ud.user_img, cd.title as category_title, cd.category_id as category_id, u.email'),
                'v.id_user = u.id',
				array(),
                '',
                'title',
                true,
                $const,
                $offset,
                '2'
            );
       }
       
       public function getVacanciesCount ($const = 5) {
            $count = DBClass::Instance()->getCount(
                'vacancies',
                '',
                array()
            );
            
            return ceil($count['numCount']/$const);
       }
       
       public function lifeSearchVacancies ($search_tag, $cat_id) {
            if($cat_id == '') {
                
                return DBClass::Instance()->select(
                    'vacancies as v',
                    array('v.id, v.title, v.seo, v.short_desc, v.valid_status'),
                    'MATCH(v.title, v.short_desc, v.full_desc) AGAINST (:query IN BOOLEAN MODE)',
                    array('query' => '*'.$search_tag.'*'),
                    '',
                    'title',
                    true,
                    '',
                    '',
                    '2'
                );
            } else {
                return DBClass::Instance()->select(
                    'categoryvacancies as c, vacancies as v',
                    array('v.id, v.title, v.seo, v.short_desc, v.valid_status'),
                    'MATCH(v.title, v.short_desc, v.full_desc) AGAINST (:query IN BOOLEAN MODE) and c.id = :cat_id and v.id_category = c.id',
                    array('query' => '*'.$search_tag.'*', 'cat_id' => $cat_id),
                    '',
                    'title',
                    true,
                    '',
                    '',
                    '2'
                );
            }
       }
       
       public function UpdVacanciesValidStatus ($data) {
            return DBClass::Instance()->update('vacancies', $data, 'id = :id');
        }
       /*----- /Private vacancies -----*/
       
       /*----- /Private AdvertForModeration -----*/
       public function getAdvertListForModeration () {
            return DBClass::Instance()->select(
                'adverts as a LEFT JOIN '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai ON ai.main = 1 and ai.id_adv = a.id',
                array('a.id, a.title, a.seo, a.description, a.validate, ai.src'),
                'validate = 0',
                array(),
                '',
                'title',
                true,
                '',
                '',
                '2'
            );
        }
        /*----- /Private AdvertForModeration -----*/
        
        /*----- Private fields group -----*/
       public function getFieldsGroup () {
            return DBClass::Instance()->select(
                'fields_group',
                array('*'),
                '',
                '',
                '', 
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function addFieldGroup ($data) {
            return DBClass::Instance()->insert('fields_group', $data);
        }
        
        public function UpdDateFieldsGroup ($data, $id) {
            return DBClass::Instance()->update('fields_group', $data, 'id = :id');
        }
        
        public function getFieldGroupData ($id) {
            return DBClass::Instance()->select(
                'fields_group',
                array('*'),
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
        
        public function deleteFieldsGroup ($id) {
            return DBClass::Instance()->deleteElement('fields_group', array('id' => (int)$id));
        }
        /*----- /Private fields group -----*/
        
        /*----- Private fields of group -----*/
        public function addField ($data, $id_group) {
            DBClass::Instance()->insert('fields_data', array('type' => $data['type'], 'name' => $data['name'], 'id_style' => $data['id_style'], 'class_style' => $data['class_style']));
            
            $last_id = DBClass::Instance()->getLastId();
            
            if(!empty($id_group)) {
                foreach ($id_group as $v) {
                    DBClass::Instance()->insert('fields_fieldsgroup', array('id_fieldsgroup' => $v, 'id_field' => (int)$last_id));
                }
            }
            
            foreach ($data['placeholder'] as $k => $v) {
                DBClass::Instance()->insert('fields_placeholder', array('field_value' => $data['value'][$k]['name'], 'placeholder' => $v['name'], 'id_lang' => (int)$k, 'id_field' => (int)$last_id));
            }
            
            foreach ($data['typeCategory'] as $t) {
                DBClass::Instance()->insert('fields_types', array('id_type' => $t, 'id_field' => $last_id));
            }
        }
        
        public function getFieldData ($id) {
            $fieldDate = DBClass::Instance()->select(
                'fields_data LEFT JOIN '.DBClass::Instance()->config['db_pref'].'fields_placeholder ON '.DBClass::Instance()->config['db_pref'].'fields_placeholder.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id',
                array(DBClass::Instance()->config['db_pref'].'fields_data.*, '.DBClass::Instance()->config['db_pref'].'fields_placeholder.placeholder'),
                DBClass::Instance()->config['db_pref'].'fields_placeholder.id_lang = :id_lang and '.DBClass::Instance()->config['db_pref'].'fields_data.id = :id_field_data',
                array('id_lang' => 1, 'id_field_data' => (int)$id), 
                '', 
                '',
                '',
                '',
                '',
                '1'
            );
            
            $placeholder = DBClass::Instance()->select(
                'fields_placeholder', 
                array('*'), 
                'id_field = :id_field',
                array('id_field' => (int)$id),
                '',
                'placeholder',
                '',
                '',
                '',
                '2'
            );
            
            foreach ($placeholder as $k => $v) {
                $data['placeholder'][$v['id_lang']] = array (
                    'name' => $v['placeholder']
                );
            }
            
            foreach ($placeholder as $k => $v) {
                $data['field_value'][$v['id_lang']] = array (
                    'name' => $v['field_value']
                );
            }
            
            $fieldDate[0]['placeholder'] = $data['placeholder'];
            $fieldDate[0]['field_value'] = $data['field_value'];
            
            return $fieldDate;
        }
        
        public function UpdFieldDate ($data, $id_group, $id) {
            DBClass::Instance()->update('fields_data', array('type' => $data['type'], 'name' => $data['name'], 'id_style' => $data['id_style'], 'class_style' => $data['class_style'], 'id' => (int)$id), 'id = :id');
            
            if(!empty($id_group)) {
                DBClass::Instance()->deleteElement('fields_fieldsgroup', array('id_field' => (int)$id));
                foreach ($id_group as $v) {
                    DBClass::Instance()->insert('fields_fieldsgroup', array('id_fieldsgroup' => $v, 'id_field' => (int)$id));
                }
            }
            
            DBClass::Instance()->deleteElement('fields_placeholder', array('id_field' => (int)$id));
            foreach ($data['placeholder'] as $k => $v) {
                DBClass::Instance()->insert('fields_placeholder', array('field_value' => $data['value'][$k]['name'], 'placeholder' => $v['name'], 'id_lang' => (int)$k, 'id_field' => (int)$id));
            }
            
            DBClass::Instance()->deleteElement('fields_types', array('id_field' => (int)$id));
            foreach ($data['typeCategory'] as $t) {
                DBClass::Instance()->insert('fields_types', array('id_type' => $t, 'id_field' => (int)$id));
            }
        }
        
        public function getFieldsGroupForField ($id) {
            return DBClass::Instance()->select(
                'fields_fieldsgroup',
                array('*'),
                'id_field = :id',
                array('id' => (int)$id), 
                '', 
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getFieldsForTypeList ($id) {
            return DBClass::Instance()->select(
                'fields_types',
                array('id_type'),
                'id_field = :id',
                array('id' => (int)$id), 
                '', 
                'id_type',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function deleteFields ($id) {
            DBClass::Instance()->deleteElement('fields_data', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('fields_fieldsgroup', array('id_field' => (int)$id));
            DBClass::Instance()->deleteElement('fields_placeholder', array('id_field' => (int)$id));
            DBClass::Instance()->deleteElement('fields_types', array('id_field' => (int)$id));
            DBClass::Instance()->deleteElement('fields_category', array('id_field' => (int)$id));
        }
        /*----- /Private fields of group -----*/
        
        /*----- Private FQBlog -----*/
        public function ParentBlogList () {
            $category = DBClass::Instance()->select(
                'category_blog LEFT JOIN '.DBClass::Instance()->config['db_pref'].'category_blog_description ON '.DBClass::Instance()->config['db_pref'].'category_blog_description.category_id = '.DBClass::Instance()->config['db_pref'].'category_blog.id AND '.DBClass::Instance()->config['db_pref'].'category_blog_description.lang_id = \'1\'',
                array(DBClass::Instance()->config['db_pref'].'category_blog.id, '.DBClass::Instance()->config['db_pref'].'category_blog.parent_id, '.DBClass::Instance()->config['db_pref'].'category_blog_description.title'),
                '',
                '',
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
        
        public function lifeSearchArticle ($search_tag, $cat_id) {
            return DBClass::Instance()->select(
                'blog_article_description',
                array('id_blog_article, title, description'),
                'MATCH(title, description, keywords) AGAINST (:query IN BOOLEAN MODE)',
                array('query' => '*'.$search_tag.'*'),
                '',
                'title',
                true,
                '',
                '',
                '2'
            );
       }
       
       public function AddNewCategoryBlog ($Data, $cd) {
            DBClass::Instance()->insert('category_blog', $Data);
            $category_id = DBClass::Instance()->getLastId();
            
            foreach($cd as $k => $v){
                DBClass::Instance()->insert('category_blog_description', array('category_id' => (int)$category_id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
            
            $level = 0;
            
            $q = DBClass::Instance()->select(
                'category_blog_path',
                array('*'),
                'id_category = :parent_id',
                array('parent_id' => (int)$Data['parent_id']),
                '',
                'level',
                true,
                '',
                '',
                '2'
            );
            
            foreach($q as $v) {
                DBClass::Instance()->insert('category_blog_path', array('id_category' => (int)$category_id, 'id_path' => $v['id_path'], 'level' => (int)$level));
                $level++;
            }
            
            DBClass::Instance()->insert('category_blog_path', array('id_category' => (int)$category_id, 'id_path' => (int)$category_id, 'level' => (int)$level));
        }
        
       public function GetBlogCategoryData($id) {
            $categoryData = DBClass::Instance()->select(
                'category_blog',
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
                'lang LEFT JOIN '.DBClass::Instance()->config['db_pref'].'category_blog_description ON '.DBClass::Instance()->config['db_pref'].'category_blog_description.category_id = :id',
                array(DBClass::Instance()->config['db_pref'].'category_blog_description.title, '.DBClass::Instance()->config['db_pref'].'category_blog_description.description, '.DBClass::Instance()->config['db_pref'].'category_blog_description.keywords, '.DBClass::Instance()->config['db_pref'].'category_blog_description.lang_id'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and '.DBClass::Instance()->config['db_pref'].'category_blog_description.lang_id = '.DBClass::Instance()->config['db_pref'].'lang.id',
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
       
       public function UpdateCategoryBlog ($data, $id, $category_description) {
            DBClass::Instance()->update('category_blog', $data, 'id = :id');
            
            DBClass::Instance()->deleteElement('category_blog_description', array('category_id' => (int)$id));
            
            foreach($category_description as $k => $v){
                DBClass::Instance()->insert('category_blog_description', array('category_id'  => (int)$id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description']));
            }
            
            $q = DBClass::Instance()->select(
                'category_blog_path',
                array('*'),
                'id_path = :path',
                array('path' => (int)$id),
                '',
                'level',
                true,
                '',
                '',
                '2'
            );
            
            if(!empty($q)) {
                foreach ($q as $v) {
                    DBClass::Instance()->deleteElement('category_blog_path', array('id_category' => (int)$v['id_category'], 'level' => (int)$v['level']), 'level', '<');

                    $path = array();
                    
                    $new_parents = DBClass::Instance()->select(
                        'category_blog_path',
                        array('*'),
                        'id_category = :parent_id',
                        array('parent_id' => (int)$data['parent_id']),
                        '',
                        'level',
                        true,
                        '',
                        '',
                        '2'
                    );
                    
                    foreach ($new_parents as $result) {
    					$path[] = $result['path_id'];
    				}
                    
                    $new_parents = DBClass::Instance()->select(
                        'category_blog_path',
                        array('*'),
                        'id_category = :id_category',
                        array('id_category' => (int)$v['id_category']),
                        '',
                        'level',
                        true,
                        '',
                        '',
                        '2'
                    );
                    
                    $level = 0;
                    
                    foreach ($path as $path_id) {
                        DBClass::Instance()->replace('category_blog_path', array('id_category' => (int)$v['id_category'], 'id_path' => (int)$path_id, 'level' => (int)$level));
    
    					$level++;
    				}
                }
            } else {
                DBClass::Instance()->deleteElement('category_blog_path', array('id_category' => (int)$id), '');
                
                $level = 0;
                
                $query = DBClass::Instance()->select(
                    'category_blog_path',
                    array('*'),
                    'id_category = :parent_id',
                    array('parent_id' => (int)$data['parent_id']),
                    '',
                    'level',
                    true,
                    '',
                    '',
                    '2'
                );

    			foreach ($query as $result) {
                    DBClass::Instance()->insert('category_blog_path', array('id_category' => (int)$id, 'id_path' => $result['id_path'], 'level' => (int)$level));
    				$level++;
    			}
    
                //DBClass::Instance()->replace('category_blog_path', array('id_category' => (int)$id, 'id_path' => (int)$id, 'level' => (int)$level));
            }
        }
        
        public function getImageCategoryBlog ($id) {
            return DBClass::Instance()->select(
                    'category_blog',
                    array('imgicon'),
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
        
        public function deletecategoryblog ($id) {
            DBClass::Instance()->deleteElement('category_blog', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('category_blog_description', array('category_id' => (int)$id));
            DBClass::Instance()->deleteElement('category_blog_path', array('id_category' => (int)$id));
        }
        
       public function GetArticlesList ($pagenum, $const = 5) {
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
            
	       return DBClass::Instance()->select(
                'blog_article, blog_article_description',
                array(DBClass::Instance()->config['db_pref'].'blog_article.*, '.DBClass::Instance()->config['db_pref'].'blog_article_description.title'),
                DBClass::Instance()->config['db_pref'].'blog_article.id = '.DBClass::Instance()->config['db_pref'].'blog_article_description.id_blog_article and '.DBClass::Instance()->config['db_pref'].'blog_article_description.lang_id = :id_lang',
                array('id_lang' => 1),
                '',
                'title',
                true,
                $const,
                $offset,
                '2'
           );
	   }
       
       public function getArticlesCount ($const = 5) {
            $count = DBClass::Instance()->getCount(
                'blog_article',
                '',
                array(),
                'id'
            );
            
            return ceil($count['numCount']/$const);
       }
       
       public function AddNewArt ($Data, $cd) {
            DBClass::Instance()->insert('blog_article', $Data);
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($cd as $k => $v){
                DBClass::Instance()->insert('blog_article_description', array('id_blog_article' => (int)$last_id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description'], 'text' => $v['fullarticletext']));
            }
        }
       
       public function getArticleDataForView ($id) {
            $artData = DBClass::Instance()->select(
                'blog_article',
                array('*'),
                'id = :arg',
                array('arg' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
            
            $query = DBClass::Instance()->select(
                'lang, blog_article_description, blog_article',
                array(DBClass::Instance()->config['db_pref'].'blog_article.id as ba_id, '.DBClass::Instance()->config['db_pref'].'lang.id as l_id, '.DBClass::Instance()->config['db_pref'].'blog_article_description.title, '.DBClass::Instance()->config['db_pref'].'blog_article_description.description, '.DBClass::Instance()->config['db_pref'].'blog_article_description.keywords, '.DBClass::Instance()->config['db_pref'].'blog_article_description.text, '.DBClass::Instance()->config['db_pref'].'blog_article_description.lang_id'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and '.DBClass::Instance()->config['db_pref'].'blog_article_description.id_blog_article = '.DBClass::Instance()->config['db_pref'].'blog_article.id and '.DBClass::Instance()->config['db_pref'].'blog_article.id = :id',
                array('id' => (int)$artData['id'], 'lang_status' => '1'),
                '',
                'l_id',
                '',
                '',
                '',
                '2'
            );
            
            foreach($query as $k => $v) {
                $rezult[$v['lang_id']] = array(
                    'title' => $v['title'],
                    'description' => $v['description'],
                    'keywords' => $v['keywords'],
                    'text' => $v['text']
                );
            }
            
            $artData['artDesc'] = $rezult;
            return $artData;
        }
        
        public function GetAdvertsSelectList () {
	       return DBClass::Instance()->select(
                'adverts',
                array('id, title'),
                'validate = :val',
                array('val' => 1),
                '',
                'title',
                true,
                '',
                '',
                '2'
           );
	   }
        
        public function getBlogCategoryesForArt ($id) {
            return DBClass::Instance()->select(
                'categoryblog_arts as ca, category_blog as c, category_blog_description as cd',
                array('c.seo, ca.id_category, cd.title'),
                'ca.id_art = :ca_id and ca.mainCategory = 1 and c.id = ca.id_category and cd.category_id = ca.id_category and cd.lang_id = :lang',
                array('ca_id' => (int)$id, 'lang' => 1),
                '',
                'title',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function seveArtData ($blogArt, $blogDesc) {
            DBClass::Instance()->update('blog_article', $blogArt, 'id = :id');
            
            DBClass::Instance()->deleteElement('blog_article_description', array('id_blog_article' => (int)$blogArt['id']));
            foreach($blogDesc as $k => $v){
                DBClass::Instance()->insert('blog_article_description', array('id_blog_article' => (int)$blogArt['id'], 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description'], 'text' => $v['fullarticletext']));
            }
            
            DBClass::Instance()->deleteElement('categoryblog_arts', array('id_art' => (int)$blogArt['id']));
            DBClass::Instance()->insert('categoryblog_arts', array('id_category' => $blogArt['id_category'], 'id_art' => (int)$blogArt['id'], 'mainCategory' => 1));
        }
        
        public function deleteArtBlog ($id) {
            DBClass::Instance()->deleteElement('blog_article', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('blog_article_description', array('id_blog_article' => (int)$id));
            DBClass::Instance()->deleteElement('categoryblog_arts', array('id_art' => (int)$id));
            //DBClass::Instance()->deleteElement('advert_imgs', array('id_adv' => (int)$id));
        }
        
        public function UpdValidArtStatus ($data) {
            return DBClass::Instance()->update('blog_article', $data, 'id = :id');
        }
        /*----- /Private FQBlog -----*/
        
        /*----- Private informaton letters -----*/
        public function getPagesList () {
            return DBClass::Instance()->select(
                'pages as p, pages_description as pd',
                array('p.id, pd.title'),
                'p.id = pd.page_id and pd.lang_id = :lang',
                array('lang' => 1),
                '',
                'title',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function AddNewPage ($data, $page_description) {
            DBClass::Instance()->insert('pages', $data);
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($page_description as $k => $v){
                DBClass::Instance()->insert('pages_description', array('page_id' => (int)$last_id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description'], 'full_text' => $v['full_text']));
            }
        }
        
        public function GetPageData($id) {
            $pageData = DBClass::Instance()->select(
                'pages',
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
                'lang LEFT JOIN '.DBClass::Instance()->config['db_pref'].'pages_description ON '.DBClass::Instance()->config['db_pref'].'pages_description.page_id = :id',
                array(DBClass::Instance()->config['db_pref'].'pages_description.title, '.DBClass::Instance()->config['db_pref'].'pages_description.description, '.DBClass::Instance()->config['db_pref'].'pages_description.keywords, '.DBClass::Instance()->config['db_pref'].'pages_description.full_text, '.DBClass::Instance()->config['db_pref'].'pages_description.lang_id'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and '.DBClass::Instance()->config['db_pref'].'pages_description.lang_id = '.DBClass::Instance()->config['db_pref'].'lang.id',
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
                    'keywords' => $v['keywords'],
                    'full_text' => $v['full_text']
                );
            }
            
            $pageData['pages_description'] = $rezult;
            return $pageData;
       }
       
       public function UpdatePage ($data, $id, $page_description) {
            DBClass::Instance()->update('pages', $data, 'id = :id');
            
            DBClass::Instance()->deleteElement('pages_description', array('page_id' => (int)$id));
            foreach($page_description as $k => $v){
                DBClass::Instance()->insert('pages_description', array('page_id'  => (int)$id, 'lang_id' => (int)$k, 'title' => $v['title'], 'keywords' => $v['keywords'], 'description' => $v['description'], 'full_text' => $v['full_text']));
            }
        }
        
        public function deleteInfoPage ($id) {
            DBClass::Instance()->deleteElement('pages', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('pages_description', array('page_id' => (int)$id));
        }
        /*----- /Private informaton letters -----*/
        
        /*----- Private users -----*/
       public function getUsersCount ($const = 5) {
            $count = DBClass::Instance()->getCount(
                'users',
                '',
                array(),
                'id'
            );
            
            return ceil($count['numCount']/$const);
       }
       
       public function getUserList ($pagenum, $const = 5) {
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
        
            return DBClass::Instance()->select(
                'users LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_date ON '.DBClass::Instance()->config['db_pref'].'user_date.user_id = '.DBClass::Instance()->config['db_pref'].'users.id LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_description ON '.DBClass::Instance()->config['db_pref'].'user_type_description.id_user_type = '.DBClass::Instance()->config['db_pref'].'users.userType AND '.DBClass::Instance()->config['db_pref'].'user_type_description.id_lang = \'1\'',
                array(DBClass::Instance()->config['db_pref'].'users.id, '.DBClass::Instance()->config['db_pref'].'users.validStatus, '.DBClass::Instance()->config['db_pref'].'users.login, '.DBClass::Instance()->config['db_pref'].'users.email, '.DBClass::Instance()->config['db_pref'].'users.onlineSatus, '.DBClass::Instance()->config['db_pref'].'user_date.name, '.DBClass::Instance()->config['db_pref'].'user_date.lastname, '.DBClass::Instance()->config['db_pref'].'user_date.mobile, '.DBClass::Instance()->config['db_pref'].'user_date.patent, '.DBClass::Instance()->config['db_pref'].'user_date.user_img, '.DBClass::Instance()->config['db_pref'].'user_type_description.name as nameType, (select count(id) from '.DBClass::Instance()->config['db_pref'].'adverts where '.DBClass::Instance()->config['db_pref'].'adverts.idUser = '.DBClass::Instance()->config['db_pref'].'users.id) as numUserAdverts'),
                '',
                '',
                '',
                'login',
                true,
                $const,
                $offset,
                '2'
            );
        }
        
        public function lifeSearchUser ($user) {
            return DBClass::Instance()->select(
                'users as u, user_date as ud',
                array('u.id, u.login, u.email, ud.name, ud.lastname, ud.mobile, ud.company_name'),
                'MATCH(u.login, u.email, ud.name, ud.lastname, ud.mobile, ud.company_name) AGAINST (:query IN BOOLEAN MODE) and u.id = ud.user_id',
                array('query' => '*'.$user.'*'),
                '',
                'name',
                true,
                '',
                '',
                '2'
            );
       }
       
       public function getUserDateForDetailsPage ($login) {
            return DBClass::Instance()->select(
                'users LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_date ON '.DBClass::Instance()->config['db_pref'].'user_date.user_id = '.DBClass::Instance()->config['db_pref'].'users.id LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_description ON '.DBClass::Instance()->config['db_pref'].'user_type_description.id_user_type = '.DBClass::Instance()->config['db_pref'].'users.userType AND '.DBClass::Instance()->config['db_pref'].'user_type_description.id_lang = \'1\'',
                array(DBClass::Instance()->config['db_pref'].'users.id, '.DBClass::Instance()->config['db_pref'].'users.validStatus, '.DBClass::Instance()->config['db_pref'].'users.login, '.DBClass::Instance()->config['db_pref'].'users.email, '.DBClass::Instance()->config['db_pref'].'users.onlineSatus, '.DBClass::Instance()->config['db_pref'].'user_date.about, '.DBClass::Instance()->config['db_pref'].'user_date.name, '.DBClass::Instance()->config['db_pref'].'user_date.lastname, '.DBClass::Instance()->config['db_pref'].'user_date.mobile, '.DBClass::Instance()->config['db_pref'].'user_date.country, '.DBClass::Instance()->config['db_pref'].'user_date.region, '.DBClass::Instance()->config['db_pref'].'user_date.town, '.DBClass::Instance()->config['db_pref'].'user_date.address, '.DBClass::Instance()->config['db_pref'].'user_date.patent, '.DBClass::Instance()->config['db_pref'].'user_date.user_img, '.DBClass::Instance()->config['db_pref'].'user_type_description.name AS nameType'),
                DBClass::Instance()->config['db_pref'].'users.login = :login or '.DBClass::Instance()->config['db_pref'].'users.id = :login',
                array('login' => $login),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getUserId ($login) {
            return DBClass::Instance()->select(
                'users',
                array('id'),
                'login = :login',
                array('login' => $login),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getUserAdverts ($id) {
            return DBClass::Instance()->select(
                'adverts',
                array('*'),
                'idUser = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getUserReview ($id) {
            return DBClass::Instance()->select(
                'review as r, user_date as ud',
                array('r.*, ud.name, ud.lastname, ud.company_name'),
                'r.id_user_to = :id and r.id_user_from = ud.user_id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getPortfolioCount ($const = 5) {
            $count = DBClass::Instance()->getCount(
                'portfolio',
                '',
                array(),
                'id'
            );
            
            return ceil($count['numCount']/$const);
       }
        
        public function getAllPortfolio ($pagenum, $const = 5) {
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
                
            if($offset < $const) $offset = '';
            
    	   return DBClass::Instance()->select(
                'portfolio as p',
                array('p.id, p.id_user, p.name, p.email, p.lastname, p.portfolio_img, p.search_status, p.adresResident'), 
                '',
                array(),
                '',
                '',
                true,
                $const,
                $offset,
                '2'
            );
        }
        
        public function lifeSearchPortfolio ($user) {
            return DBClass::Instance()->select(
                'portfolio as p',
                array('p.id_user, p.name, p.lastname'),
                'MATCH(p.name, p.email, p.lastname, p.adresResident) AGAINST (:query IN BOOLEAN MODE)',
                array('query' => '*'.$user.'*'),
                '',
                'name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function getUserPortfolio ($id) {
            return DBClass::Instance()->select(
                'portfolio as p',
                array('p.id_user, p.name, p.email, p.lastname, p.portfolio_img, p.search_status, p.adresResident'), 
                'p.id_user = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function GetUsersTypeList () {
            return DBClass::Instance()->select(
                'user_type LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_description ON '.DBClass::Instance()->config['db_pref'].'user_type.id = '.DBClass::Instance()->config['db_pref'].'user_type_description.id_user_type',
                array(DBClass::Instance()->config['db_pref'].'user_type.*, '.DBClass::Instance()->config['db_pref'].'user_type_description.name, (select count('.DBClass::Instance()->config['db_pref'].'user_date.id) from '.DBClass::Instance()->config['db_pref'].'user_date where '.DBClass::Instance()->config['db_pref'].'user_date.type_person = '.DBClass::Instance()->config['db_pref'].'user_type.index) as userNum'),
                DBClass::Instance()->config['db_pref'].'user_type_description.id_lang = :id_lang',
                array('id_lang' => 1),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function AddNewUserType ($data) {
            DBClass::Instance()->insert('user_type', array('index' => $data['index'], 'type' => $data['type']));
            
            $type_id = DBClass::Instance()->getLastId();
            
            foreach ($data['name'] as $k => $v) {
                DBClass::Instance()->insert('user_type_description', array('name' => $v['name'], 'id_lang' => (int)$k, 'id_user_type' => (int)$type_id));
            }
        }
        
        public function GetUserTypeDataDescription ($id) {
            return DBClass::Instance()->select(
                'user_type_description', 
                array('*'), 
                'id_user_type = :id_user_type', 
                array('id_user_type' => (int)$id), 
                '', 
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetUserTypeData ($id) {
            return DBClass::Instance()->select(
                'user_type', 
                array('*'), 
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
        
        public function updUserTypeDate ($data, $id) {
            DBClass::Instance()->update('user_type', array('index' => $data['index'], 'type' => $data['type'], 'id' => (int)$id), 'id = :id');
            
            DBClass::Instance()->deleteElement('user_type_description', array('id_user_type' => (int)$id), '');
            foreach ($data['name'] as $k => $v) {
                DBClass::Instance()->insert('user_type_description', array('name' => $v['name'], 'id_lang' => (int)$k, 'id_user_type' => (int)$id));
            }
        }
        
        public function deleteUserType ($id) {
            DBClass::Instance()->deleteElement('user_type', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('user_type_description', array('id_user_type' => (int)$id), '');
        }
        
        public function GetInterestsList () {
            return DBClass::Instance()->select(
                'portfolio_interests_val as piv, portfolio_interests as pi',
                array('pi.*'),
                'piv.id = pi.id_interests and pi.id_lang = 1',
                array(),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetHobbiList () {
            return DBClass::Instance()->select(
                'portfolio_hobbi_val as piv, portfolio_hobbi as pi',
                array('pi.*'),
                'piv.id = pi.id_hobbi and pi.id_lang = 1',
                array(),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetAssestsList () {
            return DBClass::Instance()->select(
                'portfolio_assests_val as piv, portfolio_assests as pi',
                array('pi.*'),
                'piv.id = pi.id_assests and pi.id_lang = 1',
                array(),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetInterestsData ($id) {
            $town = DBClass::Instance()->select(
                'portfolio_interests_val', 
                array('*'), 
                'id = :id', 
                array('id' => (int)$id), 
                '', 
                '', 
                '', 
                '', 
                '',
                '2'
            );
            
            $town_description = DBClass::Instance()->select(
                'portfolio_interests', 
                array('*'), 
                'id_interests = :id', 
                array('id' => (int)$id), 
                '', 
                'name', 
                '', 
                '', 
                '', 
                '2'
            );
            
            foreach ($town_description as $k => $v) {
                $data['interests'][$v['id_lang']] = array (
                    'name' => $v['name'],
                    'id_interests' => $v['id_interests']
                );
            }
            
            $data['active'] = $town;
            
            return $data;
        }
        
        public function GetHobbiData ($id) {
            $town = DBClass::Instance()->select(
                'portfolio_hobbi_val', 
                array('*'), 
                'id = :id', 
                array('id' => (int)$id), 
                '', 
                '', 
                '', 
                '', 
                '', 
                '2'
            );
            
            $town_description = DBClass::Instance()->select(
                'portfolio_hobbi', 
                array('*'), 
                'id_hobbi = :id', 
                array('id' => (int)$id), 
                '', 
                'name', 
                '', 
                '', 
                '', 
                '2'
            );
            
            foreach ($town_description as $k => $v) {
                $data['hobbi'][$v['id_lang']] = array (
                    'name' => $v['name'],
                    'id_hobbi' => $v['id_hobbi']
                );
            }
            
            $data['active'] = $town;
            
            return $data;
        }
        
        public function GetAssestsData ($id) {
            $town = DBClass::Instance()->select(
                'portfolio_assests_val', 
                array('*'), 
                'id = :id', 
                array('id' => (int)$id), 
                '', 
                '', 
                '', 
                '', 
                '', 
                '2'
            );
            
            $town_description = DBClass::Instance()->select(
                'portfolio_assests', 
                array('*'), 
                'id_assests = :id', 
                array('id' => (int)$id), 
                '', 
                'name', 
                '', 
                '', 
                '', 
                '2'
            );
            
            foreach ($town_description as $k => $v) {
                $data['assests'][$v['id_lang']] = array (
                    'name' => $v['name'],
                    'id_assests' => $v['id_assests']
                );
            }
            
            $data['active'] = $town;
            
            return $data;
        }
        
        public function addInterests ($data) {
            DBClass::Instance()->insert('portfolio_interests_val', array('val' => $data['active']));
            
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($data['interest'] as $k => $v) {
                DBClass::Instance()->insert('portfolio_interests', array('id_lang' => (int)$k, 'name' => $v['name'], 'id_interests' => (int)$last_id));
            }
        }

        public function addHobbi($data) {
            DBClass::Instance()->insert('portfolio_hobbi_val', array('val' => $data['active']));
            
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($data['hobbi'] as $k => $v) {
                DBClass::Instance()->insert('portfolio_hobbi', array('id_lang' => (int)$k, 'name' => $v['name'], 'id_hobbi' => (int)$last_id));
            }
        }
        
        public function addAssests($data) {
            DBClass::Instance()->insert('portfolio_assests_val', array('val' => $data['active']));
            
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($data['assests'] as $k => $v) {
                DBClass::Instance()->insert('portfolio_assests', array('id_lang' => (int)$k, 'name' => $v['name'], 'id_assests' => (int)$last_id));
            }
        }
        
        public function editInterests ($data, $id) {
            DBClass::Instance()->update('portfolio_interests_val', array('val' => $data['active'], 'id' => (int)$id), 'id = :id');
            
            DBClass::Instance()->deleteElement('portfolio_interests', array('id_interests' => (int)$id), '');
            foreach($data['interest'] as $k => $v) {
                DBClass::Instance()->insert('portfolio_interests', array('id_lang' => (int)$k, 'name' => $v['name'], 'id_interests' => (int)$id));
            }
        }

        public function editHobbi ($data, $id) {
            DBClass::Instance()->update('portfolio_hobbi_val', array('val' => $data['active'], 'id' => (int)$id), 'id = :id');
            
            DBClass::Instance()->deleteElement('portfolio_hobbi', array('id_hobbi' => (int)$id), '');
            foreach($data['hobbi'] as $k => $v) {
                DBClass::Instance()->insert('portfolio_hobbi', array('id_lang' => (int)$k, 'name' => $v['name'], 'id_hobbi' => (int)$id));
            }
        }
        
        public function editAssests ($data, $id) {
            DBClass::Instance()->update('portfolio_assests_val', array('val' => $data['active'], 'id' => (int)$id), 'id = :id');
            
            DBClass::Instance()->deleteElement('portfolio_assests', array('id_assests' => (int)$id), '');
            foreach($data['assests'] as $k => $v) {
                DBClass::Instance()->insert('portfolio_assests', array('id_lang' => (int)$k, 'name' => $v['name'], 'id_assests' => (int)$id));
            }
        }
        
        public function deleteInterests ($id) {
            DBClass::Instance()->deleteElement('portfolio_interests_val', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_interests', array('id_interests' => (int)$id), '');
        }

        public function deleteHobbi ($id) {
            DBClass::Instance()->deleteElement('portfolio_hobbi_val', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_hobbi', array('id_hobbi' => (int)$id), '');
        }
        
        public function deleteAssests ($id) {
            DBClass::Instance()->deleteElement('portfolio_assests_val', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_assests', array('id_assests' => (int)$id), '');
        }
        
        public function deleteUser ($id) {
            DBClass::Instance()->deleteElement('users', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('user_date', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('user_settings', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('users_list_for_chat', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio', array('id_user' => (int)$id), '');
            //DBClass::Instance()->deleteElement('messages_for_users', array(), '');
            DBClass::Instance()->deleteElement('message_for_user_from_admin', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('message_in_the_chat', array('from_user_id' => (int)$id, 'to_user_id' => (int)$id), '');
        }
        /*----- /Private users -----*/
        
        /*----- FQ support -----*/
        public function GetMessageList () {
            return DBClass::Instance()->select(
                'contacts',
                array('*'),
                '',
                array(),
                '',
                'name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function getRespond ($id) {
            return DBClass::Instance()->select(
                'contacts_respond',
                array('message'),
                'id_message = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function AddToSpam ($data) {
            DBClass::Instance()->insert('spamlist', $data);
            DBClass::Instance()->deleteElement('contacts', array('email_from' => $data['email']), '');
        }
        
        public function AddRespond ($data) {
            DBClass::Instance()->insert('contacts_respond', $data);
            DBClass::Instance()->update('contacts', array('read_status' => 1, 'id' => $data['id_message']), 'id = :id');
        }
        
        public function delete ($id) {
            DBClass::Instance()->deleteElement('contacts', array('id' => (int)$id), '');
        }
        /*----- /FQ support -----*/
        
        /*----- FQ comments -----*/
        public function GetComList () {
            return DBClass::Instance()->select(
                'adverts as a, comments_advert as ca left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ud.user_id = ca.user_id',
                array('ca.*, a.title, a.seo, ud.name as user_name, ud.lastname as user_lastname, ud.company_name, ud.company_link, ud.user_img'),
                'ca.advert_id = a.id',
                array(),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function AddCommentRespond($data) {
            DBClass::Instance()->insert('comments_advert', $data);
        }
        
        public function UpdValidCommentStatus ($id) {
            DBClass::Instance()->update('comments_advert', array('moderation' => '1', 'id' => (int)$id), 'id = :id');
        }
        
        public function deleteAdvert ($id) {
            DBClass::Instance()->deleteElement('category_advert', array('id' => (int)$id));
        }
        /*----- /FQ comments -----*/
        
        /*----- FQ Public -----*/
        public function GetPublicList () {
            return DBClass::Instance()->select(
                'publiccompany as p left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ud.user_id = p.user_id',
                array('p.*, ud.name as user_name, ud.lastname as user_lastname, ud.company_name, ud.patent, ud.user_img'),
                '',
                array(),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function deletePublicCompany ($id) {
            DBClass::Instance()->deleteElement('publiccompany', array('id' => (int)$id));
        }
        /*----- /FQ Public -----*/
        
        /*----- FQ Settings -----*/
        public function GetSettings () {
            return DBClass::Instance()->select(
                'settings',
                array('*'),
                '',
                array(),
                '',
                '',
                '',
                '1',
                '',
                '1'
            );
        }
        
        public function insertSettingsData ($data) {
            return DBClass::Instance()->insert('settings', $data);
        }
        
        public function updSettingsData ($data) {
            return DBClass::Instance()->update('settings', $data, 'id = :id');
        }

		public function exeptionSitemap ($data) {
			return DBClass::Instance()->update('sitemap', $data, 'site_name = :site_name');
		}
        
        public function getExtensionSitemap () {
            return DBClass::Instance()->select(
                'sitemap',
                array('*'),
                '',
                array(),
                '',
                '',
                '',
                '1',
                '',
                '1'
            );
        }
        /*----- /FQ Settings -----*/
        
        /*----- FQ Languages -----*/
        public function GetLangList () {
            return DBClass::Instance()->select('lang', array('*'), '', '', '', '', '', '', '', '2');
	    }
        
        public function GetLangData ($id) {
            return DBClass::Instance()->select('lang', array('*'), 'id = :id', array('id' => $id), '', '', '', '', '', '1');
        }
        
        public function SaveNewLanguage($updData, $id) {
            return DBClass::Instance()->update('lang', $updData, 'id = :id');
        }
       
        public function AddNewLanguage ($data) {
            return DBClass::Instance()->insert('lang', $data);
        }
        
        public function deletelang ($id) {
            return DBClass::Instance()->deleteElement('lang', array('id' => (int)$id), '');
        }
        /*----- /FQ Languages -----*/
        
        /*----- FQ DataBase Edition -----*/
        public function DBNames () {
            return DBClass::Instance()->DBAdmin('SHOW DATABASES');
        }
        
        public function DBTables ($dbname) {
            $array = DBClass::Instance()->DBAdmin('SELECT table_name, table_rows, engine, create_time, update_time, check_time, table_collation, table_comment FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = \'BASE TABLE\' AND TABLE_SCHEMA = \''.$dbname.'\'');
            
            foreach($array as $k => $t) {
                $array[$k]['table_name'] = substr($t['table_name'], 5);
            }
            
            return $array;
        }
        
        public function DBTablesColumns ($dbtable) {
            return DBClass::Instance()->DBAdmin('SHOW COLUMNS FROM tori_'.$dbtable);
        }
        
        public function DBTablesListrecords ($dbtable) {
            return DBClass::Instance()->DBAdmin('select * FROM tori_'.$dbtable);
            
            $listrecords = array('th');
            foreach($array as $k => $t) {
                $listrecords['th'] = array(
                    $array[0][$k]
                );
            }
            
            return $listrecords;
        }
        
        public function addNewRecord ($tablename, $tabledata) {
            return DBClass::Instance()->insert($tablename, $tabledata);
        }
        
        public function deleteRecord ($tablename, $tabledata) {
            return DBClass::Instance()->deleteElement($tablename, array('id' => $tabledata));
        }
        
        public function deleteColumn ($tablename, $tabledata) {
            return DBClass::Instance()->DBAdmin('ALTER TABLE `tori_'.$tablename.'` DROP `'.$tabledata.'`');
        }
        
        public function addNewColumn ($nameTable, $nameColumn, $typeColumn, $lengthColumn, $commentColumn = '', $defaultColumn = '', $aiColumn = '') {
            $query = 'tori_'.$nameTable;
            $query .= ' ADD `'.$nameColumn;
            $query .= '` '.$typeColumn.'('.$lengthColumn.')';
            
            if(empty($defaultColumn)) $query .= ' NOT NULL';
            else $query .= ' NOT NULL DEFAULT '.$defaultColumn;
            if(!empty($aiColumn)) $query .= ' AUTO_INCREMENT';
            if(!empty($commentColumn)) $query .= ' COMMENT \''.$commentColumn.'\'';
            if(!empty($aiColumn)) $query .= ' ADD   PRIMARY KEY  (`'.$nameColumn.'`)';
            //ALTER TABLE tori_advert_imgs ADD `IRYNA` text(10000) NOT NULL COMMENT 'FindQuick';
            return DBClass::Instance()->DBAdmin('ALTER TABLE '.$query);
        }
        /*----- /FQ DataBase Edition -----*/
	}
?>