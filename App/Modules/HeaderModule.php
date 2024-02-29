<?php
	class HeaderModule extends Controller {
	   public function action_index() {
	       $v = new View('site/header');
           $lang_header = $this->lang('header');
           $settings = MainModel::Instance()->GetSettings();
           
           if(AuthClass::instance()->isAuth()) {
				$profile_data = AuthClass::instance()->getUser();
                $v->profile_logo = ($profile_data['user_img'])?$profile_data['user_img']:'Media/images/no_avatar.png';
				$v->auth = $profile_data['u_id'];
                $v->profile_menu = $this->module('ProfilePushMenu');
                $v->user_name = $profile_data['name'];
                $v->user_lastname = $profile_data['lastname'];
			} else $v->auth = false;
			
           $v->logo = $settings['logo'];
           $v->image = $settings['logo'];
           $v->admin_name = $settings['admin_name'];
           $v->admin_mobile = $settings['admin_mobile'];
           $v->admin_email = $settings['admin_email'];
           $v->admin_adres = $settings['admin_adres'];
           
           $v->keywords = '';
           $v->og_img = '';
           
           $v->text_main = $lang_header['header_menu_main'];
           $v->text_addadvert = $lang_header['header_menu_addadvert'];
           $v->text_addportfolio = $lang_header['header_menu_portfolio'];
           $v->text_portfolio = $lang_header['text_portfolio'];
           $v->text_login = $lang_header['header_menu_login'];
           $v->text_logout = $lang_header['header_menu_logout'];
           $v->text_allportfolio = $lang_header['sub_header_menu_allportfolio'];
           $v->text_vacancies = $lang_header['text_vacancies'];
           $v->text_company = $lang_header['sub_header_menu_company'];
           $v->text_blog = $lang_header['sub_header_menu_blog'];
           $v->text_contacts = $lang_header['sub_header_menu_contacts'];
           $v->text_where_search = $lang_header['text_where_search'];
           $v->text_users = $lang_header['text_users'];
           $v->text_adverts = $lang_header['text_adverts'];
           $v->text_language = $lang_header['text_language'];
           $v->mainmenumod = $this->module('MainMenu');
           
           $categoryList = MainMenuModel::Instance()->ParentCategoryList();
           $category = $this->getTree($categoryList);
           $v->mobile_menu = $this->showCat($category);
           
           $v->information = HeaderModel::Instance()->HeaderInformation();
           $v->lang = HeaderModel::Instance()->GetLangList();
           $v->lifesearch = $this->module('LifeSearch');
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
                                <ul class="mobile-sub-menu">'.$this->showCat($category['childs']).'</ul></li>';
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