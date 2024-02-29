<?php
	class MainMenuModule extends Controller {
	   public function action_index() {
	       $v = new View('site/mainmenu');
           
           $lang_mainmenu = $this->lang('mainmenu');
           //print_r($lang_mainmenu);
           //$v->text_categorys = $lang_mainmenu['category'];
           
           $categoryList = MainMenuModel::Instance()->ParentCategoryList();
           $category = $this->getTree($categoryList);
           $v->menu = $this->showCat($category);

	       $this->response($v);
	   }
       
       private function getTree($dataset) {
        	$tree = array();

        	foreach ($dataset as $id => &$node) {
        		//Если нет вложений
        		if (!$node['parent_id']){
        			$tree[$id] = &$node;
        		}else{ 
        			//Если есть потомки то перебераем массив
                    $dataset[$node['parent_id']]['childs'][$id] = &$node;
        		}
        	}
        	return $tree;
        }
        
        //Шаблон для вывода меню в виде дерева
        private function tplMenu($category){
            if($category['seo'] == "") $category['seo'] = $category['id'];
    		$menu = '';
            if(isset($category['childs'])){
    			$menu .= '<li><a href="#">'.$category['title'].'</a>
                            <ul class="dl-submenu"><li class="dl-back"><a href="#">back</a></li>'.$this->showCat($category['childs']) .'</ul></li>';
    		} else {
                $menu = '<li><a href="/category/page/'.$category['seo'].'">'.$category['title'].'</a></li>';
    		}
        	return $menu;
        }
        
        /*Рекурсивно считываем наш шаблон*/
        private function showCat($data){
        	$string = '';
        	foreach($data as $item){
        		$string .= $this->tplMenu($item);
        	}
        	return $string;
        }
	}
?>