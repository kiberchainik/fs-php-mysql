<?php
	class DBConfig {
	   public static function load ($name) {
	       return include CONFIGS_PATH.$name.'.php';
	   }
	}
?>