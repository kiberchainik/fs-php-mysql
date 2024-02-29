<?php
	class CategoryvacanciesController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $v = new View('p_category_vac');
           
           $v->title = 'ЦУП: Все категории вакансий';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $CategoryList = PrivateModel::Instance()->ParentCategoryVacancieList();
            $v->categoryList = $this->showCatAdmin($this->getTree($CategoryList), 'categoryvacancies/edit', 'categoryvacancies/delete');
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $v = new View('p_category_vac_new');
           
           $v->title = 'ЦУП: Новая категория для вакансии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $v->lang = PrivateModel::Instance()->GetLangNum();
            $CategoryList = PrivateModel::Instance()->ParentCategoryVacancieList();
            $v->CategoryList = $this->showCatOption($this->getTree($CategoryList), '', '&rarr;');
            
            if($this->post('category_description')) {
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category/vacancies');
                else $image = '';
                
                $addDate = array(
                    'parent_id' => ($this->post('parent_id'))?$this->post('parent_id'):'0',
                    //'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> ($this->post('CategoryImage'))?$this->post('CategoryImage'):''
                );
                
               PrivateModel::Instance()->AddNewCategoryVacancie($addDate, $this->post('category_description'));
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
            $v = new View('p_category_vac_edit');
           
           $v->title = 'ЦУП: Редактирование категории вакансии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $id = Router::getUriParam(2);
            
            $v->categoryData = PrivateModel::Instance()->GetCategoryVacancieData($id);
            $v->lang = PrivateModel::Instance()->GetLangNum();
            
            $CategoryList = PrivateModel::Instance()->ParentCategoryVacancieList();
            $v->CategoryList = $this->showCatOption($this->getTree($CategoryList), $v->categoryData['parent_id'], '&rarr;');
            
            if ($this->post('category_description')) {
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category');
                else $image = '';
                
                $editDate = array(
                    'id' => (int)$id,
                    'parent_id' => $this->post('parent_id'),
                    //'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> $this->post('CategoryImage')
                );
                
                PrivateModel::Instance()->UpdateCategoryVacancie($editDate, $id, $this->post('category_description'));
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_delete () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);

            if(!PrivateModel::Instance()->deletecategoryvacancies($id)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Категория удалена';
            }
            
            $this->redirect(Url::local('categoryvacancies'));
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
        
        /*--- main menu for private ---*/
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
    }
?>