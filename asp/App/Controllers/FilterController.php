<?php
	class FilterController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_filter_list');
           
           $v->title = 'ЦУП: Фильтры для категорий сайта';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->filterList = FilterModel::Instance()->GetFilterList();
           //echo '<pre>'; print_r($v->filterList); echo '</pre>';
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_filter_new');
           
           $v->title = 'ЦУП: Новый фильтр';
           $v->description = '';
           $v->keywords = '';
           $v->upd_message = null;
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $CategoryList = CategoryModel::Instance()->ParentCategoryList();
           $v->categoryList = $this->showCatOption($this->getTree($CategoryList), '',  '&rarr;');
           
           $v->fieldsgroup = FilterModel::Instance()->GetFieldsGroupList();
           
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_get_fields () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $fields = FilterModel::Instance()->GetFieldListOfGroup($this->post('id'));
           
           echo json_encode($fields);
        }
        
        public function action_save () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $msg = array();
           if(!$this->post('category')) $msg['category'] = 'Category is empty';
           if($this->post('namefilter') == '') $msg['namefilter'] = 'Name of filter is empty';
           if($this->post('sortfilter') == '') $msg['sortfilter'] = 'Sort number of filter is empty';
           if($this->post('fieldsgroup') == '0') $msg['fieldsgroup'] = 'Select the group';
           if(!$this->post('fields')) $msg['fields'] = 'Select the fields for filter';
           
           $data = array(
                'category' => $this->post('category'),
                'namefilter' => $this->post('namefilter'),
                'sort' => $this->post('sortfilter'),
                'fieldsgroup' => $this->post('fieldsgroup'),
                'fields' => $this->post('fields')
           );
           
           if(empty($msg)) {
                FilterModel::Instance()->addNewFilter($data);
           }
           
           $this->redirect(Url::local('filter'));
        }
        
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
           $id = Router::getUriParam(2);
           
           FilterModel::Instance()->deletefilter($id);
            
           $this->redirect(Url::local('filter'));
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
    }
?>