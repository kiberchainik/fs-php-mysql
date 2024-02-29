<?php
    session_start();
	define('URLROOT', '');
    define('SITE', 'https://'.$_SERVER['HTTP_HOST']);
	define('DOCROOT', $_SERVER['DOCUMENT_ROOT'].'/'.URLROOT);
	define('APP_PATH', DOCROOT.'App/');
	define('CORE_PATH', DOCROOT.'Core/');
	define('HELPERS_PATH', DOCROOT.'Helpers/');
	define('MODULES_PATH', APP_PATH.'Modules/');
    define('FPDF_FONTPATH', HELPERS_PATH.'fpdf/font');
	
	define('CONTROLLERS_PATH', APP_PATH.'Controllers/');
	define('MODELS_PATH', APP_PATH.'Models/');
	define('VIEWS_PATH', APP_PATH.'Views/');
	define('TEMPLATES_PATH', APP_PATH.'Templates/');
	define('LANG_PATH', APP_PATH.'Language/');
    define('CONFIGS_PATH', CORE_PATH.'Config/');
	
	define('CORE_BASE_PATH', CORE_PATH.'Base/');
	define('CORE_CLASSES_PATH', CORE_PATH.'Classes/');
	define('EXCEPTION_PATH', CORE_PATH.'Exceptions/');
    
    define('LANG_DEFAULT', 'it');
    define('TEMPLATE_DEFAULT', 'martup');
    //echo $_SERVER['lang'];
    ini_set('display_errors', 'Off'); 
    ini_set('log_errors', 'Off');
    ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/log/errors.log');
    
    set_error_handler('err_handler');
    function err_handler($errno, $errmsg, $filename, $linenum) {
        $date = date('d-m-Y H:i:s (T)');
        $f = fopen('log/php-errors.log', 'a');
        $page = $_SERVER['REQUEST_URI'];
        
        if (!empty($f)) {
            $filename  = str_replace(__DIR__,'', $filename);
            $err  = "Data: $date\n Page: $page\r\n Error: $errmsg\r\n File: $filename\r\n String: $linenum\r\n";
            $err  .= "--------------------------------------------------------------------------------------\n";
            fwrite($f, $err);
            fclose($f);
        }
    }
    
    
    //ini_set('error_reporting', E_ALL);
    //ini_set('error_log', __DIR__ . '/php-errors.log');
    ini_set('display_errors', 0); // in the server change on 0
    ini_set('display_startup_errors', 0); // in the server change on 0
    
    //if(!isset($_SESSION['lid'])) $_SESSION['lid'] = LANG_DEFAULT;
    
	include CORE_PATH.'loader.php';
?>