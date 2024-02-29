<?php
	class CompanyController extends Controller {
	   public function action_index() {
	       $v = new View('site/companylist');
           $lang_company = $this->lang('company');
           $lang_portfolio = $this->lang('portfolio');
           
           $v->title = $lang_company['title'];
           $v->description = $lang_company['description'];
           $v->keywords = $lang_company['keywords'];
           $v->og_img = '';
           $v->text_more = $lang_company['more'];
           $v->text_category_companies = $lang_company['category_companies'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->mainmenu = $this->module('MainMenu');
           //$v->leftsidebar = $this->module('LeftSidebar');
           $v->company_category = CompanyModel::Instance()->GetCategoryList();
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           $v->text_specialists = $lang_portfolio['portfolio_list_specialists'];
           
           $page = (int)Router::getUriParam('page');
           $count = CompanyModel::Instance()->getCompanyCount(9);
           
           if($page < 1 or $page > $count) Url::local('404');
           
           $v->companyList = CompanyModel::Instance()->getCompanyPage($page, 9);
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('company'));
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_category(){
            $v = new View('site/companylist');
           $lang_company = $this->lang('company');
           $lang_portfolio = $this->lang('portfolio');
           
           $v->title = $lang_company['title'];
           $v->description = $lang_company['description'];
           $v->keywords = $lang_company['keywords'];
           $v->og_img = '';
           $v->text_more = $lang_company['more'];
           $v->text_category_companies = $lang_company['category_companies'];
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           
           $v->company_category = CompanyModel::Instance()->GetCategoryList();
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           $v->text_specialists = $lang_portfolio['portfolio_list_specialists'];
           
           $subCatId = (int)Router::getUriParam(2);
           
           $page = (int)Router::getUriParam('page');
           $count = CompanyModel::Instance()->getCompanyCount(9, $subCatId);
           
           if($page < 1 or $page > $count) Url::local('404');
           $v->companyList = CompanyModel::Instance()->getCompanyPage($page, 9, $subCatId);
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('company/category/'.$subCatId));
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_page(){
            $v = new View('site/page_company');
           $lang_company = $this->lang('company');
           $lang_portfolio = $this->lang('portfolio');
           
           $v->text_category_companies = $lang_company['category_companies'];
           $v->text_adverts = $lang_company['adverts'];
           $v->text_vacancies = $lang_company['vacancies'];
           $v->text_professionals = $lang_company['professionals'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           
           //$v->leftsidebar = $this->module('LeftSidebar');
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           $v->company_category = CompanyModel::Instance()->GetCategoryList();
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           $v->text_specialists = $lang_portfolio['portfolio_list_specialists'];
           
           $p_page = Router::getUriParam(2);
           //echo'<pre>'; print_r(urldecode($p_page)); echo '</pre>';
           if(empty($p_page)) {
                $v->vacance = 'Not selected company!';
           } else {
                $v->auth = false;
                if(AuthClass::instance()->isAuth()) {
                    $v->auth = true;
                    $v->u_id = AuthClass::instance()->getUser();
                    
                    $v->status_saved = AdvertsModel::Instance()->statusSavedAdvert($v->u_id['u_id'], $v->advertData['id']);
                }
                
                $v->companyDate = CompanyModel::Instance()->getDataCompany(urldecode($p_page));
                $v->adverts = CompanyModel::Instance()->getListAdvertsProfile($v->companyDate['user_id']);
                $v->vacanceList = CompanyModel::Instance()->getListVacanciesForUser($v->companyDate['user_id']);
                $v->branchlist = CompanyModel::Instance()->getListBranchOfCompany($v->companyDate['user_id']);
                //echo'<pre>'; print_r($v->companyDate); echo '</pre>';
                $v->og_img = $v->companyDate['user_img'];
                $v->title = $v->companyDate['company_name'];
                $v->description = $v->companyDate['about'];
                $v->keywords = $v->companyDate['about'].', '.$v->companyDate['company_name'];
           }
           
           $v->useTemplate();
	       $this->response($v);
       }
	}
?>