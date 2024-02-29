<?php
	class LocalModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function GetCountryList () {
            return DBClass::Instance()->select(
                'country as c, country_other_lang as cl', 
                array('c.id, cl.name'), 
                'c.id = cl.id_country and cl.id_lang = :lang',
                array('lang' => (int)$_SESSION['lid']),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getRegionListOfCountry ($id) {
            return DBClass::Instance()->select(
                'country as c, region as r, region_other_lang as rl',
                array('r.id, rl.name'),
                'c.id = r.id_country and rl.id_lang = :lang and c.id = :id and r.id = rl.id_region',
                array('lang' => (int)$_SESSION['lid'], 'id' => $id),
                '',
                'name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function getProvincesListOfCountry ($id) {
            return DBClass::Instance()->select(
                'country as c, region as r, provinces as p, provinces_other_lang as pl',
                array('pl.name as p_name, p.id'),
                'p.id = pl.id_province and pl.id_lang = :lang and c.id = p.id_country and r.id = p.id_region and r.id = :id and c.id = r.id_country',
                array('lang' => (int)$_SESSION['lid'], 'id' => $id),
                '',
                'p_name',
                true,
                '',
                '',
                '2'
            );
        }
       
    }
?>