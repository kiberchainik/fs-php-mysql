<?php
	class LogoSliderModel extends Model {
	   
       private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
        
       
	}
?>