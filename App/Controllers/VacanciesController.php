<?php
	class VacanciesController extends Controller {
	   public function action_index() {
	       $v = new View('site/vacancieslist');
           $lang_vacance = $this->lang('vacancies');
           
           $v->title = $lang_vacance['title'];
           $v->description = $lang_vacance['description'];
           $v->keywords = $lang_vacance['keywords'];
           $v->og_img = '';
           $v->text_read_more = $lang_vacance['more'];
           $v->text_category_vacancies = $lang_vacance['category_vacancies'];
           
           BreadHelper::add('/vacancies/', 'Offerte di lavoro');
           $v->breadcrumb = BreadHelper::out();
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           
           $v->companylist = VacanciesModel::Instance()->getListCompany();
           $v->id_company = '';
           
           $page = (int)Router::getUriParam('page');
           $count = VacanciesModel::Instance()->getVacanciesCount(8);
           if($page < 1 or $page > $count) Url::local('404');
           $v->vacanciesList = VacanciesModel::Instance()->getVacanciesPage($page, 8, '', 'date');
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('vacancies'));
           
           $v->vacanciesCategoriList = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory($condition = '');
           
           $v->useTemplate();
           $this->response($v);
	   }
       
       public function action_category() {
	       $v = new View('site/vacancieslist');
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
           
           $subCatId = Router::getUriParam(2);
           $page = (int)Router::getUriParam('page');

           if(!$page) {
                $this->redirect(Url::local('vacancies'));
           }
           $count = VacanciesModel::Instance()->getVacanciesCount(8, $subCatId);
           if($page < 1 or $page > $count) Url::local('404');
           
           $v->vacanciesList = VacanciesModel::Instance()->getVacanciesPage($page, 8, $subCatId, 'date');
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('vacancies/category/'.$subCatId));
           
           $category_title = CategoryModel::Instance()->getTitleCategoryVacancies($subCatId);
           BreadHelper::add('/vacancies/', 'Offerte di lavoro');
           BreadHelper::add('/vacancies/category/'.$subCatId, $category_title['title']);
           $v->breadcrumb = BreadHelper::out();
           
           $v->vacanciesCategoriList = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory($condition = '');
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_page(){
           $v = new View('site/page_vacancies');
           $lang_vacance = $this->lang('vacancies');
           
           $v->text_category_vacancies = $lang_vacance['category_vacancies'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->mainmenu = $this->module('MainMenu');
           
           $v->text_candidat_name = $lang_vacance['candidat_name'];
           $v->text_candidat_lastname = $lang_vacance['candidat_lastname'];
           $v->text_candidat_email = $lang_vacance['candidat_email'];
           $v->text_candidat_cv = $lang_vacance['candidat_cv'];
           $v->text_candidat_text = $lang_vacance['candidat_text'];
           
           $v->vacanciesCategoriList = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory($condition = '');
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           
           $p_page = urldecode(Router::getUriParam(2));
           $vacance = VacanciesModel::Instance()->getDataVacancies($p_page);
           
           if(empty($vacance)) {
                $this->redirect(Url::local('vacancies'));
                $v->og_img = '';
                $v->title = 'Vacance not found!';
                $v->description = 'Vacance not found!';
                $v->keywords = '';
                $v->vacance = 'Vacance not found!';
           } else {
                $views = $vacance['views'];
               
               $v->candidatIsset = false;
               if(AuthClass::instance()->isAuth()) {
                   $v->u_data = AuthClass::instance()->getUser();
                   if($v->u_data['type_person'] != "4") {
                        $getPortfolioId = PortfolioModel::Instance()->getPortfolioId($v->u_data['u_id']);
                        $v->candidatIsset = PortfolioModel::Instance()->ifCandidatExist($vacance['id'], $getPortfolioId['id'], $v->u_data['u_id']);
                   }
                   
                   if($v->u_data['u_id'] != $vacance['id_user']) {
                        $views += 1;
                   }
               } else {
                    $v->u_data = false;
                    $views += 1;
               }
            
                $v->requirements_nec = VacanciesModel::Instance()->getRequirementsOfVacancyNEC($vacance['id']);
                $v->requirements_des = VacanciesModel::Instance()->getRequirementsOfVacancyDES($vacance['id']);
                
               $v->og_img = SITE.'/'.$vacance['user_img'];
               $v->title = $vacance['title'];
               $v->description = $vacance['short_desc'];
               $v->keywords = $vacance['tags'];
               $v->text_by = $lang_vacance['by'];
               $v->text_views = $lang_vacance['views'];
               $v->text_requisiti_obbligatori = $lang_vacance['requisiti_obbligatori'];
               $v->text_requisiti_desiderabili = $lang_vacance['requisiti_desiderabili'];
               $v->text_tags = $lang_vacance['tags'];
               $v->text_reply = $lang_vacance['reply'];
               $v->text_add_portfolio = $lang_vacance['add_portfolio'];
               $v->text_send = $lang_vacance['send'];
               $v->text_professionals = $lang_vacance['professionals'];
               $v->text_age = $lang_vacance['age'];
               $v->text_special_knowledge = $lang_vacance['special_knowledge'];
               $v->text_experience = $lang_vacance['experience'];
               $v->text_without_experience = $lang_vacance['without_experience'];
               $v->text_Driver_license = $lang_vacance['Driver_license'];
               $v->text_18_25 = $lang_vacance['18_25'];
               $v->text_18 = $lang_vacance['18'];
               $v->text_own_transport = $lang_vacance['own_transport'];
               $v->text_education = $lang_vacance['education'];
               $v->text_25_30 = $lang_vacance['25_30'];
               $v->text_30_45 = $lang_vacance['30_45'];
               $v->text_45 = $lang_vacance['45'];
               $v->text_specialized_secondary = $lang_vacance['specialized_secondary'];
               $v->text_half_year = $lang_vacance['half_year'];
               $v->text_languages = $lang_vacance['languages'];
               $v->text_yes = $lang_vacance['yes'];
               $v->text_year = $lang_vacance['year'];
               $v->text_Up_to_5_years = $lang_vacance['Up_to_5_years'];
               $v->text_Morethan_5_years = $lang_vacance['Morethan_5_years'];
               $v->text_no = $lang_vacance['no'];
               $v->text_non_patent = $lang_vacance['non_patent'];
               $v->text_category_m = $lang_vacance['category_m'];
               $v->text_category_a1 = $lang_vacance['category_a1'];
               $v->text_category_a = $lang_vacance['category_a'];
               $v->text_category_b1 = $lang_vacance['category_b1'];
               $v->text_category_b = $lang_vacance['category_b'];
               $v->text_category_be = $lang_vacance['category_be'];
               $v->text_category_tb = $lang_vacance['category_tb'];
               $v->text_category_tm = $lang_vacance['category_tm'];
               $v->text_category_c1 = $lang_vacance['category_c1'];
               $v->text_category_c1e = $lang_vacance['category_c1e'];
               $v->text_category_c = $lang_vacance['category_c'];
               $v->text_category_ce = $lang_vacance['category_ce'];
               $v->text_category_d1 = $lang_vacance['category_d1'];
               $v->text_category_d1e = $lang_vacance['category_d1e'];
               $v->text_category_d = $lang_vacance['category_d'];
               $v->text_category_de = $lang_vacance['category_de'];
               $v->text_candidat = $lang_vacance['candidatura'];
               $v->text_log_reg = $lang_vacance['log_reg'];
               $v->text_candidat_sended = $lang_vacance['candidat_sended'];
               $v->text_high = $lang_vacance['high'];
               $v->text_incomplete_higher = $lang_vacance['incomplete_higher'];
                
               if($vacance['id_filial'] !== NULL) {
                    $vacance['email'] = $vacance['filial_email'];
                    $vacance['company_name'] = $vacance['filial_name'];
                    $vacance['company_link'] = $vacance['filial_url_company'];
                    $vacance['mobile'] = $vacance['filial_phone'];
                    $vacance['address'] = $vacance['filial_address'];
                    $vacance['user_img'] = $vacance['filial_img'];
               }
                
               if(!empty($vacance['tags'])) {
                    $v->tags = explode(',', $vacance['tags']);
               }
                $v->vacance = $vacance;
                if(isset($v->u_data['type_person']) and $v->u_data['type_person'] != '4') {
                    $v->m_email = (isset($v->u_data['email']))?$v->u_data['email']:'';
                    $v->m_auth_id = (isset($v->u_data['u_id']))?$v->u_data['u_id']:'';
                    $v->m_name = (isset($v->u_data['name']))?$v->u_data['name'].' '.$v->u_data['lastname']:'';
               }
               VacanciesModel::Instance()->UpdViewsVacancies($views, $v->vacance['id']);
           }
           /*echo"<pre>";
           print_r($vacance);
           echo '</pre>';*/
           
           
           $v->useTemplate();
	       $this->response($v);
       }
	}
?>