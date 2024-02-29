<?php
	class CategoryController extends Controller {
	   public function action_index() {
	       $v = new View('site/categorylist');
           $lang_category = $this->lang('category');
           
           $v->title = $lang_category['title'];
           $v->description = $lang_category['description'];
           $v->keywords = $lang_category['keywords'];
           $v->og_img = '';
           $v->text_title_category = $lang_category['title_category'];
           $v->text_vacancies = $lang_category['vacancies'];
           $v->text_professionals = $lang_category['professionals'];
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           //$v->leftsidebar = $this->module('LeftSidebar');
           
           $v->vacanciesCategoriList = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory();
           $v->portfolio_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           $v->categoryList = CategoryModel::Instance()->GetCategoryListWithoutParetnId();
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_page(){
           $v = new View('site/categorylistadverts');
           $lang_category = $this->lang('category');
           
           $v->title = $lang_category['title'];
           $v->description = $lang_category['description'];
           $v->keywords = $lang_category['keywords'];
           $v->og_img = '';
           $v->text_read_more = $lang_category['read_more'];
           
           $p_page = Router::getUriParam('page'); // p. num
           $subCat = Router::getUriParam(2); //apartament
           
           $v->header = $this->module('Header');
           $v->filter = $this->module('Filter');
           $v->footer = $this->module('Footer');
           
           $count = CategoryModel::Instance()->getAdvertsForCategoryCount(9, $subCat);
           
           if(empty($subCat)) header('Location: /category/');
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->categoryList = CategoryModel::Instance()->getAdvertDataForCategoryPage($p_page, 9, $subCat);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('category/page/'.$subCat));
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_filter () {
           $v = new View('site/filter_result');
           $lang_category = $this->lang('category');
           
           $v->title = $lang_category['title'];
           $v->description = $lang_category['description'];
           $v->keywords = $lang_category['keywords'];
           $v->og_img = '';
           $v->text_read_more = $lang_category['read_more'];
           
           $v->header = $this->module('Header');
           $v->filter = $this->module('Filter');
           $v->footer = $this->module('Footer');
           
           if(isset($_POST)) $_SESSION['filter'] = $_POST;
           
           if(isset($_SESSION['filter'])) {
               $data = array();
               foreach($_SESSION['filter'] as $f_name => $f_value) {
                    $f_name = trim(htmlspecialchars($f_name, ENT_COMPAT, 'UTF-8'));
                    $data[$f_name] = $this->post($f_name);
               }
               
               $subCat = Router::getUriParam(2);
               $v->adverts = AdvertsModel::Instance()->getFilterAdverts($subCat, $data);
           }
           
           if(!$_POST and !$_SESSION['filter']) $v->adverts = AdvertsModel::Instance()->getAllAdvertsForCategory($subCat);
           
           //$p_page = Router::getUriParam('page'); // p. num
           //$subCat = Router::getUriParam(2); //apartament
           
           //$count = CategoryModel::Instance()->getAdvertsForCategoryCount(9, $subCat);
           
           //if(empty($subCat)) header('Location: /category/');
           
           //if($p_page < 1 or $p_page > $count) Url::local('404');
           
           //$v->categoryList = CategoryModel::Instance()->getAdvertDataForCategoryPage($p_page, 9, $subCat);
           //$v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('category/page/'.$subCat));
           $v->pagination = '';
           
           $v->useTemplate();
	       $this->response($v);
       }
    }
?>