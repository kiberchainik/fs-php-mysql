<?php
	class CategoryModel extends Model {
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

                //DBClass::Instance()->update('category_path', array('id_category' => (int)$id, 'id_path' => (int)$id, 'level' => (int)$level), 'id_category = :id');
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
            
            //DBClass::Instance()->insert('category_path', array('id_category' => (int)$category_id, 'id_path' => (int)$category_id, 'level' => (int)$level));
        }
       
       public function deletecategory ($id) {
            DBClass::Instance()->deleteElement('category', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('fields_category', array('id_category' => (int)$id));
            DBClass::Instance()->deleteElement('category_description', array('category_id' => (int)$id));
            DBClass::Instance()->deleteElement('category_typeadverts', array('id_category' => (int)$id));
        }
    }
?>