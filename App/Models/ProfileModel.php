<?php
	class ProfileModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function getAdvList ($id) {
            return DBClass::Instance()->select(
                'publiccompany as p, user_date as ud, users as u',
                array('p.*, ud.company_name, ud.name, ud.lastname, u.login'),
                'valid_status = 1 and show_status = 1 and p.user_id = ud.user_id and p.user_id = u.id and u.id = :id',
                array('id' => (int)$id),
                '',
                'title',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function getListAdvertsForProfile ($id_user, $limit = '12') {
            return DBClass::Instance()->select(
                'adverts as ad',
                array('ad.id, ad.title, ad.seo, ad.description, ad.validate'),
                'ad.idUser = :user_id',
                array('user_id' => (int)$id_user),
                '',
                '',
                false,
                $limit,
                '',
                '2'
            );
        }
        
        public function getListImagesAdvert ($id) {
            $listImgsAdvert = array();
            
            $listImgsAdvert['list'] = DBClass::Instance()->select(
                'advert_imgs as ai',
                array('*'),
                'ai.id_adv = :id_adv',
                array('id_adv' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
            
            $listImgsAdvert['count'] = DBClass::Instance()->getCount('advert_imgs', 'id_adv = :id_adv', array('id_adv' => (int)$id));
            
            return $listImgsAdvert;
        }
        
        public function getAdvertFolderImages ($id_adv) {
            return DBClass::Instance()->select(
                'adverts',
                array('seo'),
                'id = :id',
                array('id' => (int)$id_adv),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function deleteAdvert ($id) {
            DBClass::Instance()->deleteElement('adverts', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('adverts_fields', array('id_advert' => (int)$id));
            DBClass::Instance()->deleteElement('category_advert', array('id_advert' => (int)$id));
            DBClass::Instance()->deleteElement('advert_imgs', array('id_adv' => (int)$id));
        }
        
        public function getAutosearchList ($keywords, $tables) {
			$query = explode(',', $keywords);
            $rez = array();
            
            foreach ($tables as $t) {
                if ($t == 'company') {
                    $select = 'u.id, u.onlineSatus, ud.user_img, ud.name, ud.lastname, ud.about';
                    $from = 'users as u, user_date as ud';
                    $where = 'MATCH(u.login, u.email, ud.name, ud.lastname, ud.mobile, ud.about, ud.company_name, ud.patent) AGAINST (:query IN BOOLEAN MODE) and u.validStatus = 1 and u.id = ud.user_id and ud.type_person = \'4\'';
                    
                    foreach ($query as $k) {
                        $k = trim($k);
                        $param = array('query' => $k.'*');
                        $rez['company'][$k] = DBClass::Instance()->select($from, array($select), $where, $param, '', '', '', '', '', '2');
                    }
                }
                
                if ($t == 'portfolio') {
                    $select = 'p.id, p.portfolio_img, p.name, p.lastname, p.about, u.onlineSatus';
                    $from = 'portfolio as p, users as u';
                    $where = 'MATCH(p.name, p.lastname, p.about) AGAINST (:query IN BOOLEAN MODE) and search_status = 0 and u.validStatus = 1 and u.id = p.id_user';
                    
                    foreach ($query as $k) {
                        $k = trim($k);
                        $param = array('query' => $k.'*');
                        $rez['portfolio'][$k] = DBClass::Instance()->select($from, array($select), $where, $param, '', '', '', '', '', '2');
                    }
                }
                
                if ($t == 'adverts') {
                    $select = 'a.id, a.seo, a.title, a.description';
                    $from = 'adverts as a';
                    $where = 'MATCH(a.title, a.description, a.keywords) AGAINST (:query IN BOOLEAN MODE) and validate = 1';
                    
                    foreach ($query as $k) {
                        $k = trim($k);
                        $param = array('query' => $k.'*');
                        $rez['adverts'][$k] = DBClass::Instance()->select($from, array($select), $where, $param, '', '', '', '', '', '2');
                    }
                }
                
                if ($t == 'vacancies') {
                    $select = 'v.id, v.title, v.short_desc';
                    $from = 'vacancies as v';
                    $where = 'MATCH(v.title, v.short_desc, v.full_desc) AGAINST (:query IN BOOLEAN MODE) and valid_status = 1';
                    
                    foreach ($query as $k) {
                        $k = trim($k);
                        $param = array('query' => $k.'*');
                        $rez['vacancies'][$k] = DBClass::Instance()->select($from, array($select), $where, $param, '', '', '', '', '', '2');
                    }
                }
            }
            return $rez;
		}
        
        public function selectUserAutosearchKeywords ($id) {
			return DBClass::Instance()->select(
                'autosearch',
                array('*'),
                'id_user = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
		}
        
        public function addAutosearchKeywords ($id_user, $keywords, $category_autosearch) {
            return DBClass::Instance()->insert('autosearch', array('id_user' => $id_user, 'keywords' => $keywords, 'tables' => $category_autosearch));
        }
        
        public function numUserKeywords($id) {
            return DBClass::Instance()->getCount('autosearch', 'id_user = :id', array('id' => (int)$id));
        }

		public function deletAautosearchUserKeywords ($id) {
			DBClass::Instance()->deleteElement('autosearch', array('id_user' => (int)$id), '');
		}
        
        public function updUserKeywords ($id_user, $keywords, $category_autosearch) {
            return DBClass::Instance()->update('autosearch', array('id_user' => $id_user, 'keywords' => $keywords, 'tables' => $category_autosearch), 'id_user = :id_user');
        }
        
        public function getUserDate ($id) {
            return DBClass::Instance()->select(
                'users 
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_date ON '.DBClass::Instance()->config['db_pref'].'users.id = '.DBClass::Instance()->config['db_pref'].'user_date.user_id
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type ON '.DBClass::Instance()->config['db_pref'].'user_type.index = '.DBClass::Instance()->config['db_pref'].'user_date.type_person
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_company ON '.DBClass::Instance()->config['db_pref'].'user_type_company.id_user = '.DBClass::Instance()->config['db_pref'].'user_date.user_id
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'type_company_description ON '.DBClass::Instance()->config['db_pref'].'type_company_description.id_lang = 1 AND '.DBClass::Instance()->config['db_pref'].'type_company_description.id_type = '.DBClass::Instance()->config['db_pref'].'user_type_company.id_type_company 
                    LEFT JOIN '.DBClass::Instance()->config['db_pref'].'user_type_description ON '.DBClass::Instance()->config['db_pref'].'user_type_description.id_user_type = '.DBClass::Instance()->config['db_pref'].'user_date.type_person and '.DBClass::Instance()->config['db_pref'].'user_type_description.id_lang = :lang_id',
                array(DBClass::Instance()->config['db_pref'].'user_date.*, '.DBClass::Instance()->config['db_pref'].'users.login, '.DBClass::Instance()->config['db_pref'].'users.onlineSatus, '.DBClass::Instance()->config['db_pref'].'users.email, '.DBClass::Instance()->config['db_pref'].'user_type.type, '.DBClass::Instance()->config['db_pref'].'user_type_description.name as userTypeName, '.DBClass::Instance()->config['db_pref'].'type_company_description.name as companyName, '.DBClass::Instance()->config['db_pref'].'type_company_description.id_type as idTypeCompany'),
                DBClass::Instance()->config['db_pref'].'users.id = :id or '.DBClass::Instance()->config['db_pref'].'users.login = :id',
                array('id' => $id, 'lang_id' => (int)$_SESSION['lid']),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function GetTypesPerson () {
            return DBClass::Instance()->select(
                'user_type as ut, user_type_description as utd',
                array('ut.*, utd.name'),
                'ut.id = utd.id_user_type and utd.id_lang = :lang and ut.index != 0',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function GetTypesCompany () {
            return DBClass::Instance()->select(
                'type_company as ut, type_company_description as utd',
                array('ut.*, utd.name'),
                'ut.id = utd.id_type and utd.id_lang = :lang and ut.active = 1',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getUserSetting ($id) {
            return DBClass::Instance()->select('user_settings', array('*'), 'user_id = :u_id', array('u_id' => (int)$id), '', '', '', '', '', '1');
        }
        
        public function addTypeCompany ($type_company, $id_user) {
            return DBClass::Instance()->insert('user_type_company', array('id_type_company' => $type_company, 'id_user' => $id_user));
        }
        
        public function getTypeUserCompany ($id) {
            return DBClass::Instance()->select('user_type_company', array('id_type_company'), 'id_user = :id', array('id' => (int)$id), '', '', '', '', '', '1');
        }
        
        public function getUserLogo ($id) {
            return DBClass::Instance()->select('user_date', array('user_img'), 'user_id = :id', array('id' => (int)$id), '', '', '', '', '', '1');
        }
        
        public function getUserNameLastnameWithEmail ($email) {
            return DBClass::Instance()->select(
                'users as u, user_date as ud', 
                array('u.login, ud.name, ud.lastname'), 
                'ud.user_id = u.id and u.email = :email', 
                array('email' => $email), 
                '', 
                'name', 
                '', 
                '', 
                '', 
                '1'
            );
        }
        
        public function getUserEmail ($id) {
            return DBClass::Instance()->select('users', array('email'), 'id = :id', array('id' => (int)$id), '', '', '', '', '', '1');
        }
        
        public function getCountIdUserDate($id) {
            return DBClass::Instance()->getCount('user_date', 'user_id = :id', array('id' => (int)$id));
        }
        
        public function getNewUserId ($login) {
            return DBClass::Instance()->select(
                'users', 
                array('id'), 
                'login = :login', 
                array('login' => $login), 
                '', 
                '', 
                '', 
                '', 
                '', 
                '1'
            );
        }
        
        public function addUserDate ($data) {
            return DBClass::Instance()->insert('user_date', $data);
        }
        
        public function updUser ($updData) {
            return DBClass::Instance()->update('users', $updData, 'id = :id');
        }
        
        public function editProfile ($data) {
            return DBClass::Instance()->update('user_date', $data, 'user_id = :user_id');
        }
        
        public function addUserSettings ($data) {
            return DBClass::Instance()->insert('user_settings', $data);
        }
        
        public function editProfileSettings ($data) {
            return DBClass::Instance()->update('user_settings', $data, 'user_id = :user_id');
        }
        
        public function getSeoAdvertsOfUser ($id) {
            return DBClass::Instance()->select('adverts', array('id, seo'), 'idUser = :id', array('id' => (int)$id), '', '', '', '', '', '2');
        }
        
        public function deleteAccount ($id) {
            DBClass::Instance()->deleteElement('users', array('id' => (int)$id), '');
            DBClass::Instance()->deleteElement('user_type_company', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('api_access', array('user_id' => (int)$id), '');
            DBClass::Instance()->deleteElement('branch', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('user_date', array('user_id' => (int)$id), '');
            DBClass::Instance()->deleteElement('vacancies', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('user_settings', array('user_id' => (int)$id), '');
            DBClass::Instance()->deleteElement('adverts', array('idUser' => (int)$id), '');
            $id_portfolio = DBClass::Instance()->select('portfolio', array('id'), 'id_user = :id', array('id' => $id), '', '', '', '', '', '1');
            DBClass::Instance()->deleteElement('categori_portfolio', array('id_portfolio' => $id_portfolio['id']), '');
            DBClass::Instance()->deleteElement('portfolio', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_educations', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_computer', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_languages', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_work_post', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('portfolio_docs', array('id_user' => (int)$id), '');
			DBClass::Instance()->deleteElement('autosearch', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('save_adverts_for_user', array('id_user' => (int)$id), '');
            DBClass::Instance()->deleteElement('vacancie_candidats', array('id_c' => (int)$id), '');
            DBClass::Instance()->deleteElement('vacancie_candidats', array('id_p' => $id_portfolio['id']), '');
            DBClass::Instance()->deleteElement('users_list_for_chat', array('id_user' => $id), '');
            DBClass::Instance()->deleteElement('message_in_the_chat', array('from_user_id' => $id), '');
        }
        
        public function countCandidatsForUser ($id) {
            return DBClass::Instance()->getCount(
                'vacancie_candidats',
                'id_user = :id',
                array('id' => $id)
            );
        }

		public function getTottalCandidats($id) {
			$r = DBClass::Instance()->select(
				'vacancie_candidats as vc, vacancies as v, users as u, portfolio as p',
				array('vc.id, vc.date_add, v.id as v_id, v.title, p.portfolio_img, p.name, p.lastname, p.id as p_id, p.id_user, u.login, u.email'),
				'vc.id_v = v.id and p.id = vc.id_p and u.id = p.id_user and vc.id_user = :id',
				array('id' => $id),
				'',
                'date_add',
                '',
                '',
                '',
                '2'
			);
            
            $rez = array();
            foreach($r as $k => $v) {
                $rez[$v['login']] = array(
                    'id' => $v['id'],
                    'date_add' => $v['date_add'],
                    'v_id' => $v['v_id'],
                    'title' => $v['title'],
                    'login' => $v['login'],
                    'email' => $v['email'],
                    'img_c' => $v['portfolio_img'],
                    'id_user' => $v['id_user'],
                    'name' => $v['name'],
                    'lastname' => $v['lastname'],
                    'candidat' => 'valid'
                );
            }
            return $rez;
		}
        
        public function getTottalCandidatsWithoutPortfolio($id) {
			$r = DBClass::Instance()->select(
				'vacancie_candidats as vc, vacancies as v, users as u, user_date as ud',
				array('vc.id, vc.img_c, vc.date_add, v.id as v_id, v.title, u.login, u.email, ud.user_id as id_user, ud.name, ud.lastname'),
				'vc.id_user = :id AND vc.id_v = v.id and vc.id_c = ud.user_id and vc.id_c = u.id',
				array('id' => $id),
				'',
                'date_add',
                '',
                '',
                '',
                '2'
			);
            
            $rez = array();
            foreach($r as $k => $v) {
                $rez[$v['login']] = array(
                    'id' => $v['id'],
                    'date_add' => $v['date_add'],
                    'v_id' => $v['v_id'],
                    'title' => $v['title'],
                    'login' => $v['login'],
                    'email' => $v['email'],
                    'img_c' => $v['img_c'],
                    'id_user' => $v['id_user'],
                    'name' => $v['name'],
                    'lastname' => $v['lastname'],
                    'candidat' => 'notvalid'
                );
            }
            return $rez;
		}
        
        public function deleteCandidat ($id) {
            DBClass::Instance()->deleteElement('vacancie_candidats', array('id' => (int)$id), '');
        }
        
        public function isAccessIsset($id) {
			return DBClass::Instance()->select(
				'api_access',
				array('id, secret_key, pass, token'),
				'user_id = :user_id',
				array('user_id' => $id),
				'',
                '',
                '',
                '',
                '',
                '1'
			);
		}
        
        public function selectVacanciesForAutoCandidatura ($keywords, $location) {
			return DBClass::Instance()->select(
                'vacancies', 
                array('id, id_user, title, short_desc'), 
                'MATCH(title, short_desc, full_desc) AGAINST (:query IN BOOLEAN MODE) and location = :loc', 
                array('query' => $keywords.'*', 'loc' => $location), 
                '', 
                '', 
                '', 
                '', 
                '', 
                '2'
            );
		}
        
        public function createApiAccess ($data) {
            return DBClass::Instance()->insert('api_access', $data);
        }
        
        public function updateApiToken ($data) {
            return DBClass::Instance()->update('api_access', $data, 'user_id = :user_id');
        }
        
        public function deleteApi_access ($id) {
            DBClass::Instance()->deleteElement('api_access', array('id' => (int)$id), '');
        }
        
        public function getUserLoginEmail ($login, $email) {
           return DBClass::Instance()->select(
                'users as u', 
                array('u.login, u.pass, u.id'), 
                'u.login = :login and u.email = :email', 
                array('login' => $login, 'email' => $email), 
                '', 
                'id', 
                '', 
                '', 
                '', 
                '1'
            );
        }
	}
?>