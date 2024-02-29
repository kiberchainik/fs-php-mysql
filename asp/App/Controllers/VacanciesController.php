<?php
	class VacanciesController extends Controller {
	   public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_vacancies');
           
           $v->title = 'ЦУП: Все вакансии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $categoryList = VacanciesModel::Instance()->GetCategoryListWithoutParetnId();
           $v->categoryListForVacancies = $this->showCatOption($this->getTree($categoryList), '', '-');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getVacanciesCount(20);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->vacancies = PrivateModel::Instance()->getVacanciesPage($p_page, 20);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('vacancies'));
           /*echo'<pre>';
            print_r($v->vacancies);
            echo'</pre>';*/
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_life_search_vacancies () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchVacancies($this->post('search_tag'), $this->post('cat_id'));
            
            echo json_encode($search_result);
        }
        
        public function action_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_vacancies_edit');
           
           $v->title = 'ЦУП: Редатирование вакансии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam(2);
           $v->categoryList = VacanciesModel::Instance()->GetCategoryListWithoutParetnId();
            
            $v->vacanceData = VacanciesModel::Instance()->getDataVacancies($p_page);
            $v->requirements = VacanciesModel::Instance()->getRequirementsOfVacancy($p_page);
               
           /*echo'<pre>';
            print_r($AdvertData);
            echo'</pre>';*/
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_saveedit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
           $msg = array(
                'errors' => array(),
                'success' => array()
            );
           $requirements = array ();
            $lang_vacancies = $this->lang('vacancies');
            
            if(!$this->post('title')) $msg['errors']['title'] = $lang_vacancies['empty_title'];
            else {
                if($this->post('v_id')) {
                    $old_title = VacanciesModel::Instance()->getTitleOfVacance($this->post('v_id'));
                    
                    if($old_title['title'] != $this->post('title')) {
                        $seo = (HTMLHelper::isRuLetters($this->post('title')))?HTMLHelper::TranslistLetterRU_EN($this->post('title')):strtr($this->post('title'), array('.' => "_", ',' => "_", '/' => "_", ' ' => "_"));
                        $num_v_seo = VacanciesModel::Instance()->getCountSeoVacance($seo);
                        if($num_v_seo['numCount'] > 0) $msg['errors']['title'] = $lang_vacancies['title_exist'];
                    } else {
                        $seo = $old_title['seo'];
                    }
                } else {
                    $seo = (HTMLHelper::isRuLetters($this->post('title')))?HTMLHelper::TranslistLetterRU_EN($this->post('title')):strtr($this->post('title'), array('.' => "_", ',' => "_", '/' => "_", ' ' => "_"));
                    $num_v_seo = VacanciesModel::Instance()->getCountSeoVacance($seo);
                    if($num_v_seo['numCount'] > 0) $msg['errors']['title'] = $lang_vacancies['title_exist'];
                }
            }
            
            if($this->post('id_category') == '0') $msg['errors']['id_category'] = $lang_vacancies['empty_category'];
            if(!$this->post('tags_vacance')) $msg['errors']['tags_vacance'] = $lang_vacancies['empty_tags_vacance'];
            if(!$this->post('short_description')) $msg['errors']['short_description'] = $lang_vacancies['empty_short_desc'];
            if(!$this->post('full_description')) $msg['errors']['full_description'] = $lang_vacancies['empty_full_desc'];
            
            $newVacance = array(
                'id_user' => $this->post('user_id'),
                'id_category' => $this->post('id_category'),
                'title' => $this->post('title'),
                'tags' => $this->post('tags_vacance'),
                'seo' => $seo,
                'short_desc' => $this->post('short_description'),
                'full_desc' => $this->post('full_description'),
                'date_add' => time()                    
            );
            
            if(!$msg['errors']) {
                $newVacance['id'] = $this->post('v_id');
                VacanciesModel::Instance()->UpdVacancies($newVacance);
                
                if ($this->post('age') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => $this->post('v_id'),
                        'name_rm' => 'age',
                        'value_rm' => $this->post('age'),
                        'status_rm' => $this->post('age_rm')
                    );
                }
                
                if ($this->post('education') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => $this->post('v_id'),
                        'name_rm' => 'education',
                        'value_rm' => $this->post('education'),
                        'status_rm' => $this->post('education_rm')
                    );
                }
                    
                if ($this->post('languages')) {
                    $requirements[] = array(
                        'id_vacancy' => $this->post('v_id'),
                        'name_rm' => 'languages',
                        'value_rm' => $this->post('languages'),
                        'status_rm' => $this->post('languages_rm')
                    );
                }
                
                if ($this->post('special_knowledge')) {
                    $requirements[] = array(
                        'id_vacancy' => $this->post('v_id'),
                        'name_rm' => 'special_knowledge',
                        'value_rm' => $this->post('special_knowledge'),
                        'status_rm' => $this->post('special_knowledge_rm')
                    );
                }
                    
                if ($this->post('experience') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => $this->post('v_id'),
                        'name_rm' => 'experience',
                        'value_rm' => $this->post('experience'),
                        'status_rm' => $this->post('experience_rm')
                    );
                }
                
                if ($this->post('driver_license') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => $this->post('v_id'),
                        'name_rm' => 'driver_license',
                        'value_rm' => $this->post('driver_license'),
                        'status_rm' => $this->post('driver_license_rm')
                    );
                }
                
                if ($this->post('own_transport') != '0') {
                    $requirements[] = array(
                        'id_vacancy' => $this->post('v_id'),
                        'name_rm' => 'own_transport',
                        'value_rm' => ($this->post('own_transport') == '0')?$this->post('other'):$this->post('own_transport'),
                        'status_rm' => $this->post('own_transport_rm')
                    );
                }
                    
                if($requirements) {
                    //print_r($requirements);
                    VacanciesModel::Instance()->UpdRequirements($requirements, $this->post('v_id'));
                    $msg['success'] = $lang_vacancies['saved'];
                }
            }
            echo json_encode($msg);
        }
        
        public function action_upd_valid () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $p_page = Router::getUriParam(2);
           
            PrivateModel::instance()->UpdVacanciesValidStatus(array('valid_status' => 1, 'id' => $p_page));
            $this->redirect(Url::local('vacancies'));
        }
       
       public function action_delete () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
        
            $p_page = Router::getUriParam(2);
            
            if(empty($p_page)) {
                $this->redirect('/main');
            } else {
                VacanciesModel::Instance()->deleteVacancies($p_page);
                $this->redirect(Url::local('vacancies'));
            }
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
	}
?>