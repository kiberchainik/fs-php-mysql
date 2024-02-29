<?php
	class NewadvertController extends Controller {
	   public function action_index() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           $userDate = AuthClass::instance()->getUser();
           if($userDate['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           
           $v = new View('account/new_advert');
           $lang_advert = $this->lang('adverts');
           $v->userDate = $userDate;
           
           $v->title = $lang_advert['newadvert_title'];
           $v->description = '';
           $v->keywords = '';
           $v->og_img = '';
           $v->text_select = $lang_advert['select'];
           $v->text_newadvert_title_advert = $lang_advert['newadvert_title_advert'];
           $v->text_newadvert_seo = $lang_advert['newadvert_seo'];
           $v->text_newadvert_keywords = $lang_advert['newadvert_keywords'];
           $v->text_newadvert_description = $lang_advert['newadvert_description'];
           $v->text_newadvert_fulltextAdvert = $lang_advert['newadvert_fulltextAdvert'];
           $v->text_newadvert_type = $lang_advert['newadvert_type'];
           $v->text_newadvert_comments_permise = $lang_advert['newadvert_comments_permise'];
           $v->text_images_advert = $lang_advert['newadvert_images_advert'];
           $v->text_typeAdvert = $lang_advert['newadvert_typeAdvert'];
           $v->text_save = $lang_advert['save'];
           $v->text_select_branch = $lang_advert['newadvert_select_branch'];
           $v->text_yes = $lang_advert['newadvert_yes'];
           $v->text_no = $lang_advert['newadvert_no'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $v->branch_default = BranchModel::Instance()->branchSelect($userDate['u_id']);
           $v->filialList = BranchModel::Instance()->getListBranchForUser($userDate['u_id']);
           
           $v->categoryList = NewadvertModel::Instance()->GetCategoryListWithoutParetnId();
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_subcategory () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           header('Content-type: application/json');
            $type_list = NewadvertModel::Instance()->ParentSubCategoryList($this->post('id_cat'), $this->post('lang'));
            echo json_encode($type_list);
       }
       
       public function action_typesOfCategory () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           header('Content-type: application/json');
            $type_list = NewadvertModel::Instance()->TypesOfCategoryList($this->post('id_cat'), $this->post('lang'));
            echo json_encode($type_list);
       }
       
       public function action_getFieldsCategoryList () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
            
            $lang_advert = $this->lang('adverts');
            $text_yes = $lang_advert['newadvert_yes'];
            $text_no = $lang_advert['newadvert_no'];
            
            header('Content-type: application/json');
            $type_list = NewadvertModel::Instance()->getFieldsListForAdd($this->post('id_cat'), $this->post('id_type'), $this->post('lang'));
            
            foreach($type_list as $k => $fields) {
                $value = NewadvertModel::Instance()->getFieldValues($fields['id'], $this->post('lang'));
                if(!empty($value)) {
                    if($fields['name'] == 'test_drive') {
                        foreach($value as $k_td => $td){
                            $type_list[$k]['field_value'][$k_td]['value'] = ($td['value'] == '0')?$text_no:$text_yes;
                        }
                    } else $type_list[$k]['field_value'] = $value;
                } else $type_list[$k]['field_value'] = '';
            }
            
            /*echo'<pre>';
            print_r($type_list);
            echo '</pre>';*/
            echo json_encode($type_list);
        }
        
        public function action_getFieldsCategoryListEdit () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
           
            $lang_advert = $this->lang('adverts');
            $text_yes = $lang_advert['newadvert_yes'];
            $text_no = $lang_advert['newadvert_no'];
           
            if (isset($_POST['id_cat'])) {
                header('Content-type: application/json');
                $type_list = $this->secureDataDecode(NewadvertModel::Instance()->getFieldsListForEdit($this->post('id_cat'), $this->post('id_type'), $this->post('id_adv'), $this->post('lang')));
                
                foreach($type_list as $k => $fields) {
                    $value = NewadvertModel::Instance()->getFieldValues($fields['id'], $this->post('lang'));
                    if(!empty($value)) {
                        if($fields['name'] == 'test_drive') {
                            foreach($value as $k_td => $td){
                                $type_list[$k]['field_value'][$k_td]['value'] = ($td['value'] == '0')?$text_no:$text_yes;
                            }
                        } else $type_list[$k]['field_value'] = $value;
                    }
                }
                
                echo json_encode($type_list);
            }
        }
        
        private function secureDataDecode ($data) {
        	if (is_array($data)) {
        		foreach ($data as $key => $value) {
        			$data[$this->secureDataDecode($key)] = $this->secureDataDecode($value);
        		}
        	} else {
                $data = htmlspecialchars_decode($data, ENT_QUOTES);
        	}
            return $data;
        }
        
        public function action_addNewAdvert () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
            
            $profile_data = AuthClass::instance()->getUser();
            if($profile_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           
            $lang_newadvert = $this->lang('adverts');
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            $advert = array();
            
            $filialCount = BranchModel::Instance()->countBranchOfUser($profile_data['u_id']);
            if($filialCount['numCount'] != '0') {
                if($this->post('filial_avdert') == '0') $msg['errors']['empty_branch'] = 'select filial';
                else $advert['data']['id_filial'] = $this->post('filial_avdert');
            }
            
            if(!$this->post('title')) {
                $msg['errors']['title'] = $lang_newadvert['newadvert_add_error_empty_title'];
            } else {
                $advert['data']['title'] = str_replace('/', '_', $this->post('title'));
                
                $ifTitleExist = AdvertsModel::Instance()->ifTitleExist($this->post('title'));
                if($ifTitleExist['numCount'] > 0) $msg['errors']['title'] = $lang_newadvert['newadvert_this_title_exist'];
                
                if (HTMLHelper::isRuLetters($this->post('title'))) {
                    $title = strtr($advert['data']['title'], array(' ' => '_'));
                    $advert['data']['seo'] = mb_strtolower(HTMLHelper::TranslistLetterRU_EN($title));
                } else $advert['data']['seo'] = strtr($advert['data']['title'], array(' ' => '_', '€' => '', '&' => '', '$' => '', '#' => '', '*' => ''));
            }
            
            if(!$this->post('keywords')) $msg['errors']['keywords'] = $lang_newadvert['newadvert_add_error_empty_keywords'];
            else $advert['data']['keywords'] = $this->post('keywords');
            
            if($this->post('category') == '0' or $this->post('subCategory') == '0') {
                $msg['errors']['category'] = $lang_newadvert['newadvert_add_error_empty_category'];
            } else {
                $advert['mainCategory'] = $this->post('category');
                $advert['subCategory'] = $this->post('subCategory');
            }
            
            if($this->post('typeCategory')) {
                if($this->post('typeCategory') == '0') $msg['errors']['typeCategory'] = $lang_newadvert['newadvert_add_error_empty_type'];
                else $advert['data']['id_type'] = $this->post('typeCategory');
            }
            
            if(!$this->post('description')) $msg['errors']['description'] = $lang_newadvert['newadvert_add_error_empty_description'];
            else $advert['data']['description'] = $this->post('description');
            
            $advert['data']['comments_permission'] = (!$this->post('comments'))?'yes':$this->post('comments');
            if(!$this->post('fullTextAdvert')) $msg['errors']['fullTextAdvert'] = $lang_newadvert['newadvert_add_error_empty_fulltext'];
            else $advert['data']['textAdvert'] = $this->post('fullTextAdvert');
            
            if(!isset($_FILES['images_advert']) or empty($_FILES['images_advert']['name'][0])) $msg['errors']['images_advert'] = $lang_newadvert['newadvert_add_empty_images_advert'];
            else {
                foreach ($_FILES['images_advert']['name'] as $k=>$v) {
                    if($_FILES['images_advert']['type'][$k] == "image/gif" || $_FILES['images_advert']['type'][$k] == "image/png" ||
                    	$_FILES['images_advert']['type'][$k] == "image/jpg" || $_FILES['images_advert']['type'][$k] == "image/jpeg") {
                        $blacklist = array(".php", ".phtml", ".php3", ".php4");

                        foreach ($blacklist as $item) {
                            if(preg_match("/$item\$/i", $_FILES['images_advert']['name'][$k])) {
                                $msg['errors']['images_advert'] = 'Error: file <b>'.$_FILES['images_advert']['name'][$k].'</b> in the black list';
                            }
                        }
                    } else $msg['errors']['images_advert'] = 'Error: file <b>'.$_FILES['images_advert']['name'][$k].'</b> is error format';
                }
            }
            
            // Проходим по массиву
            foreach ($_POST as $key => $value) {
                unset($_POST[$key]);               // Удаляем элемент...
                if ($key == 'fullTextAdvert') {   // Но если ключ равен fullTextAdvert, то прекращаем
                    break;
                }
            }
            
            $advert['data']['idUser'] = $profile_data['u_id'];
            $advert['data']['add_date'] = time();
            //$advert['data']['marker'] = ($this->post('as_promo'))?$this->post('as_promo'):'';
            
            if (empty($msg['errors'])) {
                $last_id = NewadvertModel::Instance()->addAdverts($advert);
                
                if(!$last_id) $msg['errors']['other_error'] = $lang_newadvert['newadvert_error_added'];
                else {
                    $advert['imgs'] = UploadHelper::UploadMoreImages($_FILES['images_advert'], 'adverts/'.$last_id);
                    //if(isset($_FILES['cover_image'])) $advert['imgs']['cover'] = UploadHelper::UploadOneImage($_FILES['images_advert'], 'adverts/cover/'.$last_id);
                    NewadvertModel::Instance()->updAdvertImgs($advert['imgs'], $last_id);
					
                    $id_field = '';
                    if(isset($_POST['id_fields_group'])) {
					   //var_dump($_POST);
                        foreach($_POST as $k => $v) {
                            $k = trim(htmlspecialchars($k, ENT_COMPAT, 'UTF-8'));
                            $v = trim(htmlspecialchars($v, ENT_COMPAT, 'UTF-8'));
                            
                            if (strpos($k, '_id') !== false) $id_field = $v;
                            else {
                                //if (strpos($v, '_') !== false) $data_v = explode('_', $v);
                                $fields[] = array(
                                    'field_name' => $k,
                                    'field_value' => $v,
                                    'id_advert' => $last_id,
                                    'id_field_group' => $this->post('id_fields_group'),
                                    'id_field' => $id_field
                                );
                            }
                            unset($data_v);
                        }
                        
                        NewadvertModel::Instance()->addAdvertFields($fields);
					}
                    /*echo'<pre>';
                    print_r($fields);
                    echo '</pre>';*/
                    $msg['success'][] = $lang_newadvert['newadvert_added_success'];
                }
            }
            
            echo json_encode($msg);
        }
    }
?>