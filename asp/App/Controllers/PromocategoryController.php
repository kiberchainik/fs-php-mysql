<?php
	class PromocategoryController extends Controller {
	   public function action_index () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_promocategory');
           
           $v->title = 'ЦУП: Список всех категорий для промо страниц';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $categoryList = PromoModel::Instance()->ParentCategoryList();
           $v->categoryList = $this->showCatAdmin($this->getTree($categoryList), 'Promocategory/edit', 'Promocategory/delete');
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_promocategory_new');
           
           $v->title = 'ЦУП: Новая категория';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
            $CategoryList = PromoModel::Instance()->ParentCategoryList();
            $v->categoryList = $this->showCatOption($this->getTree($CategoryList), '',  '&rarr;');
            
            if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'promocategory');
                else $image = '';
            
            if($this->post('category_description')) {
                $addDate = array(
                    'parent_id' => ($this->post('parent_id'))?$this->post('parent_id'):'0',
                    'seo' => $this->post('seoTitle'),
                    'icon' => $image,
                    'lavel' => $this->post('lavel'),                    
                );
                
               PromoModel::Instance()->AddNewCategory($addDate, $this->post('category_description'));
            }
            
            $v->useTemplate();
	        $this->response($v);
       }
       
       public function action_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_promocategory_edit');
           
           $v->title = 'ЦУП: Редактирование категории';
           $v->description = '';
           $v->keywords = '';
           
           $id = Router::getUriParam(2);
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->categoryData = PromoModel::Instance()->GetCategoryData($id);
            
            $CategoryList = PromoModel::Instance()->ParentCategoryList();
            $v->categoryList = $this->showCatOption($this->getTree($CategoryList), $v->categoryData['parent_id'],  '&rarr;');

            if ($this->post('category_description')) {
                
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'promocategory');
                    else $image = $v->categoryData['icon'];
            
                $editDate = array(
                    'id' => (int)$id,
                    'parent_id' => $this->post('parent_id'),
                    'seo' => $this->post('seoTitle'),
                    'icon' => $image,
                    'lavel' => $this->post('lavel')
                );
                
               PromoModel::Instance()->UpdateCategory($editDate, $id, $this->post('category_description'));
            }
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_delete () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
           $icon_name = PromoModel::Instance()->getSeotitle($id);

           PromoModel::Instance()->deletecategory($id);
           
           DelHelper::DeleteImages('promocategory/'.$icon_name['seo'].'.png');                      

           $this->redirect(Url::local('promocategory'));
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