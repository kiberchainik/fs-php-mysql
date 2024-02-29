<?php
	class BlogModel extends Model {
	   
       private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
        public function GetListArticles ($pagenum, $const = 5, $subCatId = '', $limit = '') {
            
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
            
            if($offset < $const) $offset = '';
            
            if(!empty($subCatId)){
                $from = 'blog_article as ba, blog_article_description as bad, category_blog as cb';
                $subCatIdWhere = ' and cb.seo = :id_category AND ba.id_category = cb.id';
                $params = array('lang' => (int)$_SESSION['lid'], 'id_category' => $subCatId);
            } else {
                $from = 'blog_article as ba, blog_article_description as bad';
                $subCatIdWhere = '';
                $params = array('lang' => (int)$_SESSION['lid']);
            }
            
            return DBClass::Instance()->select(
                $from,
                array('ba.*, bad.title, bad.description'),
                'ba.id = bad.id_blog_article and bad.lang_id = :lang and show_status = 1'.$subCatIdWhere,
                $params,
                '',
                'add_date',
                '',
                $const,
                $offset,
                '2'
            );
        }
        
        public function getArticlesCount ($const = 5, $subCatId = '') {
            if(!empty($subCatId)){
                $from = ', '.DBClass::Instance()->config['db_pref'].'category_blog as cb';
                $subCatIdWhere = ' and cb.seo = :id_category AND ba.id_category = cb.id';
                $params = array('id_category' => $subCatId);
            } else {
                $from = '';
                $subCatIdWhere = '';
                $params = array();
            }
            
            $count = DBClass::Instance()->getCount(
                'blog_article as ba'.$from,
                'show_status = 1'.$subCatIdWhere,
                $params,
                'ba.id'
            );
            
            return ceil($count['numCount']/$const);
       }
        
        public function GetBlogCategoryData ($id) {
            return $this->dbPDO->select(
                'category_blog as c, category_blog_description as cd', 
                array('c.id, c.parent_id, cd.title'), 
                '(c.seo = :id or c.id = :id) and c.id = cd.category_id and cd.lang_id = :lang_id',
                array('id' => $id, 'lang_id' => (int)$_SESSION['lang_id']),
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function GetLastArticles ($limit) {
            return DBClass::Instance()->select(
                'blog_article as ba, blog_article_description as bad',
                array('ba.seo, ba.logo, ba.add_date, bad.title, bad.description'),
                'ba.id = bad.id_blog_article and bad.lang_id = :lang and ba.show_status = 1',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'add_date',
                '',
                $limit,
                '',
                '2'
            );
        }
        
        public function getDataArticle ($id) {
            return DBClass::Instance()->select(
                'blog_article as ba, blog_article_description as bad, category_blog_description as cbd, category_blog as cb',
                array('ba.*, bad.title, bad.keywords, bad.description, bad.text, cbd.title as category_title, cb.seo as category_seo'),
                '(ba.seo = :id or ba.id = :id) and ba.id = bad.id_blog_article and bad.lang_id = :lang and cbd.lang_id = :lang and ba.id_category = cbd.category_id and ba.id_category = cb.id and ba.show_status = 1',
                array('id' => $id, 'lang' => (int)$_SESSION['lid']),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function UpdViewsBlog ($views, $id) {
            DBClass::Instance()->update('blog_article', array('vews' => (int)$views, 'id' => (int)$id), 'id = :id');
       }
	}
?>