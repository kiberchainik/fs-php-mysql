<?php
    class BranchController extends Controller {
        public function action_index () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $v = new View('account/branch');
            $v->branchList = BranchModel::Instance()->getListBranchForUser($u_data['u_id']);
            $lang_branch = $this->lang('branch');
            
            $v->title = $lang_branch['title'];
            $v->description = '';
            $v->keywords = '';
            $v->og_img = '';
            
            $v->header = $this->module('Header');
            $v->profilemenu = $this->module('ProfileMenu');
            $v->footer = $this->module('Footer');
            
            $v->text_non_branch = $lang_branch['non_branch'];
            $v->text_add_new = $lang_branch['add_new'];
            $v->text_title_branch_block = $lang_branch['edit_branch'];
            $v->text_save_edit = $lang_branch['save_edit'];
            /*$v->text_delete = $lang_branch['delete'];
            $v->text_more = $lang_branch['more'];
            $v->text_vacance_status = $lang_branch['vacance_status'];
            $v->text_valid_status_no = $lang_branch['valid_status_no'];
            $v->text_valid_status_yes = $lang_branch['valid_status_yes'];*/
            $v->text_name_company = $lang_branch['name_company'];
            $v->text_address = $lang_branch['address'];
            $v->text_phone = $lang_branch['phone'];
            $v->text_email = $lang_branch['email'];
            $v->text_url_company = $lang_branch['url_company'];
            $v->text_img = $lang_branch['img'];
            //$v->text_'] = $branch[''];
            
            /*echo '<pre>';
            print_r($data['userDate']);
            echo'</pre>';*/
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_vacancie () {
            $v = new View('site/vacancieslist');
           $lang_vacance = $this->lang('branch');
           
           $v->title = $lang_vacance['title'];
           $v->description = $lang_vacance['description'];
           $v->og_img = '';
           $v->keywords = '';
           $v->text_read_more = '';
           $v->text_category_vacancies = '';
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           
           $v->vacanciesCategoriList = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory();
           $v->companylist = VacanciesModel::Instance()->getListCompany();
           
           $v->id_company = Router::getUriParam(2);
           $v->id_branch = Router::getUriParam(3);
           
           $page = (int)Router::getUriParam('page');
           $count = VacanciesModel::Instance()->getVacanciesOfBranchCount($v->id_branch, 8);
           if($page < 1 or $page > $count) Url::local('404');
           $v->vacanciesList = VacanciesModel::Instance()->getVacanciesOfBranchPage($page, $v->id_branch, 8, '');
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('branch/vacancie/'.$v->id_company.'/'.$v->id_branch));
           
           $v->tottal = VacanciesModel::Instance()->getTottalVacanciesOfBranchCount($v->id_branch);
           
           $name_company = CompanyModel::Instance()->selectNameCompany($v->id_company);
           $name_filial = BranchModel::Instance()->selectNameFilial($v->id_branch);
           BreadHelper::add('/vacancies/', 'Offerte di lavoro');
           BreadHelper::add('/company/page/'.$v->id_company, $name_company['company_name']);
           BreadHelper::add('/branch/vacancie/'.$v->id_company.'/'.$v->id_branch, $name_filial[0]['name_company']);
           $v->breadcrumb = BreadHelper::out();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_NewBranch () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $lang_branch = $this->lang('branch');
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            if (!$this->post('name_company')) $msg['errors'][] = $lang_branch['empty_name_company'];
            if (!$this->post('address')) $msg['errors'][] = $lang_branch['empty_address'];
            if (!$this->post('phone')) $msg['errors'][] = $lang_branch['empty_mobile'];
            if (!$this->post('email')) $msg['errors'][] = $lang_branch['empty_email'];
            
            if (!empty($post['url_company'])) {
                if(!HTMLHelper::validLinks($this->post('url_company'))) $errors[] = $lang_branch['error_url_company'];
            }
            
            if(isset($_FILES['img']) and !empty($_FILES['img']['name'])) {
                $avatar = UploadHelper::UploadOneImage(ValidOneImage($_FILES['img'], 'users/'.$u_data['u_id'].'/branch'));
            } else {
                $avatar = $u_data['user_img'];
            }
            
            $newBranch = array(
                'id_user' => $u_data['u_id'],
                'name_company' => $this->post('name_company'),
                'adres' => $this->post('address'),
                'phone' => $this->post('phone'),
                'email' => $this->post('email'),
                'url_company' => $u_data['company_link'],
                'img' => $avatar
            );
            
            if(empty($msg['errors'])) {
                BranchModel::Instance()->newBranch($newBranch);
                $msg['success'] = $lang_branch['added'];
            }
             
            echo json_encode($msg);
        }
        
        public function action_edit () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            $id = Router::getUriParam(2);
            $lang_branch = $this->lang('branch');            
            
            if (!$this->post('name_company')) $msg['errors'][] = $lang_branch['empty_name_company'];
            if (!$this->post('address')) $msg['errors'][] = $lang_branch['empty_address'];
            if (!$this->post('phone')) $msg['errors'][] = $lang_branch['empty_mobile'];
            if (!$this->post('email')) $msg['errors'][] = $lang_branch['empty_email'];
                
            if (!empty($_POST['url_company'])) {
                if(!HTMLHelper::validLinks($this->post('url_company'))) $errors[] = $lang_branch['error_url_company'];
                else $url_filial = $this->post('url_company');
            } else $url_filial = $u_data['company_link'];
                
            $logoBranch = BranchModel::Instance()->getLogoBranch($id);
            if(isset($_FILES['img']) and !empty($_FILES['img']['name'])) {
                if (file_exists($logoBranch['img'])) unlink($logoBranch['img']);
                $newLogo = UploadHelper::UploadOneImage(ValidOneImage($_FILES['img'], 'users/'.$u_data['u_id'].'/branch'));
            } else {
                $newLogo = $logoBranch['img'];
            }

                $Branch = array(
                    'id' => $id,
                    'id_user' => $u_data['u_id'],
                    'name_company' => $this->post('name_company'),
                    'adres' => $this->post('address'),
                    'phone' => $this->post('phone'),
                    'email' => $this->post('email'),
                    'url_company' => $url_filial,
                    'img' => $newLogo
                );
                
                if(empty($msg['errors'])) {
                    BranchModel::Instance()->UpdBranch($Branch);
                    $msg['success'] = $lang_branch['added'];
                }

                echo json_encode($msg);
        }
        
        public function action_delete () {
            if(!AuthClass::instance()->isAuth()) $this->redirect(Url::local(''));
           
            $u_data = AuthClass::instance()->getUser();
            if($u_data['type_person'] != '4') $this->redirect(Url::local('profile'));
            $id = Router::getUriParam(2);
            BranchModel::Instance()->deleteBranch($id);
            
            $this->redirect(Url::local('branch'));
        }
	}
?>