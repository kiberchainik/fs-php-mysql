<?php
    class CountryModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
	   public function getCountryList () {
            return DBClass::Instance()->select(
                'country as c, country_other_lang as cl',
                array('c.id, cl.name'),
                'c.id = cl.id_country and cl.id_lang = :lang',
                array('lang' => 1),
                '',
                'name',
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
    }
?>