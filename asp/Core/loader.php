<?php 
	require_once EXCEPTION_PATH.'exception_loader.php';
	require_once CORE_BASE_PATH.'Controller.php';
	require_once CORE_BASE_PATH.'Model.php';
	require_once CORE_BASE_PATH.'View.php';
	require_once CORE_PATH.'Router.php';
	require_once CORE_PATH.'Autoloader.php';
	require_once CORE_PATH.'Url.php';
    
    spl_autoload_register('Autoloader::load');    
	
    Router::add("adverts/<page>?", [
        'controller' => 'adverts',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("vacancies/<page>?", [
        'controller' => 'vacancies',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("blog/<page>?", [
        'controller' => 'blog',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("users/<page>?", [
        'controller' => 'users',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("usersapi/<page>?", [
        'controller' => 'usersapi',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("portfolio/<page>?", [
        'controller' => 'portfolio',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("banners/<page>?", [
        'controller' => 'banners',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("logout", [
        'controller' => 'login',
        'action' => 'logout'
    ]);
    
	try {
	    LangHelper::getLanguage();
		Router::Run();
	} catch (RouteException $e) {
	   echo 'Route error: '.$e->getMessage();
       Router::Load('Error');
	}
?>