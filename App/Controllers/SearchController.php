<?php
	class SearchController extends Controller {
	   public function action_index() {
	       $v = new View('site/search_result_list');
           $lang_search = $this->lang('search');
           
           $v->title = $lang_search['title'];
           $v->description = '';
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           //$v->leftsidebar = $this->module('LeftSidebar');
           $v->vacanciesCategoriList = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory();
           
           //$page = (int)Router::getUriParam('page');
           //if($page < 1 or $page > $count) Url::local('404');
           
           $select = '';
           $from = '';
           $where = '';
           $param = '';
           $search_result = array(
                'users' => array (),
                'portfolio' => array (),
                'adverts' => array (),
                'vacancies' => array ()
           );
            
           if($this->post('search_local')) {
                if ($this->post('search_local') == 'users') {
                    $select = 'u.id, u.onlineSatus, ud.user_img, ud.name, ud.lastname, ud.about';
                    $from = 'users as u, user_date as ud ';
                    $where = 'MATCH(u.login, u.email, ud.name, ud.lastname, ud.mobile, ud.about, ud.company_name, ud.patent) AGAINST (:query IN BOOLEAN MODE) and u.validStatus = 1 and u.id = ud.user_id';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $search_result['users'] = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                }
                
                if ($this->post('search_local') == 'portfolio') {
                    $select = 'p.id, p.portfolio_img, p.name, p.lastname, p.about, p.id_user, u.onlineSatus';
                    $from = 'portfolio as p, users as u ';
                    $where = 'MATCH(p.name, p.lastname, p.about) AGAINST (:query IN BOOLEAN MODE) and search_status = 0 and u.validStatus = 1 and u.id = p.id_user';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $search_result['portfolio'] = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                }
                
                if ($this->post('search_local') == 'adverts') {
                    $select = 'a.id, a.seo, a.title, a.description';
                    $from = 'adverts as a ';
                    $where = 'MATCH(a.title, a.description, a.keywords) AGAINST (:query IN BOOLEAN MODE) and validate = 1';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $search_result['adverts'] = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                }
                
                if ($this->post('search_local') == 'vacancies') {
                    $select = 'v.id, v.title, v.short_desc';
                    $from = 'vacancies as v ';
                    $where = 'MATCH(v.title, v.short_desc, v.full_desc) AGAINST (:query IN BOOLEAN MODE) and valid_status = 1';
                    $param = array('query' => $this->post('search_query').'*');
                    
                    $search_result['vacancies'] = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
                }
           } else {
                $search_result = array(
                    'users' => array (
                        'select' => 'u.id, u.onlineSatus, ud.user_img, ud.name, ud.lastname, ud.about',
                        'from' => 'users as u, user_date as ud ',
                        'where' => 'MATCH(u.login, u.email, ud.name, ud.lastname, ud.mobile, ud.about, ud.company_name, ud.patent) AGAINST (:query IN BOOLEAN MODE) and u.validStatus = 1 and u.id = ud.user_id',
                        'param' => array('query' => $this->post('search_query').'*')
                    ),
                    'portfolio' => array (
                        'select' => 'p.id, p.portfolio_img, p.name, p.lastname, p.about, p.id_user, u.onlineSatus',
                        'from' => 'portfolio as p, users as u ',
                        'where' => 'MATCH(p.name, p.lastname, p.about) AGAINST (:query IN BOOLEAN MODE) and search_status = 0 and u.validStatus = 1 and u.id = p.id_user',
                        'param' => array('query' => $this->post('search_query').'*')
                    ),
                    'adverts' => array (
                        'select' => 'a.id, a.seo, a.title, a.description, ai.src',
                        'from' => 'adverts as a, advert_imgs as ai ',
                        'where' => 'MATCH(a.title, a.description, a.keywords) AGAINST (:query IN BOOLEAN MODE) and a.validate = 1 and ai.main = 1 and a.id = ai.id_adv',
                        'param' => array('query' => $this->post('search_query').'*')
                    ),
                    'vacancies' => array (
                        'select' => 'v.id, v.seo, v.title, v.short_desc, b.img',
                        'from' => 'vacancies as v, branch as b ',
                        'where' => 'MATCH(v.title, v.short_desc, v.full_desc) AGAINST (:query IN BOOLEAN MODE) and v.valid_status = 1 and v.id_filial = b.id',
                        'param' => array('query' => $this->post('search_query').'*')
                    )
                );
                
                foreach($search_result as $local => $sq) {
                    $search_result[$local] = LiveSearchModel::Instance()->LiveSearch($sq['select'], $sq['from'], $sq['where'], $sq['param']);
                }
                /*echo '<pre>';
                print_r($search_result);
                echo '</pre>';*/
                $v->result = $search_result;
           }

            //$v->pagination = HTMLHelper::pagination($page, $count, Url::local('search'));
           
            $v->useTemplate();
	        $this->response($v);
	   }
       
       public function action_tags () {
            $v = new View('site/search_result_tags');
            $lang_search = $this->lang('search');
            $v->vacanciesCategoriList = VacanciesModel::Instance()->GetCategoryListWithoutParetnIdWithCountVacanciesForCategory();
            $v->header = $this->module('Header');
            $v->mainmenu = $this->module('MainMenu');
            $v->footer = $this->module('Footer');
            
            $v->title = $lang_search['title'];
            $v->description = '';
            $v->keywords = '';
            $v->pagination = '';
            $v->og_img = '';
            
            $q = Router::getUriParam(2);
            $q = urldecode($q);
            
            //$q = explode(' ', $q);
            //print_r($q);
            
            $select = 'v.id, v.title, v.short_desc, b.img';
            $from = 'vacancies as v, branch as b ';
            $where = 'MATCH(v.title, v.tags) AGAINST (:query IN BOOLEAN MODE) and valid_status = 1 and v.id_filial = b.id';
            $param = array('query' => $q);
            
            $v->result = LiveSearchModel::Instance()->LiveSearch($select, $from, $where, $param);
            
            $v->useTemplate();
	        $this->response($v);
       }
	}
?>