<?php
	class MainMenuModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function ParentCategoryList () {
            $category = DBClass::Instance()->select(
                'category as u, category_description as ud',
                array('u.id, u.seo, u.parent_id, ud.title'),
                'ud.category_id = u.id AND ud.lang_id = :lid',
                array('lid' => (int)$_SESSION['lid']),
                '',
                'title',
                'false',
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
        
        public function PushMenu () {
            $category = DBClass::Instance()->select(
                'category as u, category_description as ud',
                array('u.id, u.seo, u.parent_id, ud.title'),
                'ud.category_id = u.id AND ud.lang_id = :lid and u.parent_id = 0',
                array('lid' => (int)$_SESSION['lid']),
                '',
                'title',
                'false',
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
	}
?>