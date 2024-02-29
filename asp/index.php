<?php
    session_start();
	define('URLROOT', '');
    define('SITEMAIN', 'https://findsol.it/');
    define('SITE', 'https://'.$_SERVER['HTTP_HOST']);
	define('DOCROOT', $_SERVER['DOCUMENT_ROOT'].'/'); ///home5/urlpyrtf/public_html/asp/
	define('APP_PATH', DOCROOT.'App/');
	define('CORE_PATH', DOCROOT.'Core/');
	define('HELPERS_PATH', DOCROOT.'Helpers/');
	define('MODULES_PATH', APP_PATH.'Modules/');
	
	define('CONTROLLERS_PATH', APP_PATH.'Controllers/');
	define('MODELS_PATH', APP_PATH.'Models/');
	define('VIEWS_PATH', APP_PATH.'Views/');
	define('TEMPLATES_PATH', APP_PATH.'Templates/');
	define('LANG_PATH', APP_PATH.'Language/');
    define('CONFIGS_PATH', CORE_PATH.'Config/');
	
	define('CORE_BASE_PATH', CORE_PATH.'Base/');
	define('CORE_CLASSES_PATH', CORE_PATH.'Classes/');
	define('EXCEPTION_PATH', CORE_PATH.'Exceptions/');
    
    define('LANG_DEFAULT', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    define('TEMPLATE_DEFAULT', 'tmart');
    //echo $_SERVER['lang'];
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 0); // in the server change on 0
    ini_set('display_startup_errors', 0); // in the server change on 0
    ini_set('max_execution_time', '300');
    //if(!isset($_SESSION['lid'])) $_SESSION['lid'] = LANG_DEFAULT;
    //echo DOCROOT;
	include CORE_PATH.'loader.php';
?>