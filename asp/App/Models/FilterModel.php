<?php
	class FilterModel extends Model {
        private function __construct(){}
        private static $instance = NULL;
        
        public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
        }
        
       public function GetFilterList () {
            $filters = DBClass::Instance()->select(
                'filter as f',
                array('f.id, f.title_filter'),
                '',
                array(),
                '',
                'title_filter',
                '',
                '',
                '',
                '2'
            );
            
            foreach ($filters as $k => $v){
                $filters[$k]['location'] = DBClass::Instance()->select(
                    'category_filter as cf, category_description as cd',
                    array('cd.title'),
                    'cf.id_category = cd.category_id and cf.id_filter = :id_filter and lang_id = 1',
                    array('id_filter' => $v['id']),
                    '',
                    'title',
                    '',
                    '',
                    '',
                    '2'
                );
            }
            
            return $filters;
       }
       
       public function GetFieldListOfGroup ($id) {
            return DBClass::Instance()->select(
                'fields_data as fd, fields_placeholder as fp, fields_fieldsgroup as ffg',
                array('fd.id, fd.type, fp.placeholder'),
                'fd.id = fp.id_field and id_lang = 1 and ffg.id_field = fd.id and ffg.id_fieldsgroup = :id_group',
                array('id_group' => (int)$id),
                '',
                'placeholder',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function GetFieldsGroupList () {
            return DBClass::Instance()->select(
                'fields_group',
                array('*'),
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
       
       public function addNewFilter ($data) {
            DBClass::Instance()->insert('filter', array('title_filter' => $data['namefilter'], 'sort' => $data['sort']));
            $last_id = DBClass::Instance()->getLastId();
        
            foreach($data['fields'] as $k => $v){
                DBClass::Instance()->insert('filter_fields', array('id_filter' => $last_id, 'id_field' => $v));
            }
            
            foreach($data['category'] as $k => $v){
                DBClass::Instance()->insert('category_filter', array('id_filter' => $last_id, 'id_category' => $v));
            }
       }
       
        public function deletefilter ($id) {
            DBClass::Instance()->deleteElement('filter', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('filter_fields', array('id_filter' => (int)$id));
            DBClass::Instance()->deleteElement('category_filter', array('id_filter' => (int)$id));
        }
	}
?>