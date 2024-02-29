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
            
            if(!$this->post('user_to')) $msg['errors']['email'] = 'User error!';
            
            if(!$this->post('subject')){
                $msg['errors']['subject'] = $lang_message['error_empty_subject'];
            }
            
            if(!$this->post('message')){
                $msg['errors']['message'] = $lang_message['error_empty_message'];
            }
            
            if(AuthClass::instance()->isAuth()) {
                $u_data = AuthClass::instance()->getUser();
                $user_from_id = $u_data['u_id'];
            } else $user_from_id = 0;
            
            if(!empty($msg['errors'])) {
                echo json_encode($msg);
            } else {
                $add = array(
                    'id_user' => $this->post('user_to'),
                    'user_id_from' => $user_from_id,
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
        
        public function action_auto_portfolio () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            
            $user_portfolio = $this->lang('portfolio');
            
            if(!$this->post('keywords')) $msg = 'Keywords empty';
            if(!$this->post('location')) $msg = 'Location empty';
            
            if(!isset($msg)) {
                $rez = PortfolioModel::Instance()->selectAutoPotrfolio($u_data['u_id']);
                
                $addData = array(
                    'id_user' => $u_data['u_id'],
                    'keywords' => $this->post('keywords'),
                    'location' => $this->post('location')
                );
                
                if(!$rez) {
                    PortfolioModel::Instance()->saveAutoPotrfolio($addData);
                } else {
                    $addData['id'] = $rez['id'];
                    PortfolioModel::Instance()->updAutoPotrfolio($addData);
                }
                
                $msg = 'Ok';
            }
            echo json_encode($msg);
       }
       
       public function action_auto_portfolio_disable () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            
            $user_portfolio = $this->lang('portfolio');
            
            PortfolioModel::Instance()->deleteAutoPortfolio($u_data['u_id']);
            
            echo json_encode($user_portfolio['acc_auto_portfolio_disable']);
       }
       
       public function action_save_user_about () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            $user_portfolio = $this->lang('portfolio');
            
            $msg = array(
                'errors' => array(),
                'success' => ''
            );
            
            if(!$this->post('about')) $msg['errors']['about'] = $user_portfolio['error_about'];
            if(!$this->post('assests')) $msg['errors']['assests'] = $user_portfolio['error_assests'];
            if(!$this->post('hobbi')) $msg['errors']['hobbi'] = $user_portfolio['error_hobbi'];
            
            $portfolioData = PortfolioModel::Instance()->GetUserPortfolio($u_data['u_id']);
            
            if(empty($msg['errors']) and !empty($portfolioData)) {
                $arrportfolioData = array(
                    'id' => $portfolioData['id'],
                    'about' => htmlspecialchars($this->post('about')),
                    'assests' => serialize($this->post('assests')),
                    'hobbi' => serialize($this->post('hobbi')),
                    'interests' => ($this->post('interests'))?serialize($this->post('interests')):''
                );
                PortfolioModel::Instance()->UPDPortfolio($arrportfolioData);
                $msg['success'] = $user_portfolio['save_success'];
            }
            echo json_encode($msg);
       }
       
       public function action_saveportfolio () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
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
                $portfolioImg = UploadHelper::UploadOneImage('users/'.$u_data['u_id'], $_FILES['portfolio_profile_logo']);
            }
            if($this->post('category_portfolio') == '0') $msg['errors']['id_category'] = 'Select the category';
            if(!$this->post('name')) $msg['errors']['name'] = $user_portfolio['error_empty_name'];
            if(!$this->post('lastname')) $msg['errors']['lastname'] = $user_portfolio['error_empty_lastname'];
            if(!$this->post('nacional')) $msg['errors']['nacional'] = $user_portfolio['error_empty_nacional'];
            if(!$this->post('fiscalCode')) $msg['errors']['fiscalCode'] = $user_portfolio['error_empty_fiscalCode'];
            if($this->post('document') == '0') $msg['errors']['document'] = $user_portfolio['error_document'];
            if(!$this->post('adResident')) $msg['errors']['adResident'] = $user_portfolio['error_empty_adresResident'];
            if(!$this->post('birthDate')) $msg['errors']['birthDate'] = $user_portfolio['error_empty_birthDate'];
            if(!$this->post('patent')) $msg['errors']['patent'] = $user_portfolio['error_patent'];
            if($this->post('family') != '1' and $this->post('family') != '0') $msg['errors']['family'] = $user_portfolio['error_empty_marital_status'];
            
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
            if(isset($_POST['resident_yes']) and $this->post('resident_yes') == '1') {
                if(!$this->post('adDom')) $msg['errors']['adDom'] = $user_portfolio['error_empty_adresDomicilio'];
            }
            
            if($_FILES['cv_of_user']['name']) {
                if (($_FILES['cv_of_user']['type'] != "image/jpg") && ($_FILES['cv_of_user']['type'] != "image/jpeg") && ($_FILES['cv_of_user']['type'] != "image/png")) $msg['errors']['cv_of_user'] = $user_portfolio['cv_format_error'];
                if ($_FILES['cv_of_user']['size'] > 20480000) $msg['errors']['cv_of_user'] = $user_portfolio['cv_size_error'];
                
                if(empty($msg['errors'])) $cv_of_user = UploadHelper::UploadOneImage('portfolio/'.$u_data['u_id'], $_FILES['cv_of_user'], $u_data['login']);
            } else $cv_of_user = $portfolioData['cv_of_user'];
            
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
                    'adresResident' => $this->post('adResident'),
                    'adresDomicilio' => $this->post('adDom'),
                    'patent' => serialize($this->post('patent')),
                    'marital_status' => $this->post('family'),
                    'cv_of_user' => $cv_of_user,
                    'search_status' => ($this->post('portfolio_off'))?$this->post('portfolio_off'):'0'
                );
                
                if ($u_data['validStatus'] == '0') {
                    $UserDate = array(
                        'user_id' => $u_data['u_id'],
                        'name' => $this->post('name'),
                        'lastname' => $this->post('lastname'),
                        'mobile' => $this->post('mobile'),
                        'address' => $this->post('adResident'),
                        'type_person' => '5',
                        'user_img' => $portfolioImg
                    );
                    ProfileModel::Instance()->editProfile($UserDate);
                    ProfileModel::Instance()->updUser(array('id' => $u_data['u_id'], 'validStatus' => '1'));
                }
                //echo'<pre>'; print_r($_POST); echo'</pre>';
                if(empty($portfolioData)) {
                    $id = PortfolioModel::Instance()->AddNewPortfolio($arrportfolioData);
                    $portfolio_id = $id;
                } else {
                    $arrportfolioData['id'] = $portfolioData['id'];
                    PortfolioModel::Instance()->UPDPortfolio($arrportfolioData);
                    $portfolio_id = $portfolioData['id'];
                }
                
                $rez = PortfolioModel::Instance()->SelectCategoryPotrfolio($portfolio_id);
                $addData = array(
                    'id_category' => $this->post('category_portfolio'),
                    'id_portfolio' => $portfolio_id
                );
                if(!empty($rez)) PortfolioModel::Instance()->UPDCategoryPotrfolio($addData);
                else PortfolioModel::Instance()->SaveCategoryPotrfolio($addData);
                
                $msg['success'] = $user_portfolio['save_success'];
            }
            echo json_encode($msg);
        }
        
        public function action_portfolio_document () {
           if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
           $u_data = AuthClass::instance()->getUser();
           if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
           
           if($_FILES['doc_file']['name']) {
                $portfolioDoc = UploadHelper::UploadOneImage('portfolio/docs/'.$u_data['u_id'], $_FILES['doc_file']);
                $f_name = explode('/',$portfolioDoc);
                $date = array(
                    'id_user' => $u_data['u_id'],
                    'title' => $this->post('doc_desc'),
                    'file_name' => $f_name[5],
                    'doc_url' => $portfolioDoc
                );
                //print_r($f_name[5]);
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
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('date_of_the_beginning')) $error['date_of_the_beginning'] = $user_portfolio['error_date_beginning'];
            if(!$this->post('end_date')) $error['end_date'] = $user_portfolio['error_end_date'];
            if(!$this->post('education_received')) $error['education_received'] = $user_portfolio['acc_education_received_placeholder'];
            if(!$this->post('specialty')) $error['specialty'] = $user_portfolio['acc_specialty_placeholder'];
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
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
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
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            
            PortfolioModel::Instance()->deleteTREducation($this->post('id'));
            echo 'true';
        }
        
        public function action_NewEducation_languages () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
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
                    'id_user' => $u_data['u_id'],
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
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
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
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
                
            PortfolioModel::Instance()->deleteTREducation_languages($this->post('id'));
            echo 'true';
        }
        
        public function action_NewEducation_computer () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('title_lang_computer')) $error['title_lang_computer'] = $user_portfolio['error_title_lang_computer'];
            if($this->post('level') == '0') $error['level'] = $user_portfolio['error_level'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id_user' => $u_data['u_id'],
                    'title_lang_computer' => $this->post('title_lang_computer'),
                    'url_example' => $this->post('url_example'),
                    'level' => $this->post('level')
                );
                $last_id = PortfolioModel::Instance()->NewKnowledge_of_computer_programs($addData);
                echo json_encode(array('success' => $last_id));
            }
        }
        
        public function action_UPDEducation_computer () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
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
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            
            PortfolioModel::Instance()->deleteTRKnowledge_of_computer_programs($this->post('id'));
            echo 'true';
        }
        
        public function action_NewWork_post () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            //print_r($_POST);
            if(!$this->post('date_of_the_beginning_work')) $error['date_of_the_beginning_work'] = $user_portfolio['error_date_beginning'];
            if(!$this->post('work_post_fact')) $error['work_post_fact'] = $user_portfolio['error_work_post'];
            if(!$this->post('position')) $error['position'] = $user_portfolio['error_specialty'];
            if($this->post('real_work_post') == '1') {
                $end_date = '0';
            } else {
                if(!$this->post('end_date_work')) $error['end_date_work'] = $user_portfolio['error_end_date'];
                else $end_date = $this->post('end_date_work');
            }
            if($this->post('date_of_the_beginning_work') === $this->post('end_date_work')) $error[] = $user_portfolio['error_one_date'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id_user' => $u_data['u_id'],
                    'date_of_the_beginning' => $this->post('date_of_the_beginning_work'),
                    'work_post' => $this->post('work_post_fact'),
                    'end_date' => $end_date,
                    'real_work_post' => ($this->post('real_work_post') == '1')?'1':'0',
                    'experience' => $this->post('position')
                );
                
                $last_id = PortfolioModel::Instance()->NewWork_post($addData);
                echo json_encode(array('success' => $last_id));
            }
        }
        
        public function action_UPDWork_post () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            $user_portfolio = $this->lang('portfolio');
            
            $error = array();
            
            if(!$this->post('date_of_the_beginning_work')) $error['date_of_the_beginning_work'] = $user_portfolio['error_date_beginning'];
            if($this->post('real_work_post') == '1') {
                $end_date = $user_portfolio['acc_real_work_post'];
            } else {
                if(!$this->post('end_date_work')) $error['end_date_work'] = $user_portfolio['error_end_date'];
                else $end_date = $this->post('end_date_work');
            }
            if(!$this->post('work_post_fact')) $error['work_post_fact'] = $user_portfolio['error_work_post'];
            if(!$this->post('position')) $error['position'] = $user_portfolio['error_specialty'];
            if($this->post('date_of_the_beginning_work') === $this->post('end_date_work')) $error[] = $user_portfolio['error_one_date'];
            
            if(!empty($error)){
                echo json_encode(array('error' => $error));
            } else {
                $addData = array(
                    'id' => $this->post('id'),
                    'date_of_the_beginning' => $this->post('date_of_the_beginning_work'),
                    'work_post' => $this->post('work_post_fact'),
                    'end_date' => $end_date,
                    'real_work_post' => ($this->post('real_work_post') == '1')?'1':'0',
                    'experience' => $this->post('position')
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
            //if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
                
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
            $lang_message = $this->lang('vacancies');
            $lang_new_candidat = $this->lang('new_candidat');
            $emailtpl = $this->lang('emailtpl');
            
            if(AuthClass::instance()->isAuth()) {
                $u_data = AuthClass::instance()->getUser();
            } else $this->redirect(Url::local(''));
            
            $id_vac = Router::getUriParam(2);
            $getPortfolioId = PortfolioModel::Instance()->getPortfolioId($u_data['u_id']);
            $authorId = VacanciesModel::Instance()->getAuthorId($id_vac);
            $title_vac = VacanciesModel::Instance()->getTitleOfVacance($id_vac);
            
            if(!$authorId) echo json_encode(array('error' => 'Author not exist!'));
            else {
                if(empty($getPortfolioId['id'])) echo json_encode(array('error' => $lang_message['portfolio_dont_found']));
                else {
                    $ifCandidatExist = PortfolioModel::Instance()->ifCandidatExist($id_vac, $getPortfolioId['id'], $u_data['u_id']);

                    if(!$ifCandidatExist['id']) {
                        $add = array(
                            'id_v' => (int)$id_vac,
                            'id_p' => $getPortfolioId['id'], 
                            'id_c' => $u_data['u_id'],
                            'id_user' => $authorId['id_user'],
                            'c_cv_url' => '/portfolio/user/'.$u_data['login'],
                            'date_add' => time()
                        );
                        
                        PortfolioModel::Instance()->AddCandidatura($add);
                        
                        //----message for users
                        $replace_body = array(
                            '{usenName}' => $u_data['lastname'].' '.$u_data['name'],
                            '{title_v}' => '<a href="'.SITE.'/vacancies/page/'.$title_vac['seo'].'" target="_blank">'.$title_vac['title'].'</a>'
                        );
                        $reg_body = str_replace(array_keys($replace_body), array_values($replace_body), $lang_new_candidat['user_candidat_body']);
                        
                        $replace = array(
                            '{title}' => $lang_new_candidat['register_welcome_title'],
                            '{body}' => $reg_body,
                            '{btn}' => $lang_new_candidat['register_welcome_btn']
                        );
                        $message_HTML = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);
        
                        $message_without_HTML = $lang_new_candidat['register_welcome_title'].$reg_body;
                        $send = EmailTPLHelper::SendEmail($u_data['email'], $lang_new_candidat['register_welcome_title'], $message_HTML, $message_without_HTML);
                        //----/message for users
                        
                        //----message for agency
                        $replace_body = array(
                            '{usenName}' => $u_data['lastname'].' '.$u_data['name'],
                            '{title}' => $title_vac['title'],
                            '{cv_link}' => SITE.'/portfolio/printpdf/'.$u_data['login']
                        );
                        $reg_body = str_replace(array_keys($replace_body), array_values($replace_body), $lang_new_candidat['send_candidat_for_agency_body']);
                        
                        $vac_title = str_replace('{title}', $title_vac['title'], $lang_new_candidat['send_candidat_for_agency_title']);
                        $replace = array(
                            '{title}' => $vac_title,
                            '{body}' => $reg_body,
                            '{btn}' => $lang_new_candidat['register_welcome_btn']
                        );
                        $message_HTML = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);
        
                        $message_without_HTML = $lang_new_candidat['send_candidat_for_agency_title'].$reg_body;
                        $send = EmailTPLHelper::SendEmail($authorId['email'], $lang_new_candidat['send_candidat_for_agency_subject'], $message_HTML, $message_without_HTML);
                        //----message for agency
                        
                        echo json_encode(array('success' => $lang_message['candidat_sended']));
                    } else echo json_encode(array('error' => $lang_message['candidat_exist']));
                }
            }
        }
        
        public function action_branch_default () {
            if(AuthClass::instance()->isAuth()) $u_data = AuthClass::instance()->getUser();
            else $this->redirect(Url::local(''));
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $oldDefault = BranchModel::Instance()->branchSelect($this->post('id_user'));
            
            if(!empty($oldDefault)) {
                BranchModel::Instance()->UpdBranch(array('id' => (int)$oldDefault['id'], 'default_br' => 0));
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
        
        public function action_request_test_drive () {
            $msg = array(
                'error' => array(),
                'success' => array()
            );
            
            if(!$this->post('user_name')) $msg['error']['user_name'] = 'Insert name!';
            if(!$this->post('user_email')) $msg['error']['email'] = 'Insert email!';
            else {
                if(!HTMLHelper::validEmail($this->post('user_email'))){
                    $msg['error']['user_email'] = 'Email is wrong!';
                }
            }
            if(!$this->post('adv_id')) $msg['error']['adv_id'] = 'General problem!';
            else {
                $email_to = UsersModel::Instance()->getUserEmail($this->post('adv_id'));
            }
            
            if(!$this->post('telefono')) $msg['error']['telefono'] = 'Insert mobile!';
            if(!$this->post('date_request')) $msg['error']['date_request'] = 'Insert mobile!';
            if($this->post('request_time') == '0') $msg['error']['request_time'] = 'Insert date for test-drive!';
            
            $email_message = 'Richiesta test-drive da <b>'.$this->post('user_name').'</b><br />Orario richiesto: <b>'.$this->post('request_time').'</b>';
            if($this->post('message')) $email_message .= '<br />Messaggio: <i>'.$this->post('message').'</i>';
            $email_message .= '<hr />Contatti del richiedente:<br />Email: '.$this->post('user_email').'<br />Cell.:'.$this->post('telefono');
            
            if (empty($msg['error'])) {
                $sendMessage = EmailTPLHelper::SendEmail($email_to['email'], 'Request test-drive', $email_message, $this->post('message'));
                $msg['success'] = 'send_message_success';
            }
            
            echo json_encode($msg);
        }
        
        public function action_updStatusMessage () {
            if(AuthClass::instance()->isAuth()) $u_data = AuthClass::instance()->getUser();
            else $this->redirect(Url::local(''));
            
            if($this->post('id_msg') and $this->post('read_status')) {
                $data = array(
                    'id' => $this->post('id_msg'),
                    'read_status' => $this->post('read_status')
                );
                MessagesModel::Instance()->updStatusMessage($data);
                
                echo json_encode('1');
            }
        }
        
        public function action_branchlist () {
            if($this->post('id_company')) {
                $branchList = BranchModel::Instance()->getListBranchForUser($this->post('id_company'));
                if (!empty($branchList)) {
                    $branchList = $branchList;
                } else $branchList = 'Filials dont exists';
            } else $branchList = 'error'; 
            
            echo json_encode($branchList);
        }
        
        public function action_change_password () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            $u_data = AuthClass::instance()->getUser();
            
            $res = AuthClass::instance()->changePassword($u_data['login'], $this->post('old_pass'), $this->post('new_pass'));
            //$this->redirect(Url::local('profile'));
            echo json_encode($res);
        }
        
        public function action_recovery () {
           if(AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local('profile'));
	       }
           
           $lang_login = $this->lang('login');
           $emailtpl = $this->lang('emailtpl');
           
           if($this->post('email')) 
                if(HTMLHelper::validEmail($this->post('email'))) $msg = $lang_login['error_email'];
                
           $user = DBClass::Instance()->getCount('users', 'email = :email', array('email' => $this->post('email')), 'id');
           
           //print_r($user);
           if($user['numCount'] == '1') {
                $u_data = ProfileModel::Instance()->getUserNameLastnameWithEmail($this->post('email'));
                $new_pass = rand(1000000, 9999999);
                
                $replace_body = array(
                    '{login}' => $this->post('login'),
                    '{password}' => $new_pass
                );
                $reg_body = str_replace(array_keys($replace_body), array_values($replace_body), $lang_login['recovery_email_send']);
                
                $replace = array(
                    '{title}' => $lang_new_candidat['recovery_email_subject'],
                    '{body}' => $reg_body,
                    '{btn}' => $lang_new_candidat['register_welcome_btn']
                );
                $message_HTML = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);
                
                $msg = EmailTPLHelper::SendEmail(
                    $this->post('email'), 
                    $lang_login['recovery_email_subject'],
                    $message_HTML, 
                    $reg_body
                );
                if($msg === true) {
                    AuthClass::instance()->recovery($this->post('email'), $new_pass);
                    $msg = $lang_login['recovery_success'];
                }
           } else {
                $msg = $lang_login['error_email'];
           }
           
           echo json_encode($msg);
        }
        
        public function action_new_candidat() {
            $lang_new_candidat = $this->lang('new_candidat');
            $emailtpl = $this->lang('emailtpl');
            $msg = array(
                'errors' => array(),
                'success' => ''
            );
            
            if(AuthClass::instance()->isAuth()) $msg['errors']['name'] = $lang_new_candidat['user_exist'];
            
            if(!$this->post('name')) $msg['errors']['name'] = $lang_new_candidat['empty_name'];
            if(!$this->post('lastname')) $msg['errors']['lastname'] = $lang_new_candidat['empty_lastname'];
            if(!$this->post('email')) $msg['errors']['email'] = $lang_new_candidat['empty_email'];
            elseif(!HTMLHelper::validEmail($this->post('email'))) $msg['errors']['email'] = $lang_new_candidat['email_format_incorrect'];
            else {
                $email_num = DBClass::Instance()->getCount('users', 'email = :email', array('email' => $this->post('email')), 'id');
                if ($email_num['numCount'] != '0') $msg['errors']['email'] = $lang_new_candidat['email_exist'];
            }
            
            if(empty($_FILES['cv']['name'])) $msg['errors']['cv'] = $lang_new_candidat['cv_empty'];
            else {
                $extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
                if (($_FILES['cv']['type'] != "image/jpg") && ($_FILES['cv']['type'] != "image/jpeg") && ($_FILES['cv']['type'] != "image/png") && $extension != 'pdf') $msg['errors']['cv'] = $lang_new_candidat['cv_format_error'];
                if ($_FILES['cv']['size'] > 20480000) $msg['errors']['cv'] = $lang_new_candidat['cv_size_error'];
            }
            
            $getAuthorId = VacanciesModel::Instance()->getAuthorId($this->post('id_v'));
            if(empty($getAuthorId)) $msg['errors']['cv'] = $lang_new_candidat['author_dont_exist'];
            
            if (empty($msg['errors'])) {
                if(HTMLHelper::isRuLetters($this->post('name'))) {
                    $name_en = HTMLHelper::TranslistLetterRU_EN($this->post('name'));
                    $lastname_en = HTMLHelper::TranslistLetterRU_EN($this->post('lastname'));
                    $login = $name_en.$lastname_en;
                } else {
                    $login = $this->post('name').$this->post('lastname');
                }
                
                $pass = explode('@', $this->post('email'));
                
                AuthClass::instance()->registerUser($login, $pass[0], $this->post('email'), '5');
                $newUserId = ProfileModel::Instance()->getNewUserId($login);
                $data = array(
                    'user_id' => $newUserId['id'],
                    'name' => $this->post('name'),
                    'lastname' => $this->post('lastname')
                );
                ProfileModel::Instance()->editProfile($data);
                
                $img = UploadHelper::UploadOneImage('portfolio/'.$newUserId['id'], $_FILES['cv'], $login);
                
                $add = array(
                    'id_v' => $this->post('id_v'),
                    'id_c' => $newUserId['id'],
                    'img_c' => $img,
                    'id_user' => $getAuthorId['id_user'],
                    'date_add' => time()
                );
                
                PortfolioModel::Instance()->AddCandidatura($add);
                
                //----message for users
                $replace_body = array(
                    '{usenName}' => $this->post('lastname').' '.$this->post('name'),
                    '{title_v}' => $this->post('title_v'),
                    '{login}' => $login,
                    '{pass}' => $pass[0]
                );
                $reg_body = str_replace(array_keys($replace_body), array_values($replace_body), $lang_new_candidat['register_welcome_body']);
                
                $replace = array(
                    '{title}' => $lang_new_candidat['register_welcome_title'],
                    '{body}' => $reg_body,
                    '{btn}' => $lang_new_candidat['register_welcome_btn']
                );
                $message_HTML = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);

                $message_without_HTML = $lang_new_candidat['register_welcome_title'].$reg_body;
                $send = EmailTPLHelper::SendEmail($this->post('email'), $lang_new_candidat['register_welcome_title'], $message_HTML, $message_without_HTML);
                //----/message for users
                
                //----message for agency
                $replace_body = array(
                    '{usenName}' => $this->post('lastname').' '.$this->post('name'),
                    '{title}' => $this->post('title_v'),
                    '{cv_link}' => SITE.'/'.$img
                );
                $reg_body = str_replace(array_keys($replace_body), array_values($replace_body), $lang_new_candidat['send_candidat_for_agency_body']);
                
                $replace = array(
                    '{title}' => $lang_new_candidat['send_candidat_for_agency_title'],
                    '{body}' => $reg_body,
                    '{btn}' => $lang_new_candidat['register_welcome_btn']
                );
                $message_HTML = str_replace(array_keys($replace), array_values($replace), $emailtpl['email']);

                $message_without_HTML = $lang_new_candidat['send_candidat_for_agency_title'].$reg_body;
                $send = EmailTPLHelper::SendEmail($getAuthorId['email'], $lang_new_candidat['send_candidat_for_agency_subject'], $message_HTML, $message_without_HTML);
                //----message for agency
                
                $msg['success'] = $lang_new_candidat['candidat_addd'];
            }
            
            //print_r($_POST);
            //print_r($_FILES);
            echo json_encode($msg);
       }
       
       public function action_vacancies_by_location () {
            if ($this->post('v_local')) {
            	$search = trim($this->post('v_local'));
             
            	$result = VacanciesModel::Instance()->getVacanciesByLocation($search);
                //print_r($result);
            	if ($result) {
            		$rez = '<div class="search_result"><table>';
                    foreach ($result as $row){
          				$rez .= '<tr><td class="search_result-name"><a href="/vacancelocal/'.$row['location'].'">'.$row['location'].'</a></td><td>'.$row['num'].' offerte a questa cita</td></tr>';
            		}	
                    $rez .= '</table></div>';
            	} else {
            	   $rez = '<div class="search_result"><table><tr><td class="search_result-name">Annunci non trovati</td></tr></table></div>';
            	}
                echo $rez;
            }
       }
    }
?>