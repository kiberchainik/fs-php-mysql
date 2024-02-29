<?php
	class AdvertsController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_adverts_list');
           
           $v->title = 'ЦУП: Все объявления';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $CategoryList = CategoryModel::Instance()->ParentCategoryList();
           $v->categoryList = $this->showCatOption($this->getTree($CategoryList), '',  '&rarr;');
           
           $p_page = Router::getUriParam('page'); // p. num
           
           $count = PrivateModel::Instance()->countAdvertsForPage(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->adverts = PrivateModel::Instance()->getAdvertListForPage($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('adverts'));
           /*echo'<pre>';
            print_r($v->adverts);
            echo'</pre>';*/
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_life_search_adverts () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchAdverts($this->post('search_tag'), $this->post('cat_id'));
            
            echo json_encode($search_result);
        }
        
        public function action_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_adverts_edit');
           
           $v->title = 'ЦУП: Редатирование объявления';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam(2);
           $AdvertData = AdvertsModel::Instance()->getAdvertDataForView($p_page);
                
            $listImgs = AdvertsModel::Instance()->getListImagesAdvert($p_page);
            $AdvertData['imgs'] = $listImgs['list'];
            
            $AdvertData['fieldsAdvert'] = AdvertsModel::Instance()->getFieldsForAdvert($p_page, '', $_SESSION['lid']);
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
            
            $v->AdvertData = $AdvertData;
            $v->subSelects = $subSelects;
            $v->CategoryList = CategoryModel::Instance()->GetCategoryListWithoutParetnId();
            $v->fieldsAdvert = AdvertsModel::Instance()->getFieldsForAdvert($v->advertData['id']);
           
           
           /*echo'<pre>';
            print_r($AdvertData);
            echo'</pre>';*/
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_saveedit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
           $p_page = Router::getUriParam(2);
           $v = new View('editadvert');
           $lang_advert = $this->lang('editadvert');
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            $advert = array();
            
            $advert['data']['id'] = $p_page;
            
            if(!$this->post('title')) {
                $msg['errors']['title'] = $lang_advert['newadvert_add_error_empty_title'];
            } else {
                $advert['data']['title'] = str_replace('/', '-', $this->post('title'));
                
                if (HTMLHelper::isRuLetters($this->post('title'))) {
                    $title = strtr($advert['data']['title'], array(' ' => '_'));
                    $advert['data']['seo'] = HTMLHelper::TranslistLetterRU_EN($title);
                } else $advert['data']['seo'] = strtr($advert['data']['title'], array(' ' => '_'));
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
                if(empty($_FILES['images_advert']['name'][0])) $msg['errors']['images_advert'] = $lang_advert['empty_images_advert'];
            }
            
            if(isset($_FILES['images_advert']) and !empty($_FILES['images_advert']['name'][0])) {
                $advert['imgs'] = $this->app->lib_Validation->ValidMoreImages($_FILES['images_advert'], 'adverts/'.$p_page);
            }
            
            if (empty($msg['errors'])) {
                AdvertsModel::Instance()->editAdverts($advert);
                if(isset($_POST['id_fields_group'])){
                    foreach($_POST as $k => $v) {
                        if (strpos($k, '_id') !== false) $id_field = $v;
                        else {
                            if (strpos($v, '_') !== false) $data_v = explode('_', $v);
                            $fields[] = array(
                                'field_name' => $k,
                                'field_value' => (isset($data_v[1]))?$data_v[1]:$v,
                                'id_advert' => $p_page,
                                'val_inter_sel' => (isset($data_v[0]))?$data_v[0]:'0',
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
            
            echo json_encode($msg);
            //print_r($fields);
        }
        
        public function action_deleteimg () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            $imgName = Router::getUriParam(3);
            $folderName = Router::getUriParam(4);
            
            if(unlink('https://findsol.it/Media/images/adverts/'.$id.'/'.$imgName.'.png')) {
                $list = scandir('https://findsol.it/Media/images/adverts/'.$id.'/');
                // РµСЃР»Рё РґРёСЂРµРєС‚РѕСЂРёРё РЅРµ СЃСѓС‰РµСЃС‚РІСѓРµС‚
                if (!$list) $msg = 'Directori not exists';
                
                // СѓРґР°Р»СЏРµРј . Рё ..
                unset($list[0],$list[1]);
                
                if(!AdvertsModel::Instance()->deleteImageFromAdvert($id, $imgName)) $msg = $addadvert['success_delete_img'];
            } else {
                $msg = $addadvert['error_delete_img'];
            }
            
            $this->redirect('/adverts/p_adverts_edit/'.$id);
        }
       
       public function action_delete () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
        
            $p_page = Router::getUriParam(2);
            
            if(empty($p_page)) {
                $this->redirect('/main');
            } else {
                $u_date = AuthClass::instance()->getUser();
                //$get_adv = AdvertsModel::Instance()->ifAuthuserIsAuthor($u_date['u_id'], $p_page);

                //if(!empty($get_adv)) {
                    //$result_delete = DelHelper::DeleteImages('adverts/'.$p_page);
                    DelHelper::DeleteImages('adverts/'.$p_page);
                    AdvertsModel::Instance()->deleteAdvert($p_page);
                    $this->redirect('/adverts');
                //}
            }
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
            header('Content-type: application/json');
            $type_list = NewadvertModel::Instance()->getFieldsListForAdd($this->post('id_cat'), $this->post('id_type'), $this->post('lang'));
            
            echo json_encode($type_list);
        }
        
        public function action_getFieldsCategoryListEdit () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
            if (isset($_POST['id_cat'])) {
                header('Content-type: application/json');
                $type_list = $this->secureDataDecode(NewadvertModel::Instance()->getFieldsListForEdit($this->post('id_cat'), $this->post('id_type'), $this->post('id_adv'), $this->post('lang')));
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
        
        private function getTree($dataset) {
        	$tree = array();

        	foreach ($dataset as $id => &$node) {
        		if (!$node['parent_id']){
        			$tree[$id] = &$node;
        		}else{
                    $dataset[$node['parent_id']]['childs'][$id] = &$node;
        		}
        	}
        	return $tree;
        }
        
        /*--- select option for edit category ---*/
        public function tplOption($category, $select, $str = ' - '){
        	if($category['parent_id'] == 0){
               if($category['id'] == $select) {
                    $menu = '<option value="'.$category['id'].'" selected>'.$category['title'].'</option>';
               } else {
                     $menu = '<option value="'.$category['id'].'">'.$category['title'].'</option>';
               }
            }else{
                if($category['id'] == $select) {
                    $menu = '<option value="'.$category['id'].'" selected>'.$str.' '.$category['title'].'</option>';
                } else {
                    $menu = '<option value="'.$category['id'].'">'.$str.' '.$category['title'].'</option>';
                }
               
            }
            
        	if(isset($category['childs'])){
        		$menu .= $this->showCatOption($category['childs'], $select, $str);
        	}
            return $menu;
        }
        
        public function showCatOption($data, $select, $str){
        	$string = '';
        	foreach($data as $item){
        		$string .= $this->tplOption($item, $select, $str);
        	}
        	return $string;
        }
        /*--- /select option for edit category ---*/
    }
?>