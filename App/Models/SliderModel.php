<?php
	class SliderModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function getSliderList () {
            return DBClass::Instance()->select(
                'publiccompany as p, user_date as ud, users as u',
                array('p.*, ud.company_name, ud.name, ud.lastname, u.login'),
                'valid_status = 1 and show_status = 1 and p.user_id = ud.user_id and p.user_id = u.id',
                array(),
                '',
                'title',
                true,
                '15',
                '',
                '2'
            );
       }
       
       public function getSliderContent () {
            return DBClass::Instance()->select(
                'blog_article as ba, blog_article_description as bad',
                array('ba.id, ba.seo, ba.add_date, ba.logo, bad.title, bad.keywords, bad.description, bad.text'),
                'ba.id in (4, 6) and ba.id = bad.id_blog_article and bad.lang_id = :lang',
                array('lang' => $_SESSION['lid']),
                '',
                'id',
                '',
                '',
                '',
                '2'
            );
       }
	}
?>