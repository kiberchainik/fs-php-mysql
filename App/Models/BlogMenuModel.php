<?php
	class BlogMenuModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function ParentCategoryList () {
            $category = DBClass::Instance()->select(
                'category_blog as cb, category_blog_description as cbd',
                array('cb.id, cb.seo, cb.parent_id, cbd.title'),
                'cb.id = cbd.category_id and cbd.lang_id = :lang',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'title',
                true,
                '15',
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