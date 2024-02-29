<?php
	class NewcategoryController extends Controller {
        public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_newcategory');
           
           $v->title = 'ЦУП: Новая категория';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
            $CategoryList = CategoryModel::Instance()->ParentCategoryList();
            $v->categoryList = $this->showCatOption($this->getTree($CategoryList), '',  '&rarr;');
            
            $v->FieldsGroups = CategoryModel::Instance()->getFieldsGroupList();
            $v->FieldsList = CategoryModel::Instance()->getFieldsList();
            $v->TypeId = CategoryModel::Instance()->GetTypeList();
            
            if($this->post('category_description')) {
                /*echo'<pre>';
                print_r($_POST);
                echo'</pre>';*/
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category');
                else $image = '';
                
                $addDate = array(
                    'parent_id' => ($this->post('parent_id'))?$this->post('parent_id'):'0',
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> ($this->post('CategoryImage'))? $this->post('CategoryImage'):'',
                    'marker' => $this->post('marker')
                );
                
                if($this->post('advertFields')) $advertFields = $this->post('advertFields');
                else $advertFields = '';
                
               if(!CategoryModel::Instance()->AddNewCategory($addDate, $this->post('TypeId'), $advertFields, $this->post('category_description'))) {
                    return 'Категория добавлена';
                } else {
                    return 'Ошибка записи в базу';
                }
            }
            
            $v->useTemplate();
	        $this->response($v);
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