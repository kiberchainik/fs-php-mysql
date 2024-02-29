<?php
	class BlognewarticleController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_blog_newart');
           
           $v->title = 'ЦУП: Новая статья для блога';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
            $CategoryList = PrivateModel::Instance()->ParentBlogList();
            $v->AdvertsList = PrivateModel::Instance()->GetAdvertsSelectList();
            $v->CategoryList = $this->showCatOption($this->getTree($CategoryList), '', '&rarr;');
            
            if ($this->post('seoTitle')) {
                if(isset($_FILES['artLogo']) and !empty($_FILES['artLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['artLogo'], 'blog/articles/'.$this->post('seoTitle'));
                else $v->error = 'Logo empty!'; //$image = '';
                
                if($this->post('artcategory') == '0') $v->error = 'Select Category!';
                if($this->post('seoTitle')) $v->error = 'Write seo title!';
                if($this->post('showart')) $v->error = 'Select show article!';
                
                foreach ($this->post('category_description') as $lang_key => $val) {
                    if(empty($val['title'])) $v->error = 'Write <b>title</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['keywords'])) $v->error = 'Write <b>keywords</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['description'])) $v->error = 'Write <b>description</b> for lang <b>"'.$lang_key.'"</b>!';
                }
                
                if (!empty($v->error)) return $v->error;
                else {
                    $art_blog_date = array(
                        'id_category' => $this->post('artcategory'),
                        'seo' => $this->post('seoTitle'),
                        'logo' => $image,
                        'add_date' => time(),
                        'show_status' => $this->post('showart'),
                        'id_company' => ($this->post('idAdvert') == '0')?'0':$this->post('idAdvert')
                    );
                    
                    PrivateModel::Instance()->AddNewArt($art_blog_date, $this->post('category_description'));
                }
            }
            
            /*echo'<pre>';
            print_r($data['message']);
            echo'</pre>';*/
            
            $v->useTemplate();
	        $this->response($v);
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
        	$menu = '<li>'.$category['title'].' <a href="/private/'.$action_edit.'/'.$category['id'].'">Редактировать</a> <a href="/private/'.$action_delete.'/'.$category['id'].'">Удалить</a></li>';
        		
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