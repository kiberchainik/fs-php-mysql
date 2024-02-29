<?php
	class LiveSearchModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function LiveSearch ($select, $from, $where, $param) {
            return DBClass::Instance()->select(
                $from,
                array($select),
                $where,
                $param,
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function Search_like ($union_query, $param) {
            return DBClass::Instance()->search_like($union_query, $param);
        }
	}
?>