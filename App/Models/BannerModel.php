<?php
	class BannerModel extends Model {
	   
       private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
        
        public function getBanners ($limit = '') {
            return DBClass::Instance()->select(
                'banners as b, banners_description as bd',
                array('b.*, bd.title, bd.text'),
                'b.id = bd.id_banner and bd.id_lang = :lang',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'title',
                '',
                $limit,
                '',
                '2'
            );
        }
	}
?>