<?php
	class ProfileController extends Controller {
	   public function action_index() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local('login'));
	       }
           
           $v = new View('account/profile');
           $profile = $this->lang('profile');
           
           $v->title = $profile['title'];
           $v->description = '';
           $v->keywords = '';
           $v->og_img = '';
           
           $v->header = $this->module('Header');
           $v->profilemenu = $this->module('ProfileMenu');
           $v->footer = $this->module('Footer');
           $v->text_users = $profile['text_users'];
           $v->text_portfolio = $profile['text_portfolio'];
           $v->text_vacancies = $profile['text_vacancies'];
           $v->text_adverts = $profile['text_adverts'];
           $v->text_autosearch = $profile['text_autosearch'];
           $v->text_choose = $profile['text_choose'];
           $v->text_comma = $profile['text_comma'];
           $v->text_company = $profile['text_company'];
           $v->text_adverts_dont_found = $profile['adverts_dont_found'];
           $v->profile_data = AuthClass::instance()->getUser();
           
           $v->autosearch = ProfileModel::Instance()->selectUserAutosearchKeywords($v->profile_data['u_id']);
           
           $v->tables = array(
                'vacancies' => $profile['text_vacancies'], 
                'portfolio' => $profile['text_portfolio'], 
                'company' => $profile['text_company'], 
                'adverts' => $profile['text_adverts']
           );
           
           if($v->autosearch) {
               $autosearch_result = '';
               $v->category_autosearch = unserialize($v->autosearch['tables']);
               $autosearch_result = ProfileModel::Instance()->getAutosearchList($v->autosearch['keywords'], $v->category_autosearch);
           
               foreach($autosearch_result as $k => $r) {
                  $autosearch_result[$k]['key_main_array'] = $profile['text_'.$k];
               }
               $v->autosearch_result = $autosearch_result;
           }
           
           //$v->userData = AuthClass::instance()->getUser();
           $profile_adverts = ProfileModel::Instance()->getListAdvertsForProfile($v->profile_data['u_id']);
           foreach ($profile_adverts as $k => $ad) {
                $listImgsAdverts = ProfileModel::Instance()->getListImagesAdvert($profile_adverts[$k]['id']);
                if($listImgsAdverts['count'] > 0) $profile_adverts[$k]['imgs'] = $listImgsAdverts['list'];
            }
            $v->profile_adverts = $profile_adverts;
            
            $v->message_from_admin = MessagesModel::Instance()->getMessagesFromAdmin($v->profile_data['u_id']);
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_autosearch () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
            
            $profile_data = AuthClass::instance()->getUser();
            
            if(($this->post('category_autosearch'))) $category_autosearch = serialize($this->post('category_autosearch'));
                else $category_autosearch = '';
            
            if($this->post('searchkeywords')) {
                $numUserKeywords = ProfileModel::Instance()->numUserKeywords($profile_data['u_id']);
                
                if($numUserKeywords['numCount'] != '0') ProfileModel::Instance()->updUserKeywords($profile_data['u_id'], $this->post('searchkeywords'), $category_autosearch);
                else ProfileModel::Instance()->addAutosearchKeywords($profile_data['u_id'], $this->post('searchkeywords'), $category_autosearch);
            } else {
                ProfileModel::Instance()->deletAautosearchUserKeywords($profile_data['u_id']);
            }
            
            $this->redirect(Url::local('profile'));
       }
       
       public function action_edit () {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $v = new View('account/editprofile');
           $profile = $this->lang('profile');
           $profile_id = AuthClass::instance()->getUser();
           
           $v->title = $profile['edit_title'];
           $v->description = $profile['edit_description'];
           $v->keywords = '';
           $v->og_img = '';
           $v->text_p_iva = $profile['edit_p_iva'];
           $v->text_company_name = $profile['edit_company_name'];
           $v->text_company_link = $profile['edit_company_link'];
           $v->text_field_about = $profile['edit_field_about'];
           $v->text_select_file = $profile['edit_select_file'];
           $v->text_field_img_logo = $profile['edit_field_img_logo'];
           $v->text_select_type_person = $profile['edit_select_type_person'];
           $v->text_name = $profile['edit_name'];
           $v->text_lastname = $profile['edit_lastname'];
           $v->text_email = $profile['edit_email'];
           $v->text_number_mobile = $profile['edit_number_mobile'];
           $v->text_adres = $profile['edit_adres'];
           $v->text_edit_profile_settings_subscript_news = $profile['edit_profile_settings_subscript_news'];
           $v->text_edit_profile_settings_subscript_update_site = $profile['edit_profile_settings_subscript_update_site'];
           $v->text_edit_profile_settings_online_status = $profile['edit_profile_settings_online_status'];
           $v->text_edit_profile_settings_message_status = $profile['edit_profile_settings_message_status'];
           $v->text_edit_profile_settings_adverts_status = $profile['edit_profile_settings_adverts_status'];
           $v->text_edit_profile_settings_chat_message = $profile['edit_profile_settings_chat_message'];
           $v->text_edit_profile_settings_comments_permission = $profile['edit_profile_settings_comments_permission'];
           $v->text_yes = $profile['yes'];
           $v->text_no = $profile['no'];
           $v->text_save = $profile['save'];
           $v->text_btn_delete_account = $profile['delete_account'];
           $v->text_atention_text_delete = $profile['atention_text_delete'];
           
           $v->text_edit_profile_settings_site = $profile['edit_profile_settings_site'];
           
           $v->userDate = ProfileModel::Instance()->getUserDate($profile_id['u_id']);
           $v->type_person = ProfileModel::Instance()->GetTypesPerson();
           $v->type_company = ProfileModel::Instance()->GetTypesCompany();
           
           $v->userSettingsSite = AuthClass::Instance()->getUserSiteSettings();
           
           $v->header = $this->module('Header');
           $v->profilemenu = $this->module('ProfileMenu');
           $v->footer = $this->module('Footer');
           
           $v->isAccessIsset = ProfileModel::Instance()->isAccessIsset($profile_id['u_id']);
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_gettypecompany () {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $type_company = ProfileModel::Instance()->GetTypesCompany();
           echo json_encode($type_company);
       }
       
       public function action_save_user_data() {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $profile = $this->lang('profile');
           $profile_id = AuthClass::instance()->getUser();
        
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            if ($this->post('name') == '') $msg['errors']['name'] = $profile['edit_error_empty_name'];
            if ($this->post('lastname') == '') $msg['errors']['lastname'] = $profile['edit_error_empty_lastname'];
            //if ($this->post('email') == '') $msg['errors']['email'] = $profile['edit_error_empty_email'];
            if ($this->post('mobile') == '') $msg['errors']['mobile'] = $profile['edit_error_empty_mobile'];
                else $mobile = str_replace('_', '', $this->post('mobile'));
            
            if ($this->post('person') == '4') {
                if ($this->post('p_iva') == '') $msg['errors']['p_iva'] = $profile['edit_error_empty_p_iva'];
                if ($this->post('company_name') == '') $msg['errors']['company_name'] = $profile['edit_error_empty_company_name'];
                
                if ($this->post['company_link'] != '') {
                    if(!HTMLHelper::validLinks($this->post['company_link'])) $msg['errors']['company_link'] = $profile['edit_error_company_link'];
                }
                
                if ($this->post('type_company')) {
                    $type = ProfileModel::Instance()->getTypeUserCompany($profile_id['u_id']);
                    if(empty($type)) ProfileModel::Instance()->addTypeCompany($this->post('type_company'), $profile_id['u_id']);
                }
            
            }// elseif($this->post('person')) $msg['errors']['person'] = $profile['edit_error_empty_type_person'];
            
            if ($this->post('about') == '') $msg['errors']['about'] = $profile['edit_error_empty_about'];
           
           if(isset($_FILES['profile_logo']) and !empty($_FILES['profile_logo']['name'])) {
                $avatar = UploadHelper::UploadOneImage('users/'.$profile_id['u_id'], $_FILES['profile_logo'], $profile_id['login']);
            } else {
                $avatar = ProfileModel::Instance()->getUserLogo($profile_id['u_id']);
                
                if(empty($avatar)) $msg['errors']['profile_logo'] = $profile['edit_error_empty_logo'];
                else $avatar = $avatar['user_img'];
            }
            
            $UserDate = array(
                'user_id' => $profile_id['u_id'],
                'name' => $this->post('name'),
                'lastname' => $this->post('lastname'),
                'mobile' => $mobile,
                'address' => '',
                /*'country' => htmlspecialchars($post['country']),
                'region' => htmlspecialchars($post['region']),
                'town' => htmlspecialchars($post['city']),*/
                //'type_person' => $this->post('person'),
                'patent' => $this->post('p_iva'),
                'company_name' => $this->post('company_name'),
                'company_link' => $this->post('company_link'),
                'about' => $this->post('about'),
                'user_img' => $avatar
            );
            
            
            if(empty($msg['errors'])) {
                $updUserValidStatus = array('id' => (int)$profile_id['u_id'], 'validStatus' => '1');
                ProfileModel::Instance()->updUser($updUserValidStatus);
                                                                
                if (ProfileModel::Instance()->editProfile($UserDate)) {
                    $msg['errors']['other_error'] = $profile['edit_other_error_edit'];
                } else {
                    $msg['success'] = $profile['edit_profile_data_success'];
                }
            } echo json_encode($msg);
       }
       
       public function action_save_site_settings () {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $profile = $this->lang('profile');
           $profile_id = AuthClass::instance()->getUser();
           $profile_settings = AuthClass::instance()->getUserSiteSettings();
           
           $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            $UserDate = array(
                'user_id' => $profile_id['u_id'],
                'subscription_news' => $this->post('subscript_news'),
                'subscription_site_update' => $this->post('subscript_update_site'),
                'show_online_status' => $this->post('online_status'),
                'message_status' => $this->post('message_status'),
                'subscription_new_adverts' => $this->post('adverts_status'),
                'chat_message' => $this->post('chat_message'),
                'comments_permission' => $this->post('comments_permission')
            );                
            
            if(empty($profile_settings)) {
                if (ProfileModel::Instance()->addUserSettings($UserDate)) {
                    $msg['errors'][] = $profile['error_write_in_db'];
                } else {
                    $msg['success'] = $profile['edit_profile_data_success'];
                }
            } else {
                if (ProfileModel::Instance()->editProfileSettings($UserDate)) {
                    $msg['errors'][] = $profile['error_save_in_db'];
                } else {
                    $msg['success'] = $profile['edit_profile_data_success'];
                }
            }
            
            echo json_encode($msg);
       }
       
       public function action_delete () {
           if(!AuthClass::instance()->isAuth()) {
	          $this->redirect(Url::local(''));
	       }
           
           $id_adverd = Router::getUriParam(2);
           
           $folderAdv = ProfileModel::Instance()->getAdvertFolderImages($id_adverd);
           
           if(!empty($folderAdv)) {
                ProfileModel::Instance()->deleteAdvert($id_adverd);
                UploadHelper::removeDirectory('adverts'.$folderAdv['seo']);
           }
           
           $this->redirect(Url::local(''));
       }
       
       public function action_delete_account () {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $profile_id = AuthClass::instance()->getUser();
            $user_adv = ProfileModel::Instance()->getSeoAdvertsOfUser($profile_id['u_id']);
            /*echo'<pre>';
            print_r($user_adv);
            echo'<pre>';*/
            
            ProfileModel::Instance()->deleteAccount($profile_id['u_id']);
            UploadHelper::removeDirectory('users/'.$profile_id['u_id']);
            UploadHelper::removeDirectory('portfolio/'.$profile_id['u_id']);
            
            if(!empty($user_adv)) {
                foreach ($user_adv as $k) {
                    AdvertsModel::Instance()->deleteAdvert($k['id']);
                }
                
                foreach($user_adv as $k) {
                    $this->removeDirectory('adverts/'.$k['seo']);
                }
            }
            AuthClass::instance()->logout();
            $this->redirect(Url::local(''));
        }
        
        public function action_messages () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            
            $v = new View('account/messages');
            $lang_messages = $this->lang('messages');
            
            $v->title = $lang_messages['title'];
            $v->description = '';
            $v->keywords = '';
           $v->og_img = '';
            $v->text_inbox = $lang_messages['inbox'];
            $v->text_sended = $lang_messages['sended'];
            $v->text_reply = $lang_messages['reply'];
            $v->text_messages_non = $lang_messages['messages_non'];
           
            $v->header = $this->module('Header');
            $v->profilemenu = $this->module('ProfileMenu');
            $v->footer = $this->module('Footer');
            
            $v->messagesInbox = MessagesModel::Instance()->getAllMessagesFromUsers($u_data['u_id']);
            $v->messagesSended = MessagesModel::Instance()->getAllMessagesForUsers($u_data['u_id']);
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_portfolio () {
           if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
           $u_data = AuthClass::instance()->getUser();
           if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
           
           $v = new View('account/portfolio');
           $user_portfolio = $this->lang('portfolio');
           
           $v->title = $user_portfolio['acc_portfolio_title'];
           $v->description = $user_portfolio['acc_portfolio_description'];
           $v->keywords = '';
           $v->og_img = '';
           $v->header = $this->module('Header');
           $v->profilemenu = $this->module('ProfileMenu');
           $v->footer = $this->module('Footer');
           
           $v->text_select = $user_portfolio['select'];
           $v->text_save = $user_portfolio['save'];
           $v->text_category_of_portfolio = $user_portfolio['acc_category_of_portfolio'];
           $v->text_select_photo = $user_portfolio['acc_select_photo'];
           $v->text_auxiliary_text = $user_portfolio['acc_auxiliary_text'];
           $v->text_name = $user_portfolio['name'];
           $v->text_name_placeholder = $user_portfolio['acc_name_placeholder'];
           $v->text_lastname = $user_portfolio['lastname'];
           $v->text_lastname_placeholder = $user_portfolio['acc_lastname_placeholder'];
           $v->text_birthday = $user_portfolio['birthday'];
           $v->text_national = $user_portfolio['nation'];
           $v->text_birthday_placeholder = $user_portfolio['acc_birthday_placeholder'];
           $v->text_mobile = $user_portfolio['mobile'];
           $v->text_mobile_placeholder = $user_portfolio['acc_mobile_placeholder'];
           $v->text_email_placeholder = $user_portfolio['acc_email_placeholder'];
           $v->text_email = $user_portfolio['email'];
           $v->text_fisical_code = $user_portfolio['page_portfolio_fiscalCode'];
           $v->text_document = $user_portfolio['acc_document'];
           $v->text_passport = $user_portfolio['acc_passport'];
           $v->text_carta_identita = $user_portfolio['acc_carta_identita'];
           $v->text_resident_adres = $user_portfolio['acc_resident_adres'];
           $v->text_country = $user_portfolio['country'];
           $v->text_region = $user_portfolio['region'];
           $v->text_town = $user_portfolio['town'];
           $v->text_adres = $user_portfolio['acc_resident_adres'];
           $v->text_life_other_adres = $user_portfolio['acc_life_other_adres'];
           $v->text_life_adres = $user_portfolio['acc_life_adres'];
           $v->text_patent = $user_portfolio['page_portfolio_patent'];
           $v->text_transport = $user_portfolio['page_portfolio_transport'];
           $v->text_non_patent = $user_portfolio['page_portfolio_non_patent'];
           $v->text_category_m = $user_portfolio['acc_category_m'];
           $v->text_category_a1 = $user_portfolio['acc_category_a1'];
           $v->text_category_a = $user_portfolio['acc_category_a'];
           $v->text_category_b1 = $user_portfolio['acc_category_b1'];
           $v->text_category_b = $user_portfolio['acc_category_b'];
           $v->text_category_be = $user_portfolio['acc_category_be'];
           $v->text_category_tb = $user_portfolio['acc_category_tb'];
           $v->text_category_tm = $user_portfolio['acc_category_tm'];
           $v->text_category_c1 = $user_portfolio['acc_category_c1'];
           $v->text_category_c1e = $user_portfolio['acc_category_c1e'];
           $v->text_category_c = $user_portfolio['acc_category_c'];
           $v->text_category_ce = $user_portfolio['acc_category_ce'];
           $v->text_category_d1 = $user_portfolio['acc_category_d1'];
           $v->text_category_d1e = $user_portfolio['acc_category_d1e'];
           $v->text_category_d = $user_portfolio['acc_category_d'];
           $v->text_category_de = $user_portfolio['acc_category_de'];
           $v->text_marital_status = $user_portfolio['page_portfolio_marital_status'];
           $v->text_is_married = $user_portfolio['acc_is_married'];
           $v->text_no_family = $user_portfolio['acc_no_family'];
           $v->text_cv_of_user = $user_portfolio['cv_of_user'];
           $v->text_about = $user_portfolio['page_portfolio_about'];
           $v->text_education = $user_portfolio['page_portfolio_portfolio_educations'];
           $v->text_date_begin = $user_portfolio['acc_date_begin'];
           $v->text_date_begin_placeholder = $user_portfolio['acc_date_begin_placeholder'];
           $v->text_date_end = $user_portfolio['acc_date_end'];
           $v->text_date_end_placeholder = $user_portfolio['acc_date_end_placeholder'];
           $v->text_education_received = $user_portfolio['acc_education_received'];
           $v->text_education_received_placeholder = $user_portfolio['acc_education_received_placeholder'];
           $v->text_specialty = $user_portfolio['acc_specialty'];
           $v->text_specialty_placeholder = $user_portfolio['acc_specialty_placeholder'];
           $v->text_institut = $user_portfolio['acc_institut'];
           $v->text_knowledge_of_languages = $user_portfolio['acc_knowledge_of_languages'];
           $v->text_language = $user_portfolio['acc_language'];
           $v->text_letter = $user_portfolio['acc_letter'];
           $v->text_read = $user_portfolio['acc_read'];
           $v->text_dialog = $user_portfolio['acc_dialog'];
           $v->text_title_lang = $user_portfolio['acc_title_lang'];
           $v->text_title_lang_programm = $user_portfolio['acc_title_lang_programm'];
           $v->text_perfect = $user_portfolio['acc_perfect'];
           $v->text_good = $user_portfolio['acc_good'];
           $v->text_bad = $user_portfolio['acc_bad'];
           $v->text_knowledge_of_computer_programs = $user_portfolio['acc_knowledge_of_computer_programs'];
           $v->text_programm = $user_portfolio['acc_programm'];
           $v->text_link_exemple = $user_portfolio['acc_link_exemple'];
           $v->text_level = $user_portfolio['acc_level'];
           $v->text_link_exemple_placeholder = $user_portfolio['acc_link_exemple_placeholder'];
           $v->text_work_post = $user_portfolio['acc_work_post'];
           $v->text_acc_real_work_post = $user_portfolio['acc_real_work_post'];
           $v->text_work_post_date_begin = $user_portfolio['acc_work_post_date_begin'];
           $v->text_work_post_date_end = $user_portfolio['acc_work_post_date_end'];
           $v->text_work_post_fact = $user_portfolio['acc_work_post_fact'];
           $v->text_work_level = $user_portfolio['acc_work_level'];
           $v->text_save_as_new = $user_portfolio['acc_save_as_new'];
           $v->text_print = $user_portfolio['acc_print'];
           $v->text_null = $user_portfolio['acc_null'];
           $v->text_portfolio_off = $user_portfolio['acc_portfolio_off'];
           $v->text_interests = $user_portfolio['page_portfolio_nameInterests'];
           $v->text_assets = $user_portfolio['page_portfolio_nameAssests'];
           $v->text_hobbi = $user_portfolio['page_portfolio_nameHobbi'];
           $v->text_acc_docs = $user_portfolio['acc_docs'];
           $v->text_acc_add_doc = $user_portfolio['acc_add_doc'];
            $v->text_auto_portfolio = $user_portfolio['acc_auto_portfolio'];
           $v->text_acc_keywords_autoportfolio = $user_portfolio['acc_keywords_autoportfolio'];
           $v->text_acc_location_autoportfolio = $user_portfolio['acc_location_autoportfolio'];
           $v->text_btn_autoportfolio = $user_portfolio['btn_autoportfolio'];
           $v->text_disable = $user_portfolio['disable'];
           
           $v->userDate = $u_data;           
           $v->portfolioData = PortfolioModel::Instance()->GetUserPortfolio($u_data['u_id']);
           $v->CategoryListVacanceWithoutParetnId = VacanciesModel::Instance()->GetCategoryListWithoutParetnId();
           $v->category_portfolio = PortfolioModel::Instance()->SelectCategoryPotrfolio($v->portfolioData['id']);
           $v->portfolioData_computer = PortfolioModel::Instance()->GetUserPortfolio_computer($u_data['u_id']);
           $v->portfolioData_educations = PortfolioModel::Instance()->GetUserPortfolio_educations($u_data['u_id']);
           $v->portfolioData_languages = PortfolioModel::Instance()->GetUserPortfolio_languages($u_data['u_id']);
           $v->portfolioData_work_post = PortfolioModel::Instance()->GetUserPortfolio_work_post($u_data['u_id']);
           $v->portfolioDocuments = PortfolioModel::Instance()->GetDocumentsForPortfolio($u_data['u_id']);
           $v->assests = PortfolioModel::Instance()->getAssests();
           $v->hobbi = PortfolioModel::Instance()->getHobbi();
           $v->interests = PortfolioModel::Instance()->getInterests();
           
           if(empty($v->portfolioData['adresDomicilio'])) $v->checked = '';
           else $v->checked = 'checked';
           
           $auto_portfolio = PortfolioModel::Instance()->selectAutoPotrfolio($u_data['u_id']);
           if(!empty($auto_portfolio)) {
                $v->automat_searchkeywords = $auto_portfolio['keywords'];
                $v->automat_location = $auto_portfolio['location'];
           } else {
                $v->automat_searchkeywords = '';
                $v->automat_location = '';
           }
           
           $v->user_avatar = (empty($v->portfolioData['portfolio_img']))?$u_data['user_img']:$v->portfolioData['portfolio_img'];
           
           $v->patent = unserialize($v->portfolioData['patent']);
            
           $v->userAssests = unserialize($v->portfolioData['assests']);
           $v->userInterests = unserialize($v->portfolioData['interests']);
           $v->userHobbi = unserialize($v->portfolioData['hobbi']);
           
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_vacancies () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $v = new View('account/vacancies');
            $lang_vacancies = $this->lang('vacancies');
            
            $v->title = $lang_vacancies['title'];
            $v->description = '';
            $v->keywords = '';
            $v->og_img = '';
            
            $v->text_not_vacance = $lang_vacancies['non_vacancies'];
            $v->text_add_new = $lang_vacancies['add_new'];
           
            $v->header = $this->module('Header');
            $v->profilemenu = $this->module('ProfileMenu');
            $v->footer = $this->module('Footer');
            
            $page = (int)Router::getUriParam('page');
            $count = VacanciesModel::Instance()->getUserVacanciesCount($u_data['u_id'], 20);
            if($page < 1 or $page > $count) Url::local('404');
            
            $sort = Router::getUriParam('sort');
            if($sort !== NULL) {
                if ($sort == 'title') $order = true;
                
                if ($sort == 'date') {
                    $sort = 'date_add';
                    $order = false;
                }
                
                if ($sort == 'views') $order = false;
                
                if ($sort == 'filial') {
                    $sort = 'name_company';
                    $order = true;
                }
                
                $v->vacanciesList = VacanciesModel::Instance()->getListVacanciesForUser($page, $u_data['u_id'], 20, $sort, $order);
            } else {
                $v->vacanciesList = VacanciesModel::Instance()->getListVacanciesForUser($page, $u_data['u_id'], 20);
            }
            
            $v->pagination = HTMLHelper::pagination($page, $count, Url::local('profile/vacancies'));
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_newvacance () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $v = new View('account/new_vacance');
            $lang_vacancies = $this->lang('vacancies');
            
            $v->title = $lang_vacancies['title'];
            $v->description = '';
            $v->keywords = '';
            $v->og_img = '';
           
            $v->header = $this->module('Header');
            $v->profilemenu = $this->module('ProfileMenu');
            $v->footer = $this->module('Footer');
            
            $v->text_add_new = $lang_vacancies['add_new'];
            $v->text_category = $lang_vacancies['category'];
            $v->text_select_branch = $lang_vacancies['select_branch'];
            $v->text_tags = $lang_vacancies['tags'];
            $v->text_name = $lang_vacancies['name'];
            $v->text_short_description = $lang_vacancies['short_description'];
            $v->text_full_description = $lang_vacancies['full_description'];
            $v->text_select_category = $lang_vacancies['select_category'];
            $v->text_save = $lang_vacancies['save'];
            $v->text_location = $lang_vacancies['location'];
            $v->text_country = $lang_vacancies['country'];
            $v->text_region = $lang_vacancies['region'];
            $v->text_provincies = $lang_vacancies['provincies'];
            $v->text_select_country = $lang_vacancies['select_country'];
            $v->text_select_region = $lang_vacancies['select_region'];
            $v->text_select_provincies = $lang_vacancies['select_provincies'];
            $v->text_requirements = $lang_vacancies['requirements'];
            $v->text_select = $lang_vacancies['select'];
            $v->text_education = $lang_vacancies['education'];
            $v->text_languages = $lang_vacancies['languages'];
            $v->text_high = $lang_vacancies['high'];
            $v->text_incomplete_higher = $lang_vacancies['incomplete_higher'];
            $v->text_licenza_media = $lang_vacancies['licenza_media'];
            $v->text_specialized_secondary = $lang_vacancies['specialized_secondary'];
            $v->text_media = $lang_vacancies['media'];
            $v->text_without_education = $lang_vacancies['without_education'];
            $v->text_necessarily = $lang_vacancies['necessarily'];
            $v->text_desirable = $lang_vacancies['desirable'];
            $v->text_comma_separated = $lang_vacancies['comma_separated'];
            $v->text_special_knowledge = $lang_vacancies['special_knowledge'];
            $v->text_experience = $lang_vacancies['experience'];
            $v->text_without_experience = $lang_vacancies['without_experience'];
            $v->text_half_year = $lang_vacancies['half_year'];
            $v->text_year = $lang_vacancies['year'];
            $v->text_Up_to_5_years = $lang_vacancies['Up_to_5_years'];
            $v->text_Morethan_5_years = $lang_vacancies['Morethan_5_years'];
            $v->text_Driver_license = $lang_vacancies['Driver_license'];
            $v->text_non_patent = $lang_vacancies['non_patent'];
            $v->text_category_m = $lang_vacancies['category_m'];
            $v->text_category_a1 = $lang_vacancies['category_a1'];
            $v->text_category_a = $lang_vacancies['category_a'];
            $v->text_category_b1 = $lang_vacancies['category_b1'];
            $v->text_category_b = $lang_vacancies['category_b'];
            $v->text_category_be = $lang_vacancies['category_be'];
            $v->text_category_tb = $lang_vacancies['category_tb'];
            $v->text_category_tm = $lang_vacancies['category_tm'];
            $v->text_category_c1 = $lang_vacancies['category_c1'];
            $v->text_category_c1e = $lang_vacancies['category_c1e'];
            $v->text_category_c = $lang_vacancies['category_c'];
            $v->text_category_ce = $lang_vacancies['category_ce'];
            $v->text_category_d1 = $lang_vacancies['category_d1'];
            $v->text_category_d1e = $lang_vacancies['category_d1e'];
            $v->text_category_d = $lang_vacancies['category_d'];
            $v->text_category_de = $lang_vacancies['category_de'];
            $v->text_own_transport = $lang_vacancies['own_transport'];
            $v->text_yes = $lang_vacancies['yes'];
            $v->text_no = $lang_vacancies['no'];
            $v->text_age = $lang_vacancies['age'];
            $v->text_18_25 = $lang_vacancies['18_25'];
            $v->text_18 = $lang_vacancies['18'];
            $v->text_25_30 = $lang_vacancies['25_30'];
            $v->text_30_45 = $lang_vacancies['30_45'];
            $v->text_45 = $lang_vacancies['45'];
            
            $v->filialList = BranchModel::Instance()->getListBranchForUser($u_data['u_id']);
            $categoryList = VacanciesModel::Instance()->GetCategoryListWithoutParetnId();
            $v->categoryListForVacancies = $this->showCatvacanciesOption($this->getTree($categoryList), '');
            $v->branch_default = BranchModel::Instance()->branchSelect($u_data['u_id']);
            $v->countryList = LocalModel::Instance()->GetCountryList();
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_region () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            if($this->post('c_id')) {
                $r_list = LocalModel::Instance()->getRegionListOfCountry($this->post('c_id'));
                echo json_encode($r_list);
           } else {
                echo json_encode(array('id' => 0, 'name' => 'Регионов нет!'));
           }
        }
        
        public function action_provinces () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            if($this->post('r_id')) {
                $p_list = LocalModel::Instance()->getProvincesListOfCountry($this->post('r_id'));
                echo json_encode($p_list);
           } else {
                echo json_encode(array('id' => 0, 'name' => 'Регионов нет!'));
           }
        }
        
        public function action_savevacance () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $lang_vacancies = $this->lang('vacancies');
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            $requirements = array ();
            
            $filialCount = BranchModel::Instance()->countBranchOfUser($u_data['u_id']);
            if($filialCount['numCount'] != '0') {
                if($this->post('filial_avdert') == '0') $msg['errors']['filial_avdert'] = 'Select filial';
                else $id_filial = $this->post('filial_avdert');
            }
            
            if(!$this->post('title')) $msg['errors']['title'] = $lang_vacancies['empty_title'];
            else {
                $symbol = array(
                    '.' => "-",
                    ',' => "-",
                    '/' => "-",
                    ' ' => "-",
                    '_-_' => '-',
                    ' - ' => '-',
                    '|' => '-',
                    '\\' => '-',
                    '\'' => '-',
                    'à' => 'a',
                    'è' => 'e',
                    'ì' => 'i',
                    'ò' => 'o',
                    'ù' => 'u'
                );
                    
                if(isset($_POST['v_id'])) {
                    $old_title = VacanciesModel::Instance()->getTitleOfVacance($this->post('v_id'));
                    if($old_title['title'] != $this->post('title')) {
                        $seo = (HTMLHelper::isRuLetters($this->post('title')))?HTMLHelper::TranslistLetterRU_EN($this->post('title')):strtr($this->post('title'), $symbol);
                        $num_v_seo = VacanciesModel::Instance()->getCountSeoVacance($seo);
                        if($num_v_seo['numCount'] > 0) $msg['errors']['title'] = $lang_vacancies['title_exist'];
                    } else {
                        $seo = $old_title['seo'];
                    }
                } else {
                    $seo = (HTMLHelper::isRuLetters($this->post('title')))?HTMLHelper::TranslistLetterRU_EN($this->post('title')):strtr($this->post('title'), $symbol);
                    $num_v_seo = VacanciesModel::Instance()->getCountSeoVacance($seo);
                    if($num_v_seo['numCount'] > 0) $msg['errors']['title'] = $lang_vacancies['title_exist'];
                }
            }
            
            if($this->post('id_category') == '0') $msg['errors']['id_category'] = $lang_vacancies['empty_category'];
            if(!$this->post('tags_vacance')) $msg['errors']['tags_vacance'] = $lang_vacancies['empty_tags_vacance'];
            if(!$this->post('short_description')) $msg['errors']['short_description'] = $lang_vacancies['empty_short_desc'];
            if(!$this->post('full_description')) $msg['errors']['full_description'] = $lang_vacancies['empty_full_desc'];
            if(!$this->post('location')) $msg['errors']['location'] = $lang_vacancies['empty_location'];
            if($this->post('id_country') == '0') $msg['errors']['id_country'] = $lang_vacancies['select_country'];
            if($this->post('id_region') == '0') $msg['errors']['id_region'] = $lang_vacancies['select_region'];
            if($this->post('id_provincies') == '0') $msg['errors']['id_provincies'] = $lang_vacancies['select_provincies'];
            
            if(!$msg['errors']) {
                $newVacance = array(
                    'id_user' => $u_data['u_id'],
                    'id_category' => $this->post('id_category'),
                    'id_filial' => $id_filial,
                    'title' => $this->post('title'),
                    'tags' => $this->post('tags_vacance'),
                    'seo' => strtolower($seo),
                    'short_desc' => mb_strimwidth($this->post('short_description'), 0, 249, '...'),
                    'full_desc' => $this->post('full_description'),
                    'date_add' => time(),
                    'country' => $this->post('id_country'),
                    'region' => $this->post('id_region'),
                    'provinces' => $this->post('id_provincies'),
                    'location' => $this->post('location')
                );
                
                if(!$this->post('v_id')) {
                    $last_id = VacanciesModel::Instance()->AddNewVacance($newVacance);
                } else {
                    $newVacance['id'] = $this->post('v_id');
                    VacanciesModel::Instance()->UpdVacancies($newVacance);
                }
                
                if ($this->post('age') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => (!$this->post('v_id'))?$last_id:$this->post('v_id'),
                        'name_rm' => 'age',
                        'value_rm' => $this->post('age'),
                        'status_rm' => $this->post('age_rm')
                    );
                }
                
                if ($this->post('education') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => (!$this->post('v_id'))?$last_id:$this->post('v_id'),
                        'name_rm' => 'education',
                        'value_rm' => $this->post('education'),
                        'status_rm' => $this->post('education_rm')
                    );
                }
                
                if ($this->post('languages')) {
                    $requirements[] = array(
                        'id_vacancy' => (!$this->post('v_id'))?$last_id:$this->post('v_id'),
                        'name_rm' => 'languages',
                        'value_rm' => $this->post('languages'),
                        'status_rm' => $this->post('languages_rm')
                    );
                }
                
                if ($this->post('special_knowledge')) {
                    $requirements[] = array(
                        'id_vacancy' => (!$this->post('v_id'))?$last_id:$this->post('v_id'),
                        'name_rm' => 'special_knowledge',
                        'value_rm' => $this->post('special_knowledge'),
                        'status_rm' => $this->post('special_knowledge_rm')
                    );
                }
                
                if ($this->post('experience') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => (!$this->post('v_id'))?$last_id:$this->post('v_id'),
                        'name_rm' => 'experience',
                        'value_rm' => $this->post('experience'),
                        'status_rm' => $this->post('experience_rm')
                    );
                }
                
                if ($this->post('driver_license') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => (!$this->post('v_id'))?$last_id:$this->post('v_id'),
                        'name_rm' => 'driver_license',
                        'value_rm' => $this->post('driver_license'),
                        'status_rm' => $this->post('driver_license_rm')
                    );
                }
                
                if ($this->post('own_transport') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => (!$this->post('v_id'))?$last_id:$this->post('v_id'),
                        'name_rm' => 'own_transport',
                        'value_rm' => $this->post('own_transport'),
                        'status_rm' => $this->post('own_transport_rm')
                    );
                }
                //print_r($requirements);
                if(!empty($requirements)) {
                    VacanciesModel::Instance()->AddRequirements($requirements);
                }
                $msg['success'] = $lang_vacancies['add_vacance_success'];
                $this->auto_portfolio($last_id);
            }
            echo json_encode($msg);
        }
        
        private function auto_portfolio ($new_vacance_id = '') {
            $ap_data = PortfolioModel::Instance()->selectAllAutoPotrfolio();
            if (empty($ap_data)) return;
            
            foreach ($ap_data as $user) {
                $portfolioId = PortfolioModel::Instance()->getPortfolioId($user['id_user']);
                $userEmail = ProfileModel::Instance()->getUserEmail($user['id_user']);
                
                $rez = ProfileModel::Instance()->selectVacanciesForAutoCandidatura($user['keywords'], $user['location']);
                
                if(!empty($rez)) {
                    $email = 'Dear user, we inform you about the successful automatic submission of your candidacy for the following vacancies <br />';
                    
                    foreach($rez as $v) {
                        $ifCandidatExist = PortfolioModel::Instance()->ifCandidatExist($v['id'], $portfolioId['id']);
                        
                        if(!$ifCandidatExist['id']) {
                            $add = array(
                                'id_v' => $v['id'],
                                'id_p' => $portfolioId['id'], 
                                'id_user' => $v['id_user'],
                                'date_add' => time()
                            );
                            
                            PortfolioModel::Instance()->AddCandidatura($add);
                            
                            $email .= '<h3><a href="" target="_blanck">'.$v['title'].'</a></h3><br />';
                            $email .= '<p>'.$v['short_desc'].'</p><hr />';
                        }
                    }
                    $sendMessage = EmailTPLHelper::SendEmail($userEmail['email'], 'Successful submission of the candidature', $email);
                }
            }
        }
        
        public function action_vacancetrash () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $id_v = Router::getUriParam(2);
            
            VacanciesModel::Instance()->deleteVacancies($id_v);
            $this->redirect(Url::local('profile/vacancies'));
        }
        
        public function action_vacanceedit () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $v = new View('account/editvacance');
            $lang_vacancies = $this->lang('vacancies');
            
            $id_v = Router::getUriParam(2);
            
            $v->title = $lang_vacancies['title'];
            $v->description = '';
            $v->keywords = '';
            $v->og_img = '';
           
            $v->header = $this->module('Header');
            $v->profilemenu = $this->module('ProfileMenu');
            $v->footer = $this->module('Footer');
            
            $v->text_add_new = $lang_vacancies['add_new'];
            $v->text_category = $lang_vacancies['category'];
            $v->text_select_branch = $lang_vacancies['select_branch'];
            $v->text_name = $lang_vacancies['name'];
            $v->text_short_description = $lang_vacancies['short_description'];
            $v->text_full_description = $lang_vacancies['full_description'];
            $v->text_select_category = $lang_vacancies['select_category'];
            $v->text_tags = $lang_vacancies['tags'];
            $v->text_save = $lang_vacancies['save'];
            $v->text_location = $lang_vacancies['location'];
            $v->text_country = $lang_vacancies['country'];
            $v->text_region = $lang_vacancies['region'];
            $v->text_provincies = $lang_vacancies['provincies'];
            $v->text_select_country = $lang_vacancies['select_country'];
            $v->text_select_region = $lang_vacancies['select_region'];
            $v->text_select_provincies = $lang_vacancies['select_provincies'];
            $v->text_requirements = $lang_vacancies['requirements'];
            $v->text_select = $lang_vacancies['select'];
            $v->text_education = $lang_vacancies['education'];
            $v->text_languages = $lang_vacancies['languages'];
            $v->text_high = $lang_vacancies['high'];
            $v->text_incomplete_higher = $lang_vacancies['incomplete_higher'];
            $v->text_licenza_media = $lang_vacancies['licenza_media'];
            $v->text_specialized_secondary = $lang_vacancies['specialized_secondary'];
            $v->text_media = $lang_vacancies['media'];
            $v->text_without_education = $lang_vacancies['without_education'];
            $v->text_necessarily = $lang_vacancies['necessarily'];
            $v->text_desirable = $lang_vacancies['desirable'];
            $v->text_comma_separated = $lang_vacancies['comma_separated'];
            $v->text_special_knowledge = $lang_vacancies['special_knowledge'];
            $v->text_experience = $lang_vacancies['experience'];
            $v->text_without_experience = $lang_vacancies['without_experience'];
            $v->text_half_year = $lang_vacancies['half_year'];
            $v->text_year = $lang_vacancies['year'];
            $v->text_Up_to_5_years = $lang_vacancies['Up_to_5_years'];
            $v->text_Morethan_5_years = $lang_vacancies['Morethan_5_years'];
            $v->text_Driver_license = $lang_vacancies['Driver_license'];
            $v->text_non_patent = $lang_vacancies['non_patent'];
            $v->text_category_m = $lang_vacancies['category_m'];
            $v->text_category_a1 = $lang_vacancies['category_a1'];
            $v->text_category_a = $lang_vacancies['category_a'];
            $v->text_category_b1 = $lang_vacancies['category_b1'];
            $v->text_category_b = $lang_vacancies['category_b'];
            $v->text_category_be = $lang_vacancies['category_be'];
            $v->text_category_tb = $lang_vacancies['category_tb'];
            $v->text_category_tm = $lang_vacancies['category_tm'];
            $v->text_category_c1 = $lang_vacancies['category_c1'];
            $v->text_category_c1e = $lang_vacancies['category_c1e'];
            $v->text_category_c = $lang_vacancies['category_c'];
            $v->text_category_ce = $lang_vacancies['category_ce'];
            $v->text_category_d1 = $lang_vacancies['category_d1'];
            $v->text_category_d1e = $lang_vacancies['category_d1e'];
            $v->text_category_d = $lang_vacancies['category_d'];
            $v->text_category_de = $lang_vacancies['category_de'];
            $v->text_own_transport = $lang_vacancies['own_transport'];
            $v->text_yes = $lang_vacancies['yes'];
            $v->text_no = $lang_vacancies['no'];
            $v->text_age = $lang_vacancies['age'];
            $v->text_18_25 = $lang_vacancies['18_25'];
            $v->text_18 = $lang_vacancies['18'];
            $v->text_25_30 = $lang_vacancies['25_30'];
            $v->text_30_45 = $lang_vacancies['30_45'];
            $v->text_45 = $lang_vacancies['45'];
            
            $v->categoryList = VacanciesModel::Instance()->GetCategoryListWithoutParetnId();
            $v->filialList = BranchModel::Instance()->getListBranchForUser($u_data['u_id']);
            $vacanceData = VacanciesModel::Instance()->getDataVacanciesForEdit($id_v, $u_data['u_id']);
            $v->countryList = LocalModel::Instance()->GetCountryList();
            /*echo '<pre>';
            print_r($v->filialList);
            echo '</pre>';*/
            if(empty($vacanceData)) $this->redirect('/profile/vacancies');
            $v->vacanceData = $vacanceData;
            $v->requirements = VacanciesModel::Instance()->getRequirementsOfVacancy($id_v);
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_api () {
            if(!AuthClass::instance()->isAuth()) {
	            $this->redirect(Url::local(''));
	        }
           
            $v = new View('account/profileapi');
            $profile = $this->lang('api');
            $profile_id = AuthClass::instance()->getUser();
            
            $v->header = $this->module('Header');
            $v->profilemenu = $this->module('ProfileMenu');
            $v->footer = $this->module('Footer');
            
            $v->title = 'Api settings';
            $v->description = '';
            $v->og_img = '';
            
            $v->userDate = ProfileModel::Instance()->getUserDate($profile_id['u_id']);
            $v->isAccessIsset = ProfileModel::Instance()->isAccessIsset($profile_id['u_id']);
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_candidats () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $v = new View('account/candidats');
            $lang_candidat = $this->lang('candidats');
            $user_portfolio = $this->lang('portfolio');
            
            $v->title = $lang_candidat['title'];
            $v->description = '';
            $v->og_img = '';
           
            $v->header = $this->module('Header');
            $v->profilemenu = $this->module('ProfileMenu');
            $v->footer = $this->module('Footer');
            
            $candidats_v = ProfileModel::Instance()->getTottalCandidats($u_data['u_id']);
            $candidats_nv = ProfileModel::Instance()->getTottalCandidatsWithoutPortfolio($u_data['u_id']);
            
            $v->tottal_candidats = array_merge($candidats_v, $candidats_nv);
            
            if($this->post('portfolio')) {
                $portfolioData = PortfolioModel::Instance()->GetUserPortfolio($this->post('portfolio'));
                $id_user_p = $this->post('portfolio');
                if($portfolioData) {
                    $portfolioData['patent'] = unserialize($portfolioData['patent']);
                    
                    $patent = '';
                    foreach ($portfolioData['patent'] as $pt) {
                        if($pt == '1') $patent .= $user_portfolio['page_portfolio_transport'].', ';
                        else $patent .= $pt.', ';
                    }
                    $portfolioData['patent'] = substr($patent, 0, -2);
                    if ($portfolioData['patent'] == 'non_patent') $portfolioData['patent'] = $user_portfolio['page_portfolio_non_patent'];
                } else {
                    $portfolioData['name'] = $candidats_nv[$id_user_p]['name'];
                    $portfolioData['lastname'] = $candidats_nv[$id_user_p]['lastname'];
                    $portfolioData['login'] = $candidats_nv[$id_user_p]['login'];
                    $portfolioData['email'] = $candidats_nv[$id_user_p]['email'];
                    $portfolioData['portfolio_img'] = $candidats_nv[$id_user_p]['img_c'];
                    $portfolioData['birthDate'] = '';
                    $portfolioData['nacional'] = '';
                    $portfolioData['mobile'] = '';
                    $portfolioData['adresResident'] = '';
                    $portfolioData['patent'] = '';
                    $portfolioData['candidat'] = $candidats_nv[$id_user_p]['candidat'];
                }
                echo json_encode(array('portfolio' => $portfolioData));
                //echo json_encode(array('error' => $lang_candidat['error_portfolio_found']));
                return false;
            }

            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_trash_candidat () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $id_c = Router::getUriParam(2);
            
            ProfileModel::Instance()->deleteCandidat($id_c);
            $this->redirect(Url::local('profile/candidats'));
        }
        
        private function getTree($dataset) {
        	$tree = array();

        	foreach ($dataset as $id => &$node) {    
        		//���� ��� ��������
        		if (!$node['parent_id']){
        			$tree[$id] = &$node;
        		}else{ 
        			//���� ���� ������� �� ���������� ������
                    $dataset[$node['parent_id']]['childs'][$id] = &$node;
        		}
        	}
        	return $tree;
        }
        
        //������ ��� ������ ���� � ���� ������
        private function tplvacanciesOption($category, $str){
        	if($category['parent_id'] == 0){
               $menu = '<option value="'.$category['id'].'">'.$category['title'].'</option>';
            }else{   
               $menu = '<option value="'.$category['id'].'">'.$str.' '.$category['title'].'</option>';
            }
            
        	if(isset($category['childs'])){
        		$i = 1;
        		for($j = 0; $j < $i; $j++){
        			$str .= ' - ';
        		}		  
        		$i++;
        		
        		$menu .= $this->showCatvacanciesOption($category['childs'], $str);
        	}
            return $menu;
        }
        
        private function generateSalt () {
	       $s1 = md5(rand(1000000, 9999999));
           $s2 = sha1(time().rand());
           
           return substr(md5($s1.$s2), 0, 10);
	   }
       
        private function passHash($pass, $salt) {
            $h1 = hash('sha256', $salt.$pass.$salt);
            $h2 = hash('sha256', $pass.$salt.$pass);
            $res = hash('sha256', $h1.$h2);
            
            return substr_replace($res, $salt, 12, 10);
       }
        
        public function action_api_access () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $isAccessIsset = ProfileModel::Instance()->isAccessIsset($u_data['u_id']);
            
            $pass = $this->post('pass');
            $s1 = md5(rand(1000000, 9999999));
            $s2 = sha1(time().rand());
            
            if(isset($isAccessIsset['id'])) {
                /*if($isAccessIsset['pass'] !== $this->passHash($pass, $this->generateSalt())) {
                    echo json_encode($this->passHash($pass, $this->generateSalt()));
                    return;
                }*/
                $secret_key = $isAccessIsset['secret_key'];
                //ProfileModel::Instance()->deleteApi_access($isAccessIsset['id']);
            } else {
                $secret_key = substr(md5($s1.$s2), 0, 16);
                $apiDateAccess = array(
                    'secret_key' => $secret_key, 
                    'user_id' => $u_data['u_id'],
                    'email' => $u_data['email'],
                    'pass' => $this->passHash($pass, $this->generateSalt())
                );
                
                ProfileModel::Instance()->createApiAccess($apiDateAccess);
            }
            
        	$request = '{
        					"name":"generateToken",
        					"param":{
        						"email": "'.$u_data['email'].'",
                                "secret_key": "'.$secret_key.'",
        						"pass": "'.$pass.'"
        					}
        				}';
                        
            $curl = curl_init();
        	curl_setopt($curl, CURLOPT_URL, 'https://api.findsol.it/');
        	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        	curl_setopt($curl, CURLOPT_POST, true);
        	curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FRESH_CONNECT, TRUE);
            
        	$result = curl_exec($curl);
        	
            if ($errno = curl_errno($curl)) {
            	$message = curl_strerror($errno);
            	$err = "cURL error ({$errno}): {$message}";
            } else {                                                
        		$response = json_decode($result, true);
        		$token = $response['resonse']['result']['token'];
            }
            
            curl_close($curl);
            
            if ($token !== NULL) {
                $apiDateAccess = array(
                    'secret_key' => $secret_key, 
                    'user_id' => $u_data['u_id'],
                    'token' => $token
                );
                ProfileModel::Instance()->updateApiToken($apiDateAccess);
                echo json_encode(array('secret_key' => $secret_key, 'token' => $token));
            } else {
                echo json_encode($err);
            }
        }
        
        //���������� ��������� ��� ������
        private function showCatvacanciesOption($data, $str){
        	$string = '';
        	$str = $str;
        	foreach($data as $item){
        		$string .= $this->tplvacanciesOption($item, $str);
        	}
        	return $string;
        }
    }
?>