<?php
	class Autoloader {
	   const PATTERN = '/^([A-Z0-9][A-Za-z0-9]+)([A-Z][a-z]+)$/';
       private static $paths = array(
                'Model' => MODELS_PATH,
                'Helper' => HELPERS_PATH,
                'Module' => MODULES_PATH,
                'Config' => CONFIGS_PATH,
                'Class' => CORE_CLASSES_PATH
            );
       
       public static function load ($name) {
            if(!preg_match(self::PATTERN, $name, $arr)) return;
            if(empty(self::$paths[$arr[2]])) return;
            include self::$paths[$arr[2]].$name.'.php';
       }
	}
?>