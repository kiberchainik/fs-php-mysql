<?php
	class AdvertsController extends Controller {
	   public function action_index() {
           $this->redirect(Url::local('category'));
	   }
       
       public function action_page(){
           $v = new View('site/adverts');
           $lang_advert = $this->lang('adverts');
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->text_adverttype = $lang_advert['newadvert_typeAdvert'];
           $v->text_saved = $lang_advert['save_advert_for_user'];
           
           $p_page = Router::getUriParam(2);
           $p_page = urldecode($p_page);
           //$p_page = str_replace('%C3%A0', 'à', $p_page);
           if(empty($p_page)) {
                $v->advertData = 'Advert dont exists!';
           } else {
                $advertData = AdvertsModel::Instance()->getAdvertDataForView($p_page);
                //echo'<pre>'; var_dump($advertData); echo'</pre>';
                $v->ListImagesAdvert = AdvertsModel::Instance()->getListImagesAdvert($advertData['id']);
                $fieldsAdvert = AdvertsModel::Instance()->getFieldsForAdvert($advertData['id']);
                
                $v->commentsAdvert = $this->module('Comments', $advertData['id']);

                if(!empty($v->ListImagesAdvert['list']))$v->og_img = $v->ListImagesAdvert['list'][0]['src'];
                
                $v->title = $advertData['title'];
                $v->description = $advertData['description'];
                $v->keywords = $advertData['keywords'];
                
                if($advertData['id_filial'] !== NULL) {
                    $advertData['email'] = $advertData['filial_email'];
                    $advertData['company_name'] = $advertData['filial_name'];
                    $advertData['company_link'] = $advertData['filial_url_company'];
                    $advertData['mobile'] = $advertData['filial_phone'];
                    $advertData['address'] = $advertData['filial_address'];
                    $advertData['user_img'] = $advertData['filial_img'];
                }
                
                $v->auth = false;
                $checkBox = array();
                if ($advertData['type_person'] == '4') $v->link = '/company/page/';
                if ($advertData['type_person'] == '5') $v->link = '/users/page/';
                
                if(AuthClass::instance()->isAuth()) {
                    $v->auth = true;
                    $v->u_id = AuthClass::instance()->getUser();
                    
                    if($v->u_id['u_id'] != $advertData['idUser']) {
                        $advertData['views'] += 1;
                    }
                    $v->status_saved = AdvertsModel::Instance()->statusSavedAdvert($v->u_id['u_id'], $advertData['id']);
                } else $advertData['views'] += 1;
                
                AdvertsModel::Instance()->UpdViewsAdvert($advertData['views'], $advertData['id']);
                
                foreach ($fieldsAdvert as $k => $r) {
                    if ($r['field_name'] == 'id_fields_group') unset($fieldsAdvert[$k]);
                    if ($r['field_name'] == 'google_map') {
                        $v->map = $fieldsAdvert[$k]['field_value'];
                        unset($fieldsAdvert[$k]);
                    }
                    
                    if ($r['field_name'] == 'test_drive') {
                        $v->test_drive = $fieldsAdvert[$k]['f_value'];
                        unset($fieldsAdvert[$k]);
                    }
                    
                    if($r['type'] == 'select' or $r['type'] == 'radio') {
                        $fieldsAdvert[$k]['field_value'] = $fieldsAdvert[$k]['f_value'];
                        //unset($fieldsAdvert[$k]['f_value']);
                    }
                    
                    if($r['f_value'] == '' and $r['field_value'] == '') {
                        unset($fieldsAdvert[$k]);
                    }
                    
                    if($r['type'] == 'select' and $r['f_value'] == '') {
                        unset($fieldsAdvert[$k]);
                    }
                    
                    if ($r['type'] == 'checkBox' and !empty($r['field_value'])) {
                        //$checkBox['field_value'] = explode(',', $r['field_value']);
                        $checkBox['placeholder'] = $r['placeholder'];
                        unset($fieldsAdvert[$k]);
                    }
                }
                
                
                $v->typesOfAdvert = AdvertsModel::Instance()->getTypeOfAdvert($advertData['id_type'], $advertData['id']);
                $v->advertData = $advertData;
                $v->fieldsAdvert = $fieldsAdvert;
                $v->checkBox = $checkBox;
           }
           //$p_page = str_replace('%C3%A0', 'à', $p_page);
           /*echo"<pre>";
           print_r($advertData);
           echo '</pre>';*/
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_edit() {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           $u_date = AuthClass::instance()->getUser();
           $v = new View('account/editadvert');
           $lang_advert = $this->lang('editadvert');
           
           $v->title = $lang_advert['newadvert_title'];
           $v->description = '';
           $v->text_select = $lang_advert['select'];
           $v->text_title = $lang_advert['newadvert_title_advert'];
           $v->text_seo = $lang_advert['newadvert_seo'];
           $v->text_keywords = $lang_advert['newadvert_keywords'];
           $v->text_description = $lang_advert['newadvert_description'];
           $v->text_fulltextAdvert = $lang_advert['newadvert_fulltextAdvert'];
           $v->text_newadvert_type = $lang_advert['newadvert_type'];
           $v->text_comments = $lang_advert['newadvert_comments_permise'];
           $v->text_images_advert = $lang_advert['newadvert_images_advert'];
           $v->text_type = $lang_advert['newadvert_type'];
           $v->text_typeAdvert = $lang_advert['newadvert_typeAdvert'];
           $v->text_save = $lang_advert['save'];
           $v->text_delete = $lang_advert['delete'];
           $v->text_select_branch = $lang_advert['newadvert_select_branch'];
           $text_yes = $lang_advert['newadvert_yes'];
           $text_no = $lang_advert['newadvert_no'];
           
           $p_page = Router::getUriParam(2);
           $AdvertData = AdvertsModel::Instance()->getAdvertDataForView($p_page);
           if(empty($AdvertData) or $AdvertData['idUser'] != $u_date['u_id']) {
                $this->redirect('/profile');
           } else {
                $v->filialList = BranchModel::Instance()->getListBranch($u_date['u_id']);
                
                $listImgs = AdvertsModel::Instance()->getListImagesAdvert($p_page);
                $AdvertData['imgs'] = $listImgs['list'];
                
                //$AdvertData['fieldsAdvert'] = AdvertsModel::Instance()->getFieldsForAdvert($p_page);
                $data['TypesOfAdvert'] = TypeAdvertsModel::Instance()->TypesOfCategoryList($p_page, $_SESSION['lid']);
                $CategoryAdvert = CategoryModel::Instance()->getCategoryesForAdvert($p_page);
                $AdvertData['mainCategory'] = $CategoryAdvert['mainCategory']['id_category'];
                $AdvertData['subCategory'] = $CategoryAdvert['subCategory'];
                
                $subSelects = array();
                $i = 0;           
                foreach ($AdvertData['subCategory'] as $k => $val) {
                    $i++;
                    $subSelects[$i] = CategoryModel::Instance()->Selects($val['parent_id'], $val['id_category']);
                    $subSelects[$i]['parent'] = $val['parent_id'];
                }
                /*echo '<pre>';
                print_r($AdvertData);
                print_r($subSelects);
                echo '</pre>';*/
                $v->AdvertData = $AdvertData;
                $v->subSelects = $subSelects;
                $v->CategoryList = CategoryModel::Instance()->GetCategoryListWithoutParetnId();
                $v->fieldsAdvert = AdvertsModel::Instance()->getFieldsForAdvert($v->advertData['id']);
           }
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_saveedit () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
            
            $profile_data = AuthClass::instance()->getUser();
            if($profile_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           $p_page = Router::getUriParam(2);
           $AdvertData = AdvertsModel::Instance()->getAdvertDataForView($p_page);
           $lang_advert = $this->lang('editadvert');
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            $advert = array();
            
            if($AdvertData['idUser'] != $profile_data['u_id']) $this->redirect('/profile');
            
            $advert['data']['id'] = $p_page;
            
            $filialCount = BranchModel::Instance()->countBranchOfUser($profile_data['u_id']);
            if($filialCount['numCount'] != '0') {
                if($this->post('filial_avdert') == '0') $msg['errors']['empty_branch'] = 'select filial';
                else $advert['data']['id_filial'] = $this->post('filial_avdert');
            }
            
            if(!$this->post('title')) {
                $msg['errors']['title'] = $lang_advert['newadvert_add_error_empty_title'];
            } elseif($this->post('title') != $AdvertData['title']) {
                $advert['data']['title'] = str_replace('/', '-', $this->post('title'));
                
                $ifTitleExist = AdvertsModel::Instance()->ifTitleExist($this->post('title'));
                if($ifTitleExist['numCount'] > 0) $msg['errors']['title'] = $lang_advert['newadvert_this_title_exist'];
                
                if (HTMLHelper::isRuLetters($this->post('title'))) {
                    $title = strtr($advert['data']['title'], array(' ' => '_', '&' => '_'));
                    $advert['data']['seo'] = HTMLHelper::TranslistLetterRU_EN($title);
                } else $advert['data']['seo'] = strtr($advert['data']['title'], array(' ' => '_', '&' => '_'));
            }
            
            if(!$this->post('keywords')) $msg['errors']['keywords'] = $lang_advert['newadvert_add_error_empty_keywords'];
            else $advert['data']['keywords'] = $this->post('keywords');
            
            if($this->post('category') == '0' or $this->post('subCategory') == '0') {
                $msg['errors']['category'] = $lang_advert['newadvert_add_error_empty_category'];
            } else {
                $advert['mainCategory'] = $this->post('category');
                $advert['subCategory'] = $this->post('subCategory');
            }

            
            if($this->post('typeCategory')) {
                if($this->post('typeCategory') == '0') $msg['errors']['typeCategory'] = $lang_advert['newadvert_add_error_empty_type'];
                else $advert['data']['id_type'] = $this->post('typeCategory');
            }
            
            if(!$this->post('description')) $msg['errors']['description'] = $lang_advert['newadvert_add_error_empty_description'];
            else $advert['data']['description'] = $this->post('description');
            
            $advert['data']['comments_permission'] = $this->post('comments');
                                    
            if(!$this->post('fullTextAdvert')) $msg['errors']['fullTextAdvert'] = $lang_advert['newadvert_add_error_empty_fulltext'];
            else $advert['data']['textAdvert'] = $this->post('fullTextAdvert');
            
            // Проходим по массиву
            foreach ($_POST as $key => $value) {
                unset($_POST[$key]);               // Удаляем элемент...
                if ($key == 'fullTextAdvert') {   // Но если ключ равен fullTextAdvert, то прекращаем
                    break;
                }
            }
            
            $AdvertImages = AdvertsModel::Instance()->getListImagesAdvert($p_page);
            if($AdvertImages['count']['numCount'] == 0) {
                if(empty($_FILES['images_advert']['name'][0])) $msg['errors']['images_advert'] = $lang_advert['newadvert_add_empty_images_advert'];
            }
            
            if(isset($_FILES['images_advert']) and !empty($_FILES['images_advert']['name'][0])) {
                $new_imgs = UploadHelper::UploadMoreImages($_FILES['images_advert'], 'adverts/'.$p_page);
                
                if(strpos($new_imgs, 'Error')) $msg['errors']['images_advert'] = $new_imgs;
                else $advert['data'] = $new_imgs;
            }
            
            
            $advert['data']['validate'] = '0';
            
            if (empty($msg['errors'])) {
                AdvertsModel::Instance()->editAdverts($advert);
                if(isset($_POST['id_fields_group'])){
                    $id_field = '';
                    foreach($_POST as $k => $v) {
                        $k = trim(htmlspecialchars($k, ENT_COMPAT, 'UTF-8'));
                        $v = trim(htmlspecialchars($v, ENT_COMPAT, 'UTF-8'));
                        
                        if (strpos($k, '_id') !== false) $id_field = $v;
                        else {
                            //if (strpos($v, '_') !== false) $data_v = explode('_', $v);
                            $fields[] = array(
                                'field_name' => $k,
                                'field_value' => $v,
                                'id_advert' => $p_page,
                                'id_field_group' => $this->post('id_fields_group'),
                                'id_field' => ($k == 'id_fields_group')?NULL:$id_field
                            );
                        }
                        unset($data_v);
                    }
                    AdvertsModel::Instance()->editsAdvertFields($fields, $p_page);
                }
                $msg['success'][] = $lang_advert['added_success'];
            }
            //print_r($msg);
            echo json_encode($msg);
        }
        
        public function action_deleteimg () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
            
            $profile_data = AuthClass::instance()->getUser();
            if($profile_data['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
            
            $id = Router::getUriParam(2);
            $imgName = Router::getUriParam(3);
            $folderName = Router::getUriParam(4);
            echo '/Media/images/adverts/'.$id.'/'.$imgName.'.png';
            if(unlink($_SERVER['DOCUMENT_ROOT'].'/Media/images/adverts/'.$id.'/'.$imgName.'.png')) {
                $list = scandir($_SERVER['DOCUMENT_ROOT'].'/Media/images/adverts/'.$id.'/');
                // РµСЃР»Рё РґРёСЂРµРєС‚РѕСЂРёРё РЅРµ СЃСѓС‰РµСЃС‚РІСѓРµС‚
                if (!$list) $msg = 'Directori not exists';
                
                // СѓРґР°Р»СЏРµРј . Рё ..
                unset($list[0],$list[1]);
                
                if(!AdvertsModel::Instance()->deleteImageFromAdvert($id, $imgName)) $msg = $addadvert['success_delete_img'];
            } else {
                $msg = $addadvert['error_delete_img'];
            }
            
            $this->redirect('/adverts/edit/'.$id);
        }
       
       public function action_delete () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
        
            $p_page = Router::getUriParam(2);
            
            if(empty($p_page)) {
                $this->redirect('/profile');
            } else {
                $u_date = AuthClass::instance()->getUser();
                $get_adv = AdvertsModel::Instance()->ifAuthuserIsAuthor($u_date['u_id'], $p_page);

                if(!empty($get_adv)) {
                    $result_delete = DelHelper::DeleteImages('adverts/'.$p_page);
                    DelHelper::DeleteImages('adverts/'.$p_page);
                    AdvertsModel::Instance()->deleteAdvert($p_page);
                    $this->redirect('/profile');
                }
            }
        }
    }
?>