<?php
	class InformationModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
        public function GetInformationData ($seo) {
            return DBClass::Instance()->select(
                'pages as p, pages_description as pd',
                array('p.id, p.seo, p.date, pd.*'),
                'p.id = pd.page_id and (p.seo = :seo or p.id = :seo) and pd.lang_id = :lang',
                array('lang' => (int)$_SESSION['lid'], 'seo' => $seo),
                '',
                'title',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function GetInformation () {
            return DBClass::Instance()->select(
                'pages as p, pages_description as pd',
                array('p.id, p.seo, pd.title'),
                'p.id = pd.page_id and pd.lang_id = :lang',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'title',
                true,
                '',
                '',
                '2'
            );
        }
	}
?>