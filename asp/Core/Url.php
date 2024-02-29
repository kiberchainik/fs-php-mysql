<?php
	class Url {
	   public static function local ($addr){
	       return SITE.'/'.$addr;
	   }
       
       public static function getAction ($controller, $action) {
            return self::local($controller.'/'.$action);
       }
	}
?>