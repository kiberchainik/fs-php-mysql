<?php
	class HomeModule extends Controller {
	   public function action_index() {
	       $v = new View('site/home');
           
           $lang_home = $this->lang('home');
           
           $v->text_read_more = $lang_home['read_more'];
           $v->text_features_adverts = $lang_home['features_adverts'];
           $v->text_popular_adverts = $lang_home['popular_adverts'];
           $v->text_most_talked_about = $lang_home['most_talked_about'];
           $v->text_users_portfolio = $lang_home['users_portfolio'];
           $v->text_company = $lang_home['company'];
           $v->text_view_all = $lang_home['view_all'];
           $v->text_vacancies = $lang_home['vacancies'];
           $v->text_portfolio = $lang_home['portfolio'];
           $v->text_new_portfolio = $lang_home['new_portfolio'];
           $v->text_all_portfolio = $lang_home['all_portfolio'];
           $v->text_latest_news = $lang_home['latest_news'];
           //$v->text_add_date  = $lang_home['add_date'];
           $v->text_all_portfolio = $lang_home['all_portfolio'];
           $v->text_last_article_descriprion = $lang_home['last_article_descriprion'];
           $v->text_one = $lang_home['one'];
           $v->text_two = $lang_home['two'];
           $v->text_three = $lang_home['three'];
           $v->text_for = $lang_home['for'];
           $v->text_vacancies_home_title = $lang_home['vacancies_home_title'];
           $v->text_vacancies_home_description = $lang_home['vacancies_home_description'];
           $v->text_users_home_title = $lang_home['users_home_title'];
           $v->text_users_home_description = $lang_home['users_home_description'];
           $v->text_blog_home_title = $lang_home['blog_home_title'];
           $v->text_blog_home_description = $lang_home['blog_home_description'];
           $v->text_curriculum_home_text = $lang_home['curriculum_home_text'];
           $v->text_api_connection_dscription = $lang_home['api_connection_dscription'];
           $v->text_footer_home_text = $lang_home['footer_home_text'];
           
           $v->slider = $this->module('Slider');
           $v->banners = $this->module('Banners');
           $v->logoCompany = $this->module('LogoSlider');
           
           $v->public = false;
           $v->best = false;
           
           $arr_features_adverts = AdvertsModel::Instance()->GetNewAdvertsForMain('12');
           $arr_popular_adverts = AdvertsModel::Instance()->GetPopularAdvertsForMain('12');
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory('9');
           $v->vacancies_menu_portfolio = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList('9');
           $v->companyCategory = CompanyModel::Instance()->GetCategoryList('9');
           $v->arr_user_portfolio = PortfolioModel::Instance()->getAllPortfolioForMain('6');
           $v->arr_companys = CompanyModel::Instance()->getListCompany('6');
           
           $LastArticlesList = BlogModel::Instance()->GetLastArticles('6');
           foreach($LastArticlesList as $k => $s) {
                $LastArticlesList[$k]['webp'] = preg_replace('".(jpg|jpeg|png)$"', '.webp', $s['logo']);
           }
           $v->LastArticlesList = $LastArticlesList;
           
           $vacanciesList = VacanciesModel::Instance()->getListVacanciesForMain('9');
           //$v->first_vacance = array_shift($vacanciesList); //cut first vacance
           $v->arr_vacances = $vacanciesList;
           
           foreach ($arr_features_adverts as $k => $na) {
               $adv_imgs = AdvertsModel::Instance()->getListImagesAdvert($na['id']);
               $arr_features_adverts[$k]['imgs'] = $adv_imgs['list'];
               $arr_features_adverts[$k]['webp'] = preg_replace('".(jpg|jpeg|png)$"', '.webp', $adv_imgs['list'][0]['src']);
               $arr_features_adverts[$k]['add_date'] = date('d/M/Y', $arr_features_adverts[$k]['add_date']);
           }
           //echo '<pre>'; print_r($arr_popular_adverts); echo '</pre>';
           foreach ($arr_popular_adverts as $k => $na) {
               $adv_imgs = AdvertsModel::Instance()->getListImagesAdvert($na['id']);
               $arr_popular_adverts[$k]['imgs'] = $adv_imgs['list'];
               $arr_popular_adverts[$k]['webp'] = preg_replace('".(jpg|jpeg|png)$"', '.webp', $adv_imgs['list'][0]['src']);
               $arr_popular_adverts[$k]['add_date'] = date('d/M/Y', $arr_popular_adverts[$k]['add_date']);
           }
           
           $v->arr_features_adverts = $arr_features_adverts;
           $v->arr_popular_adverts = $arr_popular_adverts;
           
	       $this->response($v);
	   }
	}
?>