<?php 
	require_once EXCEPTION_PATH.'exception_loader.php';
	require_once CORE_BASE_PATH.'Controller.php';
	require_once CORE_BASE_PATH.'Model.php';
	require_once CORE_BASE_PATH.'View.php';
	require_once CORE_PATH.'Router.php';
	require_once CORE_PATH.'Autoloader.php';
	require_once CORE_PATH.'Url.php';
    
    spl_autoload_register('Autoloader::load');    
	
    Router::add("users/<page>?", [
        'controller' => 'users',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("portfolio/<page>?", [
        'controller' => 'portfolio',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("portfolio/category/".Router::getUriParam(2)."/<page>?", [
        'controller' => 'portfolio',
        'action' => 'category',
        'page' => 1
    ]);
    
    Router::add("vacancies/<page>?", [
        'controller' => 'vacancies',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("profile/vacancies/<page>?", [
        'controller' => 'profile',
        'action' => 'vacancies',
        'page' => 1
    ]);
    
    /*Router::add("profile/vacancies/<page>?", [
        'controller' => 'profile',
        'action' => 'vacancies',
        'page' => 1
    ]);*/
    
    Router::add("vacancies/category/".Router::getUriParam(2)."/<page>?", [
        'controller' => 'vacancies',
        'action' => 'category',
        'page' => 1
    ]);
    
    Router::add("vacancelocal/<local>?/<page>?", [
        'controller' => 'vacancelocal',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("vacancelocal/<local>?/category/<cat>?/<page>?", [
        'controller' => 'vacancelocal',
        'action' => 'category',
        'page' => 1
    ]);
    
    Router::add("vacancelocal/<local>?/category/<page>?", [
        'controller' => 'vacancelocal',
        'action' => 'category',
        'page' => 1
    ]);
    
    Router::add("branch/vacancie/".Router::getUriParam(2)."/".Router::getUriParam(3)."/<page>?", [
        'controller' => 'branch',
        'action' => 'vacancie',
        'page' => 1
    ]);
    
    Router::add("company/<page>?", [
        'controller' => 'company',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("company/category/".Router::getUriParam(2)."/<page>?", [
        'controller' => 'company',
        'action' => 'category',
        'page' => 1
    ]);
    
    Router::add("blog/<page>?", [
        'controller' => 'blog',
        'action' => 'index',
        'page' => 1
    ]);
    
    Router::add("blog/category/".Router::getUriParam(2)."/<page>?", [
        'controller' => 'blog',
        'action' => 'category',
        'page' => 1
    ]);
    
    Router::add("category/<page>?", [
        'controller' => 'category',
        'action' => 'index',
        'page' => 1
    ]);
    
    /*Router::add("adverts/<adverts>?", [
        'controller' => 'adverts',
        'action' => 'page'
        //'page' => 1
    ]);
    
    Router::add("vacancies/<vacancies>?", [
        'controller' => 'adverts',
        'action' => 'page'
        //'page' => 1
    ]);*/
    
    Router::add("category/page/".Router::getUriParam(2)."/<page>?", [
        'controller' => 'category',
        'action' => 'page',
        'page' => 1
    ]);
    
    /*Router::add("search/tags/".Router::getUriParam(2)."/<page>?", [
        'controller' => 'search',
        'action' => 'tags',
        'page' => 1
    ]);*/
    
    /*Router::add("search/<page>?", [
        'controller' => 'search',
        'action' => 'index',
        'page' => 1
    ]);*/
    
    Router::add("lang/<code>?", [
        'controller' => 'lang',
        'action' => 'index',
        'code' => LANG_DEFAULT
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