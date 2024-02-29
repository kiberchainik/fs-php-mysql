<?php
	class BlogMenuModule extends Controller {
	   public function action_index() {
	       $v = new View('site/blogmenu');
           
           $lang_menu = $this->lang('blogmenu');
           $v->text_blogmenu = $lang_menu['blogmenu'];
           
           $categoryList = BlogMenuModel::Instance()->ParentCategoryList();
           $category = $this->getTree($categoryList);
           $v->blogmenu = $this->showCat($category);

	       $this->response($v, true);
	   }
       
       private function getTree($dataset) {
        	$tree = array();

        	foreach ($dataset as $id => &$node) {    
        		//���� ��� ��������
        		if (!$node['parent_id']){
        			$tree[$id] = &$node;
        		}else{ 
        			//���� ���� ������� �� ���������� ������
                    $dataset[$node['parent_id']]['childs'][$id] = &$node;
        		}
        	}
        	return $tree;
        }
        
        //������ ��� ������ ���� � ���� ������
        private function tplMenu($category){
            if($category['seo'] == "") $category['seo'] = $category['id'];
            $menu = '';
            if(isset($category['childs'])){
    			$menu .= '<li><a href="#">'.$category['title'].' </a>
                            <ul>
                              '. $this->showCat($category['childs']) .'
                            </ul></li>';
    		} else $menu .= '<li><a href="/blog/category/'.$category['seo'].'">'.$category['title'].'</a></li>';
            
        	return $menu;
        }
        
        /*���������� ��������� ��� ������*/
        private function showCat($data){
        	$string = '';
        	foreach($data as $item){
        		$string .= $this->tplMenu($item);
        	}
        	return $string;
        }
	}
?>