<?php
	class VacancelocalController extends Controller {
	   public function action_index() {
	       $v = new View('site/vacancelocallist');
           $lang_vacance = $this->lang('vacancies');
           
           $v->title = $lang_vacance['title'];
           $v->description = $lang_vacance['description'];
           $v->keywords = $lang_vacance['keywords'];
           $v->og_img = '';
           $v->text_category_vacancies = $lang_vacance['category_vacancies'];
           $v->text_read_more = $lang_vacance['more'];
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           $v->companylist = VacanciesModel::Instance()->getListCompany();
           $v->id_company = '';
           
           $loc = Router::getUriParam('local');
           $v->loc = $loc;
           $page = (int)Router::getUriParam('page');

           $count = VacancelocalModel::Instance()->getVacanciesCountLocation($loc, 8);
           
           if($page < 1 or $page > $count) Url::local('404');
           
           $v->vacanciesList = VacancelocalModel::Instance()->getVacanciesPageLocation($page, $loc, 8);
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('vacancelocal/'.$loc));
           
           BreadHelper::add('/vacancies/', 'Offerte di lavoro');
           BreadHelper::add('/vacancelocal/'.$loc, $loc);
           $v->breadcrumb = BreadHelper::out();
           
           $v->vacanciesCategoriList = VacancelocalModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory($loc);
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_category() {
	       $v = new View('site/vacancelocallist');
           $lang_vacance = $this->lang('vacancies');
           
           $v->title = $lang_vacance['title'];
           $v->description = $lang_vacance['description'];
           $v->keywords = $lang_vacance['keywords'];
           $v->og_img = '';
           $v->text_category_vacancies = $lang_vacance['category_vacancies'];
           $v->text_read_more = $lang_vacance['more'];
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           $v->companylist = VacanciesModel::Instance()->getListCompany();
           $v->id_company = '';
           
           $loc = Router::getUriParam('local');
           $v->loc = $loc;
           $subCatId = Router::getUriParam('cat');
           $page = (int)Router::getUriParam('page');

           if(!$page) {
                $this->redirect(Url::local('vacancies'));
           }
           $count = VacancelocalModel::Instance()->getVacanciesCountLocation($loc, 8, $subCatId);
           if($page < 1 or $page > $count) Url::local('404');
           
           $v->vacanciesList = VacancelocalModel::Instance()->getVacanciesPageLocation($page, $loc, 8, $subCatId);
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('vacancelocal/'.$loc.'/category/'.$subCatId));
           
           $category_title = CategoryModel::Instance()->getTitleCategoryVacancies($subCatId);
           BreadHelper::add('/vacancies/', 'Offerte di lavoro');
           BreadHelper::add('/vacancelocal/'.$loc, $loc);
           BreadHelper::add('/vacancelocal/'.$loc.'/category/'.$subCatId, $category_title['title']);
           $v->breadcrumb = BreadHelper::out();
           
           $v->vacanciesCategoriList = VacancelocalModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory($loc);
           
           $v->useTemplate();
	       $this->response($v);
	   }
    }
?>