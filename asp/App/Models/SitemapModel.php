<?php
    class SitemapModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
        public function updExeptionSitemap ($data) {
			return DBClass::Instance()->update('sitemap', $data, 'id = :id');
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
    }
?>