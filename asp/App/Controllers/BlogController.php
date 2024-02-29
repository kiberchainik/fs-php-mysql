<?php
	class BlogController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_blog');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getArticlesCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->articles = PrivateModel::Instance()->GetArticlesList($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('blog'));
           
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_life_search_articles () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchArticle($this->post('search_tag'), $this->post('cat_id'));
            
            echo json_encode($search_result);
        }
        
        public function action_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_blog_editart');
           
           //$v->title = 'ЦУП: Редактирование';
           $v->description = '';
           $v->keywords = '';
           $v->upd_message = null;
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           $id = Router::getUriParam(2);
           $v->lang = PrivateModel::Instance()->GetLangNum();
            
            $ArticleData = PrivateModel::Instance()->getArticleDataForView($id);
            $v->AdvertsList = PrivateModel::Instance()->GetAdvertsSelectList();
            $ArticleData['mainCategory'] = PrivateModel::Instance()->getBlogCategoryesForArt($id);
            $CategoryList = PrivateModel::Instance()->ParentBlogList();
            $v->CategoryList = $this->showCatOption($this->getTree($CategoryList), $ArticleData['id_category'], '');
            
            $v->title = 'ЦУП: Редактирование "'.$ArticleData['artDesc'][1]['title'].'"';
            $v->ArticleData = $ArticleData;
            
            if ($this->post('seoTitle')) {
                if(isset($_FILES['artLogo']) and !empty($_FILES['artLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['artLogo'], 'blog/articles/'.$this->post('seoTitle'));
                elseif (!empty($ArticleData['logo'])) $image = $ArticleData['logo']; 
                elseif ($image == 'Error_size') $error = 'Error_size';
                else $error = 'Logo empty!'; //$image = '';
                
                if($this->post('artcategory') == '0') $error = 'Нужно обязательно выбрать категорию';
                if (!$this->post('seoTitle')) $error = 'Seo title пуст';
                //if(!$this->post('showart')) $error = 'Select show article!';
                
                foreach ($this->post('category_description') as $lang_key => $val) {
                    if(empty($val['title'])) $error = 'Write <b>title</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['keywords'])) $error = 'Write <b>keywords</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['description'])) $error = 'Write <b>description</b> for lang <b>"'.$lang_key.'"</b>!';
                }
                /*echo'<pre>';
                print_r($this->post('category_description'));
                echo'</pre>';*/
                if (!isset($error)) {
                    $blogArt = array(
                        'id' => $id,
                        'id_category' => $this->post('artcategory'),
                        'show_status' => $this->post('showart'),
                        'logo' => $image,
                        'seo' => $this->post('seoTitle'),
                        'id_company' => ($this->post('idAdvert') == '0')?'0':$this->post('idAdvert')
                    );
                    
                    PrivateModel::Instance()->seveArtData($blogArt, $this->post('category_description'));
                } else $v->upd_message = $error;
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_upd_art_valid () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
           $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->UpdValidArtStatus(array('show_status' => 1, 'id' => $id));
            $this->redirect(Url::local('blog'));
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
           $id = Router::getUriParam(2);
           
           $img = PrivateModel::Instance()->getArticleDataForView($id);
           $img = explode('/', $img['logo']);
           
           DelHelper::DeleteFile('images/blog/articles/'.$img[4].'/'.$img[5]);
           
           PrivateModel::Instance()->deleteArtBlog($id);
            
           $this->redirect(Url::local('blog'));
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
        	$menu = '<li>'.$category['title'].' <a href="/blog/'.$action_edit.'/'.$category['id'].'">Редактировать</a> <a href="/blog/'.$action_delete.'/'.$category['id'].'">Удалить</a></li>';
        		
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