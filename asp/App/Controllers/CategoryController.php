<?php
	class CategoryController extends Controller {
	   public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_category');
           
           $v->title = 'ЦУП: Список всех категорий в главном меню';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $categoryList = CategoryModel::Instance()->ParentCategoryList();
           $v->categoryList = $this->showCatAdmin($this->getTree($categoryList), 'category/edit', 'category/delete');
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_editcategory');
           
           $v->title = 'ЦУП: Редактирование категории';
           $v->description = '';
           $v->keywords = '';
           
           $id = Router::getUriParam(2);
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->categoryData = CategoryModel::Instance()->GetCategoryData($id);
            
            $CategoryList = CategoryModel::Instance()->ParentCategoryList();
            $v->categoryList = $this->showCatOption($this->getTree($CategoryList), $v->categoryData['parent_id'],  '&rarr;');
            
            $v->FieldsGroups = CategoryModel::Instance()->getFieldsGroupList();
            $v->FieldsGroupsForCategory = CategoryModel::Instance()->getFieldsGroupListForCategory($id);
            
            $v->FieldsList = CategoryModel::Instance()->getFieldsList();
            
            $v->TypeId = CategoryModel::Instance()->GetTypeList();
            $v->TypesForCategory = CategoryModel::Instance()->GetTypeListForCategory($id);
            /*echo'categoryData <pre>';
                print_r($v->categoryData);
                echo'</pre>';
                echo'categoryList <pre>';
                print_r($v->categoryList);
                echo'</pre>';
                echo'FieldsGroups <pre>';
                print_r($v->FieldsGroups);
                echo'</pre>';
                echo'FieldsGroupsForCategory <pre>';
                print_r($v->FieldsGroupsForCategory);
                echo'</pre>';
                echo'FieldsList <pre>';
                print_r($v->FieldsList);
                echo'</pre>';
                echo'TypeId <pre>';
                print_r($v->TypeId);
                echo'</pre>';
                echo'TypesForCategory <pre>';
                print_r($v->TypesForCategory);
                echo'</pre>';*/
            if ($this->post('category_description')) {
                
                if ($this->post('CategoryImage') == 'image') {
                    if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category');
                    else $image = $v->categoryData['imgicon'];
                } else $image = '';
            
                $editDate = array(
                    'id' => (int)$id,
                    'parent_id' => $this->post('parent_id'),
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> $this->post('CategoryImage'),
                    'marker' => $this->post('marker')
                );
                
                if($this->post('advertFields')) $advertFields = $this->post('advertFields');
                else $advertFields = '';
                
                $FieldsGoupId = (int)$this->post('FieldsGoupId');
                $TypeId = ($this->post('TypeId'))?$this->post('TypeId'):'0';
                
               if(!CategoryModel::Instance()->UpdateCategory($editDate, $TypeId, $id, $advertFields, $FieldsGoupId, $this->post('category_description'))) {
                    $v->msg = 'Категория обновлена';
                } else {
                    $v->msg = 'Ошибка записи в базу';
                }
            }
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_getFieldsFromGroup () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            if ($this->post('id')) {
                $ListFieldsForGroup = CategoryModel::Instance()->getListFieldsForCategory($this->post('id'));
                if($this->post('id_cat') and $this->post('id_group')) {
                    $FieldsForCategory = CategoryModel::Instance()->getFieldsForCategory($this->post('id_cat'), $this->post('id_group'));
                    echo json_encode(array('ListFieldsForGroup' => $ListFieldsForGroup, 'FieldsForCategory' => $FieldsForCategory));
                } else {
                    echo json_encode(array('ListFieldsForGroup' => $ListFieldsForGroup));
                }
            }
        }
       
       public function action_category_delete ($arg) {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);

            if(!CategoryModel::Instance()->deletecategory($id)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Категория удалена';
            }
            
            $this->redirect(Url::local('category'));
        }
        
        /*--- main menu for private ---*/
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
        
        private function tplMenuAdmin($category, $action_edit, $action_delete){
        	$menu = '<li>'.$category['title'].' <a href="/'.$action_edit.'/'.$category['id'].'">Редактировать</a> <a href="/'.$action_delete.'/'.$category['id'].'">Удалить</a></li>';
        		
        		if(isset($category['childs'])){
        			$menu .= '<div class="link">+</div><ul class="submenu">'. $this->showCatAdmin($category['childs'], $action_edit, $action_delete) .'</ul></li>';
        		}
        	$menu .= '</li>';
        	
        	return $menu;
        }
        
        private function showCatAdmin($data, $action_edit, $action_delete){
        	$string = '';
        	foreach($data as $item){
        		$string .= $this->tplMenuAdmin($item, $action_edit, $action_delete);
        	}
        	return $string;
        }
        /*--- /main menu for private ---*/
        
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