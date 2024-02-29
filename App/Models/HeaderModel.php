<?php
	class HeaderModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function HeaderInformation () {
            return DBClass::Instance()->select(
                'pages as p, pages_description as pd',
                array('p.id, p.seo, pd.title'),
                'p.id = pd.page_id and pd.lang_id = :lang',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'title',
                true,
                '15',
                '',
                '2'
            );
       }
       
       public function GetLangList () {
            return DBClass::Instance()->select(
                'lang',
                array('*'),
                'status = :st',
                array('st' => 1),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function GetLangCode ($lid) {
            return DBClass::Instance()->select(
                'lang',
                array('code'),
                'id = :id',
                array('id' => (int)$lid),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
	}
?>