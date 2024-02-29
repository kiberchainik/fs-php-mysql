<?php
	class AjaxController extends Controller {
	   public function action_index() {
	       header('Location: /main');
	   }
       
       public function action_livesearch () {
            $select = '';
            $from = '';
            $where = '';
            $param = '';
            
            if($this->post('search_local')) {
                if ($this->post('search_local') == 'users') {
                    $select = 'u.id, u.onlineSatus, ud.user_img, ud.name, ud.lastname, ud.about';
                    $from = 'users as u, user_date as ud ';
                    $where = 'MATCH(u.login, u.email, ud.name, ud.lastname, ud.mobile, ud.about, ud.company_name, ud.patent) AGAINST (:query IN BOOLEAN MODE) and u.validStatus = 1 and u.id = ud.user_id';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $resutl = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                    
                    foreach ($resutl as $k => $v){
                        echo '<li><a class="flex align-center" href="/profile/full/'.$v['id'].'"><div class="product-img"><img src="/Media/'.$v['user_img'].'" /></div><h3 class="product-title">'.$v["lastname"].' '.$v["name"].'</h3></a></li>';
                    }
                }
                
                if ($this->post('search_local') == 'portfolio') {
                    $select = 'p.id, p.portfolio_img, p.name, p.lastname, p.about, u.onlineSatus';
                    $from = 'portfolio as p, users as u ';
                    $where = 'MATCH(p.name, p.lastname, p.about) AGAINST (:query IN BOOLEAN MODE) and search_status = 0 and u.validStatus = 1 and u.id = p.id_user';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $resutl = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                    
                    foreach ($resutl as $k => $v){
                        echo '<li><a class="flex align-center" href="/portfolio/preview/'.$v['id'].'"><div class="product-img"><img src="/Media/'.$v['portfolio_img'].'" /></div><h3 class="product-title">'.$v["lastname"].' '.$v["name"].'</h3></a></li>';
                    }
                }
                
                if ($this->post('search_local') == 'adverts') {
                    $select = 'a.id, a.seo, a.title, a.description';
                    $from = 'adverts as a ';
                    $where = 'MATCH(a.title, a.description, a.keywords) AGAINST (:query IN BOOLEAN MODE) and validate = 1';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $resutl = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                    
                    foreach ($resutl as $k => $v){
                        echo '<li><a class="flex align-center" href="/advert/view/'.$v['seo'].'"><div class="product-img"><img src="/Media/'.$v['src'].'" /></div><h3 class="product-title">'.$v["title"].'</h3></a></li>';
                    }
                }
                
                if ($this->post('search_local') == 'vacancies') {
                    $select = 'v.id, v.title, v.short_desc';
                    $from = 'vacancies as v ';
                    $where = 'MATCH(v.title, v.short_desc, v.full_desc) AGAINST (:query IN BOOLEAN MODE) and valid_status = 1';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $resutl = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                    
                    foreach ($resutl as $k => $v){
                        echo '<li><a class="flex align-center" href="/vacancies/full/'.$v['id'].'"><div class="product-img"></div><h3 class="product-title">'.$v["title"].'</h3></a></li>';
                    }
                }
            } else {
                $select = 'a.id, a.seo, a.title, a.description';
                $from = 'adverts as a ';
                $where = 'MATCH(a.title, a.description, a.keywords) AGAINST (:query IN BOOLEAN MODE) and validate = 1';
                
                $param = array('query' => $this->post('search_query').'*');
                
                $resutl = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                foreach ($resutl as $k => $v){
                    echo '<li><a class="flex align-center" href="/advert/view/'.$v['seo'].'"><div class="product-img"></div><h3 class="product-title">'.$v["title"].'</a></li>';
                }
            }
            
            if (empty($resutl)) echo '<li>Not search result</li>';
       }
       
       public function action_GetImgsList () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }

            if ($this->post('id')) {
                header('Content-type: application/json');
                $imgs_list = AdvertsModel::Instance()->getListImagesAdvert($this->post('id'));

                echo json_encode($imgs_list['list']);
            }
        }
        
        public function action_sendmsg () {
            $lang_message = $this->lang('portfolio');
            
            $msg = array(
                'errors' => array(),
                'success' => ''
            );
            
            if ($this->post("name")){
                if(!HTMLHelper::isOnlyLetters($this->post('name'))){
                    $msg['errors']['name'] = $lang_message['error_name_letters'];
                }
            } else $msg['errors']['name'] = $lang_message['error_empty_name'];
                
            if($this->post('email_from')) {
                if(!HTMLHelper::validEmail($this->post('email_from'))){
                    $msg['errors']['email_from'] = $lang_message['error_email'];
                }
            } else $msg['errors']['email'] = $lang_message['error_empty_email'];
            
            if($this->post('email')) {
                if(!HTMLHelper::validEmail($this->post('email'))){
                    $msg['errors']['email'] = $lang_message['error_email'];
                }
            } else $msg['errors']['email'] = $lang_message['error_empty_email'];
            
            if(!$this->post('subject')){
                $msg['errors']['subject'] = $lang_message['error_empty_subject'];
            }
            
            if(!$this->post('message')){
                $msg['errors']['message'] = $lang_message['error_empty_message'];
            }
            
            if(!empty($msg['errors'])) {
                echo json_encode($msg);
            } else {
                $add = array(
                    'id_user' => $this->post('user_id'),
                    'user_id_from' => $this->post('user_id_from'),
                    'name_from' => $this->post('name'),
                    'email_from' => $this->post('email_from'),
                    'subject' => $this->post('subject'),
                    'message' => $this->post('message'),
                    'date_send' => time()
                );
                                    
                PortfolioModel::Instance()->AddMessageForUserFromGuest($add);
                
                $sendMessage = EmailTPLHelper::SendEmail($this->post('email'), $this->post('subject'), $this->post('message'));
                $msg['success'] = $lang_message['send_message_success'];
                echo json_encode($msg);
            }
        }
        
        public function action_reply () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            $u_data = AuthClass::instance()->getUser();
            $lang_message = $this->lang('messages');
            
            $msg = array(
                'errors' => array(),
                'success' => ''
            );
            
            if(!$this->post('reply_message')){
                $msg['errors']['reply_message'] = $lang_message['error_empty_text_message'];
            }
            
            if(!$this->post('reply_subject')){
                $msg['errors']['reply_subject'] = $lang_message['error_subject'];
            }
            
            if(!empty($msg['errors'])) {
                echo json_encode($msg);
            } else {
                $add = array(
                    'id_user' => $this->post('reply_user'),
                    'user_id_from' => $u_data['u_id'],
                    'name_from' => $u_data['name'],
                    'email_from' => $u_data['email'],
                    'subject' => $this->post('reply_subject'),
                    'message' => $this->post('reply_message'),
                    'date_send' => time()
                );
                                    
                PortfolioModel::Instance()->AddMessageForUserFromGuest($add);
                
                $upd = array('id' => (int)$this->post('reply_m_id'), 'read_status' => '1');
                MessagesModel::Instance()->updStatusMessageFromUser($upd);
                
                $sendMessage = EmailTPLHelper::SendEmail($this->post('email'), $this->post('subject'), $this->post('message'));
                $msg['success'] = 'ok';
                echo json_encode($msg);
            }
        }
        
        public function action_trash () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            $u_data = AuthClass::instance()->getUser();
            
            $add = array(
                'id' => Router::getUriParam(2),
                'user_id_from' => $u_data['u_id']
            );
                                    
            MessagesModel::Instance()->deleteMessageFromUser($add);
            $this->redirect(Url::local('profile/messages'));
        }
        
        public function action_save_category_potrfolio () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
           if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
           
           if($this->post('id_category') == '0') $msg['errors']['id_category'] = 'Select the category';
                
            if(empty($msg['errors'])) {
                $rez = PortfolioModel::Instance()->SelectCategoryPotrfolio($this->post('portfolio_id'));
                
                $addData = array(
                    'id_category' => $this->post('id_category'),
                    'id_portfolio' => $this->post('portfolio_id')
                );
                
                if($rez) {
                    PortfolioModel::Instance()->UPDCategoryPotrfolio($addData);
                } elseif(!$rez and $this->post('portfolio_id')) PortfolioModel::Instance()->SaveCategoryPotrfolio($addData);
                else $msg['errors']['portfolio_id'] = 'The first compile portfolio';
            } $msg['success'] = 'Saved';
            echo json_encode($msg);
       }
       
       public function action_saveportfolio () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $portfolioData = PortfolioModel::Instance()->GetUserPortfolio($u_data['u_id']);
            
            $msg = array(
                'errors' => array(),
                'success' => ''
            );
            
            if (empty($_FILES['portfolio_profile_logo']['name'])) {
                if (empty($portfolioData)) {
                    $portfolioImg = $u_data['user_img'];
                } else {
                    $portfolioImg = $portfolioData['portfolio_img'];
                }
            } else {
                $portfolioImg = UploadHelper::UploadOneImage($_FILES['portfolio_profile_logo'], 'users/'.$u_data['u_id']);
            }
            
            if(!$this->post('name')) $msg['errors']['name'] = $user_portfolio['error_empty_name'];
            if(!$this->post('lastname')) $msg['errors']['lastname'] = $user_portfolio['error_empty_lastname'];
            if(!$this->post('nacional')) $msg['errors']['nacional'] = $user_portfolio['error_empty_nacional'];
            if(!$this->post('fiscalCode')) $msg['errors']['fiscalCode'] = $user_portfolio['error_empty_fiscalCode'];
            if($this->post('document') == '0') $msg['errors']['document'] = $user_portfolio['error_document'];
            if(!$this->post('adResident')) $msg['errors']['adResident'] = $user_portfolio['error_empty_adresResident'];
            if(!$this->post('birthDate')) $msg['errors']['birthDate'] = $user_portfolio['error_empty_birthDate'];
            
            if(!$this->post('mobile')) {
                $msg['errors']['mobile'] = $user_portfolio['error_empty_mobile'];
            } else {
                if(!HTMLHelper::isNumbersTel($this->post('mobile'))) $msg['errors']['mobile'] = $user_portfolio['error_format_mobile'];
            }
            if(!$this->post('email')) {
                $msg['errors']['email'] = $user_portfolio['error_empty_email'];
            } else {
                if(!HTMLHelper::validEmail($this->post('email'))) $msg['errors']['email'] = $user_portfolio['error_format_email'];
            }
            if($this->post('resident_yes') == '1') {
                if(!$this->post('adDom')) $msg['errors']['adDom'] = $user_portfolio['error_empty_adresDomicilio'];
            }
            
            /*if(!$this->post('family')) {
                $msg['errors']['family'] = $user_portfolio['error_marital_status'];
            }*/
            
            if(!$this->post('about')) $msg['errors']['about'] = $user_portfolio['error_about'];
            if(!$this->post('patent')) $msg['errors']['patent'] = $user_portfolio['error_patent'];
            if(!$this->post('assests')) $msg['errors']['assests'] = $user_portfolio['error_assests'];
            if(!$this->post('hobbi')) $msg['errors']['hobbi'] = $user_portfolio['error_hobbi'];
            
            if(empty($msg['errors'])) {
                $arrportfolioData = array(
                    'id_user' => $u_data['u_id'],
                    'portfolio_img' => $portfolioImg,
                    'name' => $this->post('name'),
                    'lastname' => $this->post('lastname'),
                    'birthDate' => $this->post('birthDate'),
                    'nacional' => $this->post('nacional'),
                    'mobile' => $this->post('mobile'),
                    'email' => $this->post('email'),
                    'fiscalCode' => $this->post('fiscalCode'),
                    'document' => htmlspecialchars($this->post('document')),
                    'id_country' => $this->post('country'),
                    'id_region' => $this->post('region'),
                    'id_town' => $this->post('city'),
                    'adresResident' => $this->post('adResident'),
                    'adresDomicilio' => $this->post('adDom'),
                    'patent' => serialize($this->post('patent')),
                    'marital_status' => $this->post('family'),
                    'about' => htmlspecialchars($this->post('about')),
                    'assests' => serialize($this->post('assests')),
                    'hobbi' => serialize($this->post('hobbi')),
                    'interests' => ($this->post('interests'))?serialize($this->post('interests')):'',
                    'search_status' => ($this->post('portfolio_off'))?$this->post('portfolio_off'):'0'
                );
                
                if ($u_data['validStatus'] == '0') {
                    $UserDate = array(
                        'user_id' => $u_data['u_id'],
                        'name' => $this->post('name'),
                        'lastname' => $this->post('lastname'),
                        'mobile' => $this->post('mobile'),
                        'country' => $this->post('country'),
                        'region' => $this->post('region'),
                        'town' => $this->post('city'),
                        'address' => $this->post('adResident'),
                        'type_person' => '5',
                        'about' => $this->post('about'),
                        'user_img' => $portfolioImg
                    );
                    ProfileModel::Instance()->addUserDate($UserDate);
                    ProfileModel::Instance()->updUser(array('id' => $u_data['u_id'], 'validStatus' => '1'));
                }
            //echo'<pre>'.print_r($this->post('patent')).'</pre>';
                if(empty($portfolioData)) {
                    PortfolioModel::Instance()->AddNewPortfolio($arrportfolioData);
                } else {
                    $arrportfolioData['id'] = $portfolioData['id'];
                    PortfolioModel::Instance()->UPDPortfolio($arrportfolioData);
                }
            
                $msg['success'] = $user_portfolio['save_success'];;
            }
            echo json_encode($msg);
        }
        
        public function action_portfolio_document () {
           if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
           $u_data = AuthClass::instance()->getUser();
           if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
           
           if($_FILES['doc_file']['name']) {
                $portfolioDoc = UploadHelper::UploadOneImage($_FILES['doc_file'], 'portfolio/docs/'.$u_data['u_id']);
                $f_name = explode('/',$portfolioDoc);
                $date = array(
                    'id_user' => $u_data['u_id'],
                    'title' => $this->post('doc_desc'),
                    'file_name' => $f_name[5],
                    'doc_url' => $portfolioDoc
                );
                print_r($f_name[5]);
                PortfolioModel::Instance()->AddNewDocsForPortfolio($date);
           }
           
           $this->redirect(Url::local('profile/portfolio'));
       }
       
       public function action_doc_trash () {
           if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           $u_data = AuthClass::instance()->getUser();
           if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
           
           $id = Router::getUriParam(2);
           $file_name = Router::getUriParam(3);
           //echo 'images/portfolio/docs/'.$u_data['u_id'].'/'.$file_name;
           if(DelHelper::DeleteFile('images/portfolio/docs/'.$u_data['u_id'].'/'.$file_name)) {
                PortfolioModel::Instance()->trashDocsForPortfolio($id);
           }
           $this->redirect(Url::local('profile/portfolio'));
       }
        
        public function action_NewEducation () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('date_of_the_beginning')) $error['date_of_the_beginning'] = $user_portfolio['error_date_beginning'];
            if(!$this->post('end_date')) $error['end_date'] = $user_portfolio['error_end_date'];
            if(!$this->post('educational_institution')) $error['educational_institution'] = $user_portfolio['error_educational_institution'];
            if($this->post('date_of_the_beginning') === $this->post('end_date')) $error[] = $user_portfolio['error_one_date'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id_user' => $u_data['u_id'],
                    'date_of_the_beginning' => $this->post('date_of_the_beginning'),
                    'end_date' => $this->post('end_date'),
                    'education_received' => $this->post('education_received'),
                    'specialty' => $this->post('specialty'),
                    'educational_institution' => $this->post('educational_institution'),
                    'primary_education' => $this->post('primary_education')
                );
                
                $last_id = PortfolioModel::Instance()->NewEducations($addData);
                echo json_encode(array('success' => $last_id));
            }
        }
        
        public function action_UPDEducation () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('date_of_the_beginning')) $error['date_of_the_beginning'] = $user_portfolio['error_date_beginning'];
            if(!$this->post('end_date')) $error['end_date'] = $user_portfolio['error_end_date'];
            if(!$this->post('educational_institution')) $error['educational_institution'] = $user_portfolio['error_educational_institution'];
            if($this->post('date_of_the_beginning') === $this->post('end_date')) $error[] = $user_portfolio['error_one_date'];
                
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id' => $this->post('id'),
                    'date_of_the_beginning' => $this->post('date_of_the_beginning'),
                    'end_date' => $this->post('end_date'),
                    'education_received' => $this->post('education_received'),
                    'specialty' => $this->post('specialty'),
                    'educational_institution' => $this->post('educational_institution')
                );
                
                PortfolioModel::Instance()->UPDEducation($addData);
                echo json_encode(array('success' => $this->post('id')));
            }
        }
        
        public function action_deleteEducation () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            
            PortfolioModel::Instance()->deleteTREducation($this->post('id'));
            echo 'true';
        }
        
        public function action_NewEducation_languages () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
                
            $error = array();
            
            if(!$this->post('title_lang')) $error['title_lang'] = $user_portfolio['error_title_lang'];
            if($this->post('knowledge_level_write') == '0') $error['knowledge_level_write'] = $user_portfolio['error_knowledge_level_write'];
            if($this->post('knowledge_level_read') == '0') $error['knowledge_level_read'] = $user_portfolio['error_knowledge_level_read'];
            if($this->post('knowledge_level_dialog') == '0') $error['knowledge_level_dialog'] = $user_portfolio['error_knowledge_level_dialog'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id_user' => $u_data('u_id'),
                    'level_write' => $this->post('knowledge_level_write'),
                    'level_read' => $this->post('knowledge_level_read'),
                    'level_dialog' => $this->post('knowledge_level_dialog'),
                    'title_lang' => $this->post('title_lang')
                );
                
                $last_id = PortfolioModel::Instance()->NewEducation_languages($addData);
                echo json_encode(array('success' => $last_id));
            }
        }
        
        public function action_UPDEducation_languages () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
                
            $error = array();
            
            if(!$this->post('title_lang')) $error['title_lang'] = $user_portfolio['error_title_lang'];
            if($this->post('knowledge_level_write') == '0') $error['knowledge_level_write'] = $user_portfolio['error_knowledge_level_write'];
            if($this->post('knowledge_level_read') == '0') $error['knowledge_level_read'] = $user_portfolio['error_knowledge_level_read'];
            if($this->post('knowledge_level_dialog') == '0') $error['knowledge_level_dialog'] = $user_portfolio['error_knowledge_level_dialog'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id' => $this->post('id'),
                    'level_write' => $this->post('knowledge_level_write'),
                    'level_read' => $this->post('knowledge_level_read'),
                    'level_dialog' => $this->post('knowledge_level_dialog'),
                    'title_lang' => $this->post('title_lang')
                );
                
                PortfolioModel::Instance()->UPDEducation_languages($addData);
                echo json_encode(array('success' => $this->post('id')));
            }
        }
        
        public function action_deleteEducation_languages () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
                
            PortfolioModel::Instance()->deleteTREducation_languages($this->post('id'));
            echo 'true';
        }
        
        public function action_NewEducation_computer () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('title_lang_computer')) $error['title_lang_computer'] = $user_portfolio['error_title_lang_computer'];
            if($this->post('level') == '0') $error['level'] = $user_portfolio['error_level'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id_user' => $u_data['u_id'],
                    'title_lang_computer' => $post['title_lang_computer'],
                    'url_example' => $post['url_example'],
                    'level' => $post['level']
                );
                
                $last_id = PortfolioModel::Instance()->NewKnowledge_of_computer_programs($addData);
                echo json_encode(array('success' => $last_id));
            }
        }
        
        public function action_UPDEducation_computer () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('title_lang_computer')) $error['title_lang_computer'] = $user_portfolio['error_title_lang_computer'];
            if($this->post('level') == '0') $error['level'] = $user_portfolio['error_level'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id' => $this->post('id'),
                    'title_lang_computer' => $this->post('title_lang_computer'),
                    'url_example' => $this->post('url_example'),
                    'level' => $this->post('level')
                );
                
                PortfolioModel::Instance()->UPDKnowledge_of_computer_programs($addData);
                echo json_encode(array('success' => $this->post('id')));
            }
        }
        
        public function action_deleteEducation_computer () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            
            PortfolioModel::Instance()->deleteTRKnowledge_of_computer_programs($this->post('id'));
            echo 'true';
        }
        
        public function action_NewWork_post () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('date_of_the_beginning')) $error['date_of_the_beginning'] = $user_portfolio['error_date_beginning'];
            if(!$this->post('work_post_fact')) $error['work_post_fact'] = $user_portfolio['error_work_post'];
            if(!$this->post('specialty')) $error['specialty'] = $user_portfolio['error_specialty'];
            if($this->post('real_work_post') == '1') {
                $end_date = '0';
            } else {
                if(!$this->post('end_date')) $error['end_date'] = $user_portfolio['error_end_date'];
                else $end_date = $this->post('end_date');
            }
            if($this->post('date_of_the_beginning') === $this->post('end_date')) $error[] = $user_portfolio['error_one_date'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id_user' => $u_data['u_id'],
                    'date_of_the_beginning' => $this->post('date_of_the_beginning'),
                    'work_post' => $this->post('work_post_fact'),
                    'end_date' => $end_date,
                    'real_work_post' => ($this->post('real_work_post') == '1')?'1':'0',
                    'experience' => $this->post('specialty')
                );
                
                $last_id = PortfolioModel::Instance()->NewWork_post($addData);
                echo json_encode(array('success' => $last_id));
            }
        }
        
        public function action_UPDWork_post () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('date_of_the_beginning')) $error['date_of_the_beginning'] = $user_portfolio['error_date_beginning'];
            if($this->post('real_work_post') == '1') {
                $end_date = $user_portfolio['acc_real_work_post'];
            } else {
                if(!$this->post('end_date')) $error['end_date'] = $user_portfolio['error_end_date'];
                else $end_date = $this->post('end_date');
            }
            if(!$this->post('work_post_fact')) $error['work_post_fact'] = $user_portfolio['error_work_post'];
            if(!$this->post('specialty')) $error['specialty'] = $user_portfolio['error_specialty'];
            if($this->post('date_of_the_beginning') === $this->post('end_date')) $error[] = $user_portfolio['error_one_date'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id' => $this->post('id'),
                    'date_of_the_beginning' => $this->post('date_of_the_beginning'),
                    'work_post' => $this->post('work_post_fact'),
                    'end_date' => $end_date,
                    'real_work_post' => ($this->post('real_work_post') == '1')?'1':'0',
                    'experience' => $this->post('specialty')
                );
                //print_r($addData);
                $rez = PortfolioModel::Instance()->UPDWork_post($addData);
                echo json_encode(array('success' => $this->post('id')));
            }
        }
        
        public function action_deleteWork_post () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
                
            PortfolioModel::Instance()->deleteTRWork_post($this->post('id'));
            echo 'true';
        }
        
        public function action_newreview () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '5') $this->redirect(Url::local('profile'));
            
            $user_portfolio = $this->lang('portfolio');
            
            if(!$this->post('msg')) $error = $user_portfolio['review_error_msg_empty'];
            if(!$this->post('user_to')) $error = $user_portfolio['review_error_user_to_empty'];
            if($u_data['u_id'] == $this->post('user_to')) $error = $user_portfolio['review_error_user_to_user_login'];
            
            $review = PortfolioModel::Instance()->GetReviewForUser($u_data['u_id'], $this->post('user_to'));
            if(!empty($review)) $error = $user_portfolio['review_error_review_exist'];
            
            if($error) {
                echo json_encode($error);
            } else {
                $add = array(
                    'id_user_to' => $this->post('user_to'),
                    'id_user_from' => $u_data['u_id'],
                    'review_text' => $this->post('msg'),
                    'status_review' => $this->post('type_review'),
                    'date_send' => time()
                );
                
                $email_user_to = ProfileModel::Instance()->getUserEmail($this->post('user_to'));
                
                PortfolioModel::Instance()->AddReviewForUser($add);
                
                $subject = 'New review';
                $message = $u_data['name'].' '.$u_data['lastname'].'<br />'.$this->post('msg');
                $sendMessage = EmailTPLHelper::SendEmail($email_user_to['email'], $subject, $message);
                
                echo json_encode($user_portfolio['review_added']);
            }
        }
       
       public function action_vmsendmsg () {
            if(AuthClass::instance()->isAuth()) $u_data = AuthClass::instance()->getUser();
            else $this->redirect(Url::local(''));
            $lang_message = $this->lang('vacancies');
            
            $getPortfolioId = PortfolioModel::Instance()->getPortfolioId($u_data['u_id']);
            $getAuthorId = VacanciesModel::Instance()->getAuthorId(Router::getUriParam(2));
            
            if(!$getAuthorId) echo json_encode(array('error' => 'Author not exist!'));
            else {
                if(empty($getPortfolioId['id'])) echo json_encode(array('error' => $lang_message['portfolio_dont_found']));
                else {
                    $ifCandidatExist = PortfolioModel::Instance()->ifCandidatExist(Router::getUriParam(2), $getPortfolioId['id']);
                    if(!$ifCandidatExist['id']) {
                        $add = array(
                            'id_v' => Router::getUriParam(2),
                            'id_p' => $getPortfolioId['id'], 
                            'id_user' => $getAuthorId['id_user'],
			  									 'date_add' => time()
                        );
                        
                        PortfolioModel::Instance()->AddCandidatura($add);
                        
                        //$sendMessage = EmailTPLHelper::SendEmail($this->post('email'), $this->post('subject'), $this->post('message'));
                        echo json_encode(array('success' => $lang_message['candidat_sended']));
                    } else echo json_encode(array('error' => $lang_message['candidat_exist']));
                }
            }
        }
        
        public function action_branch_default () {
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $oldDefault = BranchModel::Instance()->branchSelect($this->post('id_usr'));
            
            if(!empty($oldDefault[0])) {
                BranchModel::Instance()->UpdBranch(array('id' => (int)$oldDefault[0]['id'], 'default_br' => 0));
            }
            
            $rez = BranchModel::Instance()->UpdBranch(array('id' => (int)$this->post('id_branch'), 'default_br' => 1));
            echo 'ok';
        }
        
        public function uploadDocument () {
            $this->VerifUser();

            if ( 0 < $_FILES['file']['error'] ) {
                echo 'Error: ' . $_FILES['file']['error'];
            }
            else {
                $date = $this->app->lib_Validation->uploadImgDoc($_FILES['file'], $_COOKIE['id']);
                echo $date;
                //move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
            }
        }
    }
?>