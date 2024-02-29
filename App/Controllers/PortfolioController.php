<?php
	class PortfolioController extends Controller {
       public function action_index() {
	       $v = new View('site/portfoliolist');
           
           $lang_portfolio = $this->lang('portfolio');
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           
           $v->title = $lang_portfolio['portfolio_list_title'];
           $v->description = $lang_portfolio['portfolio_list_description'];
           $v->keywords = $lang_portfolio['portfolio_list_keywords'];
           $v->text_specialists = $lang_portfolio['portfolio_list_specialists'];
           $v->text_category_companies = '';
           $v->og_img = '';
           
           $page = (int)Router::getUriParam('page');
           $count = PortfolioModel::Instance()->getPortfolioCount(9);
           
           if($page < 1 or $page > $count) Url::local('404');
           
           $v->portfolioList = PortfolioModel::Instance()->getPortfolioPage($page, 9);
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('portfolio'));
           
           $v->u_auth = false;
           if(AuthClass::instance()->isAuth()) {
                $u_date = AuthClass::instance()->getUser();
                //$v->portfolio_saved = SaveportfolioModel::Instance()->getListSavedPortfolioForProfile($v->profile_data['u_id']);
                $v->u_auth = ($u_date['type_person'] == '4')?true:false;
           }
           
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_category() {
	       $v = new View('site/portfoliolist');
           $lang_portfolio = $this->lang('portfolio');
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           
           $v->title = $lang_portfolio['portfolio_list_title'];
           $v->description = $lang_portfolio['portfolio_list_description'];
           $v->keywords = $lang_portfolio['portfolio_list_keywords'];
           $v->text_specialists = $lang_portfolio['portfolio_list_specialists'];
           $v->text_category_companies = '';
           $v->og_img = '';
           
           $subCatId = (int)Router::getUriParam(2);
           
           $page = (int)Router::getUriParam('page');
           $count = PortfolioModel::Instance()->getPortfolioCount(9, $subCatId);
           
           $v->u_auth = false;
           if(AuthClass::instance()->isAuth()) {
                $u_date = AuthClass::instance()->getUser();
                $v->u_auth = ($u_date['type_person'] == '4')?true:false;
           }
           
           if($page < 1 or $page > $count) Url::local('404');
           $v->portfolioList = PortfolioModel::Instance()->getPortfolioPage($page, 9, $subCatId);
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('portfolio/category/'.$subCatId));
           
           $v->vacancies_menu = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountPortfolioList();
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_user () {
           $p_page = Router::getUriParam(2);
           $portfolioData = PortfolioModel::Instance()->GetPortfolioData($p_page);
           
           if(isset($portfolioData['id'])) $v = new View('site/page_portfolio');
           else $v = new View('site/page_portfolio_off');
           
           $lang_portfolio = $this->lang('portfolio');
           
           $v->text_about = $lang_portfolio['page_portfolio_about'];
           $v->text_review = $lang_portfolio['page_portfolio_review'];
           $v->text_newReview = $lang_portfolio['page_portfolio_newReview'];
           $v->text_type_review_yes = $lang_portfolio['page_portfolio_type_review_yes'];
           $v->text_type_review_no = $lang_portfolio['page_portfolio_type_review_no'];
           $v->text_close = $lang_portfolio['close'];
           $v->text_send = $lang_portfolio['send'];
           $v->text_nacional = $lang_portfolio['page_portfolio_nacional'];
           $v->text_fiscalCode = $lang_portfolio['page_portfolio_fiscalCode'];
           $v->text_document = $lang_portfolio['page_portfolio_document'];
           $v->text_adresResident = $lang_portfolio['page_portfolio_adresResident'];
           $v->text_patent = $lang_portfolio['page_portfolio_patent'];
           $v->text_transport = $lang_portfolio['page_portfolio_transport'];
           $v->text_non_patent = $lang_portfolio['page_portfolio_non_patent'];
           $v->text_marital_status = $lang_portfolio['page_portfolio_marital_status'];
           $v->text_yes = $lang_portfolio['yes'];
           $v->text_no = $lang_portfolio['no'];
           $v->text_nameAssests = $lang_portfolio['page_portfolio_nameAssests'];
           $v->text_nameHobbi = $lang_portfolio['page_portfolio_nameHobbi'];
           $v->text_nameInterests = $lang_portfolio['page_portfolio_nameInterests'];
           $v->text_share = $lang_portfolio['page_portfolio_share'];
           $v->text_portfolio_languages = $lang_portfolio['page_portfolio_portfolio_languages'];
           $v->text_portfolio_computer = $lang_portfolio['page_portfolio_portfolio_computer'];
           $v->text_portfolio_work_post = $lang_portfolio['page_portfolio_portfolio_work_post'];
           $v->text_real_work_post = $lang_portfolio['acc_real_work_post'];
           $v->text_portfolio_educations = $lang_portfolio['page_portfolio_portfolio_educations'];
           $v->text_message_for = $lang_portfolio['page_portfolio_message_for'];
           $v->text_name = $lang_portfolio['name'];
           $v->text_email = $lang_portfolio['email'];
           $v->text_email_from = $lang_portfolio['page_portfolio_email_from'];
           $v->text_subject = $lang_portfolio['subject'];
           $v->text_message = $lang_portfolio['page_portfolio_message'];
           $v->text_message_sended = $lang_portfolio['page_portfolio_message_sended'];
           $v->text_message_error = $lang_portfolio['page_portfolio_message_error'];
           //$v->text_ = $lang_portfolio[''];   
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
          
          if(AuthClass::instance()->isAuth()) {
               $user = AuthClass::instance()->getUser();
               $v->userAuth_name = $user['name'].' '.$user['lastname'];
               $v->userAuth_email = $user['email'];
               $v->userAuth_type = $user['type_person'];
               $v->userAuth = true;
          } else {
                $v->userAuth_name = '';
                $v->userAuth_email = '';
                $v->userAuth_type = '';
                $v->userAuth = false;
            }
          
           if(!isset($portfolioData['id'])) {
                $v->userData = ProfileModel::Instance()->getUserDate($p_page);
                $v->portfolioData = $lang_portfolio['page_portfolio_error'];
                $v->title = $v->userData['name'].' '.$v->userData['lastname'];
                $v->description = '';
                $v->keywords = '';
                $v->og_img = $v->userData['user_img'];
           } else {
                $v->portfolioData = $portfolioData;
                $v->title = $v->portfolioData['name'].' '.$v->portfolioData['lastname'];
                $v->description = $v->portfolioData['about'];
                $v->keywords = '';
                $v->og_img = $v->portfolioData['portfolio_img'];
               $v->portfolioData_computer = PortfolioModel::Instance()->GetUserPortfolio_computer($v->portfolioData['id_user']);
               $portfolioData_educations = PortfolioModel::Instance()->GetUserPortfolio_educations($v->portfolioData['id_user']);
               $v->portfolioData_educations = $portfolioData_educations;
               $v->portfolioData_languages = PortfolioModel::Instance()->GetUserPortfolio_languages($v->portfolioData['id_user']);
               $v->portfolioData_work_post = PortfolioModel::Instance()->GetUserPortfolio_work_post($v->portfolioData['id_user']);
               $v->patent = unserialize($v->portfolioData['patent']);
               
               $userAssests = unserialize($v->portfolioData['assests']);
               $userInterests = unserialize($v->portfolioData['interests']);
               $userHobbi = unserialize($v->portfolioData['hobbi']);
               
               $education = '';
               foreach($portfolioData_educations as $pe) {
                    $education .= $pe['specialty'].', ';
               }
               $v->education_text_header = $education;
               
               $nameAssests = array();
               if(!empty($userAssests)) {
                   foreach ($userAssests as $ua) {
                       $nameAssests[] = PortfolioModel::Instance()->GetNameAssests($ua);
                   }
               }
               $v->nameAssests = $nameAssests;
               
               $nameHobbi = array();
               if(!empty($userHobbi)) {
                   foreach ($userHobbi as $uh) {
                       $nameHobbi[] = PortfolioModel::Instance()->GetNameHobbi($uh);
                   }
               }
               $v->nameHobbi = $nameHobbi;
               
               $nameInterests = array();
               if(!empty($userInterests)) {
                   foreach ($userInterests as $ui) {
                       $nameInterests[] = PortfolioModel::Instance()->GetNameInterests($ui);
                   }
               }
               $v->nameInterests = $nameInterests;
           }
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_printpdf () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
            
            $u_data = AuthClass::instance()->getUser();
            //if($u_data['type_person'] == '4') $this->redirect(Url::local('profile'));
            if($u_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            
			$user_portfolio = $this->lang('portfolio');
            $p_user = Router::getUriParam(2);
            $portfolioData = PortfolioModel::Instance()->GetUserPortfolio($p_user);
            
            if ($portfolioData['search_status'] == '0') {
                $portfolioData_computer = PortfolioModel::Instance()->GetUserPortfolio_computer($portfolioData['id_user']);
                $portfolioData_educations = PortfolioModel::Instance()->GetUserPortfolio_educations($portfolioData['id_user']);
                $portfolioData_languages = PortfolioModel::Instance()->GetUserPortfolio_languages($portfolioData['id_user']);
                $portfolioData_work_post = PortfolioModel::Instance()->GetUserPortfolio_work_post($portfolioData['id_user']);
                
                $data['title'] = '#'.$u_data['login'];
                $data['description'] = substr($portfolioData['about'], 0, 100).' ...';
                $data['keywords'] = '';
                $portfolioData['about'] = htmlspecialchars_decode($portfolioData['about']);
                $about = substr($portfolioData['about'], 0, 200)."… ";
                $portfolioData['patent'] = unserialize($portfolioData['patent']);
                //echo'<pre>'; print_r($portfolioData); echo '</pre>';
                $userAssests = unserialize($portfolioData['assests']);
                $userInterests = unserialize($portfolioData['interests']);
                $userHobbi = unserialize($portfolioData['hobbi']);
                
                if(!empty($userAssests)) {
                    foreach ($userAssests as $v) {
                        $data['nameAssests'][] = PortfolioModel::Instance()->GetNameAssests($v);
                    }
                }
                
                if(!empty($userHobbi)) {
                    foreach ($userHobbi as $v) {
                        $data['nameHobbi'][] = PortfolioModel::Instance()->GetNameHobbi($v);
                    }
                }
                
                if(!empty($userInterests)) {
                    foreach ($userInterests as $v) {
                        $data['nameInterests'][] = PortfolioModel::Instance()->GetNameInterests($v);
                    }
                }
                
                $portfolioData_docs = PortfolioModel::Instance()->GetDocumentsForPortfolio($u_data['u_id']);
            } else {
                $html = $user_portfolio['portfolio_off'];
            }
            
            require_once DOCROOT.'Helpers/phpqrcode/qrlib.php';
            require_once DOCROOT.'Helpers/phpqrcode/qrconfig.php';
            require_once DOCROOT.'Helpers/dompdf/vendor/autoload.php';
            
            $dompdf = new Dompdf\Dompdf();
            $dompdf->set_option('defaultFont', 'dejavu sans');
            $dompdf->set_option('isRemoteEnabled', TRUE);
            $dompdf->setPaper('A4', 'portrait');
            // how to build raw content - QRCode to send email, with extras
            $tempDir = 'Media/images/users/'.$u_data['u_id'].'/';
            
            // here our data
            $email = $portfolioData['email'];
            $subject = 'Curriculum';
            $body = 'Hello, dear '.$portfolioData['name'].' '.$portfolioData['lastname'].'. Your resume is of interest to us!';
            
            // we building raw data
            $codeContents = 'mailto:'.$email.'?subject='.urlencode($subject).'&body='.urlencode($body);
            
            // generating
            QRcode::png($codeContents, $tempDir.'qr_user_email.png', QR_ECLEVEL_H, 3);
            QRcode::png(SITE.'/portfolio/user/'.$p_user, 'Media/images/users/'.$u_data['u_id'].'/qr_user.png', QR_ECLEVEL_M, 3);
            // displaying
            $qr_img_email = '<img src="'.SITE.'/'.$tempDir.'qr_user_email.png" />';
            $qr_img = '<img src="'.SITE.'/'.$tempDir.'qr_user.png" />';

            $marital_status = ($portfolioData['marital_status'] == '0')?$user_portfolio['marital_status_no']:$user_portfolio['acc_is_married'];
            $doc = htmlspecialchars_decode($portfolioData['document'], ENT_QUOTES);
            $user_photo = ($portfolioData['portfolio_img'] == '')?$u_data['user_img']:$portfolioData['portfolio_img'];
            
            $patent = '';
            if($portfolioData['patent'] != 'non_patent') {
                foreach($portfolioData['patent'] as $p) {
                    if($p == '1') $patent .= $user_portfolio['page_portfolio_transport'].', ';
                    else $patent .= $p.', ';
                }
                $patent = substr($patent, 0, -2);
                 
                $user_portfolio['page_portfolio_patent'].': '.$patent;
            }
            $user_portfolio['page_portfolio_adresResident'].': '.$portfolioData['adresResident'];
            
            if (!empty($portfolioData_educations)) {
                $educations = '';
                foreach($portfolioData_educations as $e) {
                    $educations .= '
                        <div class="position-relative mb-4">
                            <img class="text-primary position-absolute" style="top: 3px; left: -33px;" src="https://img.icons8.com/ultraviolet/16/000000/circled-dot.png"/>
                            <h5 class="font-weight-bold mb-1">'.htmlspecialchars_decode($e['educational_institution']).'</h5>
                            <p class="mb-2">'.$e['specialty'].'</p>
                        </div>
                    ';
                }
            }
            
            $languages = "";            
            if (!empty($portfolioData_languages)) {
                $lang_lavel = array(
                    '3' => strtolower($user_portfolio['acc_perfect']),
                    '2' => strtolower($user_portfolio['acc_good']),
                    '1' => strtolower($user_portfolio['acc_bad'])
                );
                foreach($portfolioData_languages as $l) {
                    $languages .= '
                    <div class="position-relative mb-4">
                        <img class="text-primary position-absolute" style="top: 3px; left: -33px;" src="https://img.icons8.com/ultraviolet/16/000000/circled-dot.png"/>
                        <h5 class="mb-1">'.$l['title_lang'].' ('.$user_portfolio['acc_letter'].' '.$lang_lavel[$l['level_dialog']].', '.$user_portfolio['acc_read'].' '.$lang_lavel[$l['level_read']].', '.$user_portfolio['acc_dialog'].' '.$lang_lavel[$l['level_dialog']].')</h5>
                    </div>
                    ';
                }
            }
            
            if (!empty($portfolioData_computer)) {
                $computer = '';
                foreach($portfolioData_computer as $c) {
                    $computer .= '
                        <div class="position-relative mb-4">
                            <img class="text-primary position-absolute" style="top: 3px; left: -33px;" src="https://img.icons8.com/ultraviolet/16/000000/circled-dot.png"/>
                            <h5 class="font-weight-bold mb-1">'.$c['title_lang_computer'].'</h5>
                        </div>
                    ';
                }
                $computer = substr($computer, 0, -2);
            }
            
            if (!empty($portfolioData_work_post)) {
                $work_post = '';
                foreach ($portfolioData_work_post as $wp) {
                    $end_wd = ($wp['end_date'] == '0')?'Ancora lavoro':$wp['end_date'];
                    $work_post .= '
                        <div class="position-relative mb-4">
                            <img class="text-primary position-absolute" style="top: 3px; left: -33px;" src="https://img.icons8.com/ultraviolet/16/000000/circled-dot.png"/>
                            <h5 class="font-weight-bold mb-1">'.$wp['experience'].'</h5>
                            <p class="mb-2">'.htmlspecialchars_decode($wp['work_post']).' | <small>'.$wp['date_of_the_beginning'].' - '.$end_wd.'</small></p>
                        </div>
                    ';
                }
            }
            
            if (!empty($data['nameHobbi'])) {
                $user_portfolio['page_portfolio_nameHobbi'];
                $hobbi = '';
                
                foreach ($data['nameHobbi'] as $h) {
                    foreach ($h as $h_name) $hobbi .= $h_name['name'].', ';
                }
                $hobbi = substr($hobbi, 0, -2);
            }
            
            if (!empty($data['nameAssests'])) {
                $user_portfolio['page_portfolio_nameAssests'];
                $nameAssests = '';
                foreach ($data['nameAssests'] as $a) {
                    foreach($a as $a_name) $nameAssests .= htmlspecialchars_decode($a_name['name'], ENT_QUOTES).', ';
                }
                $nameAssests = substr($nameAssests, 0, -2);
            }
            
            if (!empty($data['nameInterests'])) {
                $user_portfolio['interests'];
                $nameInterests = '';
                foreach ($data['nameInterests'] as $i) {
                    foreach($i as $i_name) $nameInterests .= htmlspecialchars_decode($i_name['name'], ENT_QUOTES).', ';
                }
                $nameInterests = substr($nameInterests, 0, -2);
            }
            
            if(!empty($portfolioData_docs)) {
                $documents = '';
                foreach($portfolioData_docs as $pd) {
                    $documents .= '<div class="documents"><img src="'.SITE.'/'.$pd['doc_url'].'" width="841" heght="1189" /></div>';
                }
            }
            
            
            $lang_defaultpl = $this->lang('defaultportfoliotpl');
            
            $replace = array(
                '{user_logo}' => SITE.'/'.$user_photo,
                '{user_name}' => $portfolioData['name'].' '.$portfolioData['lastname'],
                '{nacional}' => $portfolioData['nacional'],
                '{email}' => $portfolioData['email'],
                '{mobile}' => $portfolioData['mobile'],
                '{adresResident}' => $portfolioData['adresResident'],
                '{patent}' => $patent,
                '{material_status}' => $marital_status,
                '{about_user}' => $portfolioData['about'],
                '{qr_email}' => $qr_img_email,
                '{qr_cv}' => $qr_img,
                '{page_portfolio_portfolio_educations}' => $user_portfolio['page_portfolio_portfolio_educations'],
                '{page_portfolio_portfolio_languages}' => $user_portfolio['page_portfolio_portfolio_languages'],
                '{language}' => $languages,
                '{page_portfolio_portfolio_educations}' => $user_portfolio['page_portfolio_portfolio_educations'],
                '{education}' => $educations,
                '{page_portfolio_portfolio_computer}' => $user_portfolio['page_portfolio_portfolio_computer'],
                '{computer}' => $computer,
                '{page_portfolio_portfolio_work_post}' => $user_portfolio['page_portfolio_portfolio_work_post'],
                '{work_post}' => $work_post,
                '{documents}' => $documents
            );
            
            $portfolio_tpl = str_replace(array_keys($replace), array_values($replace), $lang_defaultpl['defaulttpl']);

            $dompdf->loadHTML($portfolio_tpl, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('Curriculum_'.$portfolioData['lastname'], ['Attachment' => 0]);
        }
	}
?>