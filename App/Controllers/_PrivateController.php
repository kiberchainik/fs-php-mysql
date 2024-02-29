<?php
	class PrivateController extends Controller {
	   public function action_index() {
	       if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_main');
           
           $v->title = 'Центр управления палетами!';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->legal_u = PrivateModel::Instance()->getCountLegalUsers();
           $v->individual_u = PrivateModel::Instance()->getCountIndividualUsers();
           $v->portfolo_u = PrivateModel::Instance()->getCountPortfolioUsers();
           $v->adverts_u = PrivateModel::Instance()->getCountAdvertsUsers();
           $v->vacancies_u = PrivateModel::Instance()->getCountVacanciesUsers();
           $v->messages = PrivateModel::Instance()->getListMessages();
           $v->noteData = PrivateModel::Instance()->getNoteData();
           
           if($this->post('saveNote')) {
                if ($this->post('noteId')) $id = $this->post('noteId');
                else $id = '';
                
                $data = array('id' => $id, 'noteText' => htmlspecialchars($this->post('note')));
                
                PrivateModel::Instance()->SaveNode($data, $id);
                $this->redirect(Url::local('private'));
            }
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_sendMessageForUser () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            $msg = 'Ok';
            
            $lang_message = $this->lang('messages');
            
            if (!$this->post('user_id')) $msg = 'Error user_id';
            if (!$this->post('user_email')) $msg = 'Error user_email';
            if ($this->post('user_post_id')) {
                $post = explode('_', $this->post('user_post_id'));
                $postDate = PrivateModel::Instance()->getPostDateForMessage($post[0], $post[1]);
                
                if($postDate) {
                    $message = $this->post('message').'<hr /><a href="'.SITE.'/'.$post[0].'/page/'.$postDate['seo'].'">'.$postDate['title'].'</a>';
                }
            } else $message = $this->post('message');
            if (!$this->post('subject')) $msg = 'Error subject';
            if (!$this->post('message')) $msg = 'Error message';
            
            $add = array(
                'id_user' => $this->post('user_id'),
                'subject' => $this->post('subject'),
                'message' => $message,
                'date_send' => time()
            );
            
            PrivateModel::Instance()->SendMessageFromAdmin($add);
            $message = $lang_message['messages_from_admin'].'<hr />'.$message;
            EmailTPLHelper::SendEmail($this->post('user_email'), $this->post('subject'), $message);
            
           echo json_encode($msg);
        }
       
       /*----- Private Category -----*/
       public function action_category () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_category');
           
           $v->title = 'ЦУП: Список всех категорий в главном меню';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $categoryList = PrivateModel::Instance()->ParentCategoryList();
           $v->categoryList = $this->showCatAdmin($this->getTree($categoryList), 'category_edit', 'category_delete');
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_category_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_editcategory');
           
           $v->title = 'ЦУП: Редактирование категории';
           $v->description = '';
           $v->keywords = '';
           
           $id = Router::getUriParam(2);
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->categoryData = PrivateModel::Instance()->GetCategoryData($id);
            
            $CategoryList = PrivateModel::Instance()->ParentCategoryList();
            $v->categoryList = $this->showCatOption($this->getTree($CategoryList), $v->categoryData['parent_id'],  '&rarr;');
            
            $v->FieldsGroups = PrivateModel::Instance()->getFieldsGroupList();
            $v->FieldsGroupsForCategory = PrivateModel::Instance()->getFieldsGroupListForCategory($id);
            
            $v->FieldsList = PrivateModel::Instance()->getFieldsList();
            
            $v->TypeId = PrivateModel::Instance()->GetTypeList();
            $v->TypesForCategory = PrivateModel::Instance()->GetTypeListForCategory($id);
            
            if ($this->post('category_description')) {
                
                if ($this->post('CategoryImage') == 'image') {
                    if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category');
                    else $image = $v->categoryData['imgicon'];
                } else $image = '';
            
                $editDate = array(
                    'id' => (int)$id,
                    'parent_id' => $this->post('parent_id'),
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> $this->post('CategoryImage')
                );
                
                if($this->post('advertFields')) $advertFields = $this->post('advertFields');
                else $advertFields = '';
                
                $FieldsGoupId = (int)$this->post('FieldsGoupId');
                $TypeId = ($this->post('TypeId'))?$this->post('TypeId'):'0';
                /*echo'<pre>';
                print_r($this->post('category_description'));
                echo'</pre>';*/
               if(!PrivateModel::Instance()->UpdateCategory($editDate, $TypeId, $id, $advertFields, $FieldsGoupId, $this->post('category_description'))) {
                    return 'Категория обновлена';
                } else {
                    return 'Ошибка записи в базу';
                }
            }
           
           $v->useTemplate();
	       $this->response($v);
       }
       
       public function action_getFieldsFromGroup () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            if ($this->post('id')) {
                $ListFieldsForGroup = PrivateModel::Instance()->getListFieldsForCategory($this->post('id'));
                if($this->post('id_cat') and $this->post('id_group')) {
                    $FieldsForCategory = PrivateModel::Instance()->getFieldsForCategory($this->post('id_cat'), $this->post('id_group'));
                    echo json_encode(array('ListFieldsForGroup' => $ListFieldsForGroup, 'FieldsForCategory' => $FieldsForCategory));
                } else {
                    echo json_encode(array('ListFieldsForGroup' => $ListFieldsForGroup));
                }
            }
        }
       
       public function action_category_delete ($arg) {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);

            if(!PrivateModel::Instance()->deletecategory($id)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Категория удалена';
            }
            
            $this->redirect(Url::local('private/category'));
        }
        
        public function action_newcategory () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_newcategory');
           
           $v->title = 'ЦУП: Новая категория';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
            $CategoryList = PrivateModel::Instance()->ParentCategoryList();
            $v->categoryList = $this->showCatOption($this->getTree($CategoryList), '',  '&rarr;');
            
            $v->FieldsGroups = PrivateModel::Instance()->getFieldsGroupList();
            $v->FieldsList = PrivateModel::Instance()->getFieldsList();
            $v->TypeId = PrivateModel::Instance()->GetTypeList();
            
            if($this->post('category_description')) {
                /*echo'<pre>';
                print_r($_POST);
                echo'</pre>';*/
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category');
                else $image = '';
                
                $addDate = array(
                    'parent_id' => ($this->post('parent_id'))?$this->post('parent_id'):'0',
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> ($this->post('CategoryImage'))? $this->post('CategoryImage'):''
                );
                
                if($this->post('advertFields')) $advertFields = $this->post('advertFields');
                else $advertFields = '';
                
               if(!PrivateModel::Instance()->AddNewCategory($addDate, $this->post('TypeId'), $advertFields, $this->post('category_description'))) {
                    return 'Категория добавлена';
                } else {
                    return 'Ошибка записи в базу';
                }
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        /*----- /Private Category -----*/
        
        /*----- Private Type adverts -----*/
        public function action_typeadverts () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_typeadverts');
           
           $v->title = 'ЦУП: Все типы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
            $v->TypeList = PrivateModel::Instance()->GetTypeList();
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_typeadverts_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_typeadverts_new');
           
           $v->title = 'ЦУП: Добавление нового типа';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
            
           if($this->post('nameType')) {
                $addDate = array(
                    'active' => ($this->post('deactivate') == '0')?'0':'1',
                    'name' => $this->post('nameType')
                );
                
                if(!PrivateModel::Instance()->AddNewType($addDate)) {
                    return 'Тип объявления добавлен';
                } else {
                    return 'Ошибка записи в базу';
                }
            }
           
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_typeadverts_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_typeadverts_edit');
           
           $v->title = 'ЦУП: Редактирование типа';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->id = Router::getUriParam(2);
           $TypeData = PrivateModel::Instance()->GetTypeData($v->id);
            
            foreach ($TypeData as $k => $val) {
                $attType[$val['id_lang']] = array (
                    'name' => $val['name']
                );
            }
            $v->typeData = $attType;
           
           if ($this->post('nameType')) {
                $addDate = array(
                    'active' => ($this->post('deactivate') == '0')?'0':'1',
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->UpdDate($addDate, $v->id);
            }
            $v->GetActiveTypeAdverts = PrivateModel::Instance()->GetActiveTypeAdverts($v->id);
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_typeadverts_delete () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
            if(!PrivateModel::Instance()->deletetype($id)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Категория удалена';
            }
            
            $this->redirect(Url::local('private/typeadverts'));
        }
        /*----- /Private Type adverts -----*/
        
        /*----- Private Type company -----*/
        public function action_typecompany () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_typecompany');
           
           $v->title = 'ЦУП: Все типы компаний';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
            $v->TypeList = PrivateModel::Instance()->GetTypeCompanyList();
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_typecompany_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_typecompany_new');
           
           $v->title = 'ЦУП: Добавление нового типа компании';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
            
           if($this->post('nameType')) {
                $addDate = array(
                    'active' => ($this->post('deactivate') == '0')?'0':'1',
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->AddNewTypeCompany($addDate);
            }
           
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_typecompany_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_typecompany_edit');
           
           $v->title = 'ЦУП: Редактирование типа компании';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->id = Router::getUriParam(2);
           $TypeData = PrivateModel::Instance()->GetTypeCompanyData($v->id);
            
            foreach ($TypeData as $k => $val) {
                $attType[$val['id_lang']] = array (
                    'name' => $val['name']
                );
            }
            $v->typeData = $attType;
           
           if ($this->post('nameType')) {
                $addDate = array(
                    'active' => ($this->post('deactivate') == '0')?'0':'1',
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->UpdDateTypeCompany($addDate, $v->id);
            }
            $v->GetActiveTypeAdverts = PrivateModel::Instance()->GetActiveTypeCompany($v->id);
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_typecompany_delete () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
            if(!PrivateModel::Instance()->deletetype($id)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Категория удалена';
            }
            
            $this->redirect(Url::local('private/typeadverts'));
        }
        /*----- /Private Type company -----*/
        
        /*----- Private category of vacancie -----*/
        public function action_categoryvacancies () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $v = new View('private/p_category_vac');
           
           $v->title = 'ЦУП: Все категории вакансий';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $CategoryList = PrivateModel::Instance()->ParentCategoryVacancieList();
            $v->categoryList = $this->showCatAdmin($this->getTree($CategoryList), 'categoryvacancies_edit', 'categoryvacancies_delete');
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_categoryvacancies_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $v = new View('private/p_category_vac_new');
           
           $v->title = 'ЦУП: Новая категория для вакансии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $v->lang = PrivateModel::Instance()->GetLangNum();
            $CategoryList = PrivateModel::Instance()->ParentCategoryVacancieList();
            $v->CategoryList = $this->showCatOption($this->getTree($CategoryList), '', '&rarr;');
            
            if($this->post('seoTitle')) {
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category/vacancies');
                else $image = '';
                
                $addDate = array(
                    'parent_id' => ($this->post('parent_id'))?$this->post('parent_id'):'0',
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> ($this->post('CategoryImage'))?$this->post('CategoryImage'):''
                );
                //return $post;
               PrivateModel::Instance()->AddNewCategoryVacancie($addDate, $this->post('category_description'));
            }
            /*echo'<pre>';
                print_r($data['Lang']);
                echo'</pre>';*/
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_categoryvacancies_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $v = new View('private/p_category_vac_edit');
           
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
            
            if ($this->post('seoTitle')) {
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'category');
                else $image = '';
                
                $editDate = array(
                    'id' => (int)$id,
                    'parent_id' => $this->post('parent_id'),
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> $this->post('CategoryImage')
                );
                
                PrivateModel::Instance()->UpdateCategoryVacancie($editDate, $id, $this->post('category_description'));
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_categoryvacancies_delete () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);

            if(!PrivateModel::Instance()->deletecategoryvacancies($id)) {
                $_SESSION['message'] = 'Ошибка удаления';
            } else {
                $_SESSION['message'] = 'Категория удалена';
            }
            
            $this->redirect(Url::local('private/categoryvacancies'));
        }
        /*----- /Private category of vacancie -----*/
        
        /*----- Private adverts -----*/
        public function action_adverts () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_adverts_list');
           
           $v->title = 'ЦУП: Все объявления';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $CategoryList = PrivateModel::Instance()->ParentCategoryList();
           $v->categoryList = $this->showCatOption($this->getTree($CategoryList), '',  '&rarr;');
           
           $p_page = Router::getUriParam('page'); // p. num
           
           $count = PrivateModel::Instance()->countAdvertsForPage(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->adverts = PrivateModel::Instance()->getAdvertListForPage($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('private/adverts'));
           /*echo'<pre>';
            print_r($v->adverts);
            echo'</pre>';*/
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_life_search_adverts () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchAdverts($this->post('search_tag'), $this->post('cat_id'));
            
            echo json_encode($search_result);
        }
        
        public function action_p_adverts_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_adverts_edit');
           
           $v->title = 'ЦУП: Редатирование объявления';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam(2);
           $AdvertData = AdvertsModel::Instance()->getAdvertDataForView($p_page);
                
            $listImgs = AdvertsModel::Instance()->getListImagesAdvert($p_page);
            $AdvertData['imgs'] = $listImgs['list'];
            
            $AdvertData['fieldsAdvert'] = AdvertsModel::Instance()->getFieldsForAdvert($p_page, '', $_SESSION['lid']);
            $data['TypesOfAdvert'] = TypeAdvertsModel::Instance()->TypesOfCategoryList($p_page, $_SESSION['lid']);
            $CategoryAdvert = CategoryModel::Instance()->getCategoryesForAdvert($p_page);
            $AdvertData['mainCategory'] = $CategoryAdvert['mainCategory']['id_category'];
            $AdvertData['subCategory'] = $CategoryAdvert['subCategory'];
            
            $subSelects = array();
            $i = 0;           
            foreach ($AdvertData['subCategory'] as $k => $val) {
                $i++;
                $subSelects[$i] = CategoryModel::Instance()->Selects($val['parent_id'], $val['id_category']);
                $subSelects[$i]['parent'] = $val['parent_id'];
            }
            
            $v->AdvertData = $AdvertData;
            $v->subSelects = $subSelects;
            $v->CategoryList = CategoryModel::Instance()->GetCategoryListWithoutParetnId();
            $v->fieldsAdvert = AdvertsModel::Instance()->getFieldsForAdvert($v->advertData['id']);
           
           
           /*echo'<pre>';
            print_r($AdvertData);
            echo'</pre>';*/
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_p_adverts_saveedit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
           $p_page = Router::getUriParam(2);
           $v = new View('editadvert');
           $lang_advert = $this->lang('editadvert');
            
            $msg = array(
                'errors' => array(),
                'success' => array()
            );
            
            $advert = array();
            
            $advert['data']['id'] = $p_page;
            
            if(!$this->post('title')) {
                $msg['errors']['title'] = $lang_advert['newadvert_add_error_empty_title'];
            } else {
                $advert['data']['title'] = str_replace('/', '-', $this->post('title'));
                
                if (HTMLHelper::isRuLetters($this->post('title'))) {
                    $title = strtr($advert['data']['title'], array(' ' => '_'));
                    $advert['data']['seo'] = HTMLHelper::TranslistLetterRU_EN($title);
                } else $advert['data']['seo'] = strtr($advert['data']['title'], array(' ' => '_'));
            }
            
            if(!$this->post('keywords')) $msg['errors']['keywords'] = $lang_advert['newadvert_add_error_empty_keywords'];
            else $advert['data']['keywords'] = $this->post('keywords');
            
            if($this->post('category') == '0' or $this->post('subCategory') == '0') {
                $msg['errors']['category'] = $lang_advert['newadvert_add_error_empty_category'];
            } else {
                $advert['mainCategory'] = $this->post('category');
                $advert['subCategory'] = $this->post('subCategory');
            }

            
            if($this->post('typeCategory')) {
                if($this->post('typeCategory') == '0') $msg['errors']['typeCategory'] = $lang_advert['newadvert_add_error_empty_type'];
                else $advert['data']['id_type'] = $this->post('typeCategory');
            }
            
            if(!$this->post('description')) $msg['errors']['description'] = $lang_advert['newadvert_add_error_empty_description'];
            else $advert['data']['description'] = $this->post('description');
            
            $advert['data']['comments_permission'] = $this->post('comments');
                                    
            if(!$this->post('fullTextAdvert')) $msg['errors']['fullTextAdvert'] = $lang_advert['newadvert_add_error_empty_fulltext'];
            else $advert['data']['textAdvert'] = $this->post('fullTextAdvert');
            
            // Проходим по массиву
            foreach ($_POST as $key => $value) {
                unset($_POST[$key]);               // Удаляем элемент...
                if ($key == 'fullTextAdvert') {   // Но если ключ равен fullTextAdvert, то прекращаем
                    break;
                }
            }
            
            $AdvertImages = AdvertsModel::Instance()->getListImagesAdvert($p_page);
            if($AdvertImages['count']['numCount'] == 0) {
                if(empty($_FILES['images_advert']['name'][0])) $msg['errors']['images_advert'] = $lang_advert['empty_images_advert'];
            }
            
            if(isset($_FILES['images_advert']) and !empty($_FILES['images_advert']['name'][0])) {
                $advert['imgs'] = $this->app->lib_Validation->ValidMoreImages($_FILES['images_advert'], 'adverts/'.$p_page);
            }
            
            if (empty($msg['errors'])) {
                AdvertsModel::Instance()->editAdverts($advert);
                if(isset($_POST['id_fields_group'])){
                    foreach($_POST as $k => $v) {
                        if (strpos($k, '_id') !== false) $id_field = $v;
                        else {
                            if (strpos($v, '_') !== false) $data_v = explode('_', $v);
                            $fields[] = array(
                                'field_name' => $k,
                                'field_value' => (isset($data_v[1]))?$data_v[1]:$v,
                                'id_advert' => $p_page,
                                'val_inter_sel' => (isset($data_v[0]))?$data_v[0]:'0',
                                'id_field_group' => $this->post('id_fields_group'),
                                'id_field' => ($k == 'id_fields_group')?NULL:$id_field
                            );
                        }
                        unset($data_v);
                    }
                    AdvertsModel::Instance()->editsAdvertFields($fields, $p_page);
                }
                $msg['success'][] = $lang_advert['added_success'];
            }
            
            echo json_encode($msg);
            //print_r($fields);
        }
        
        public function action_p_adverts_upd_valid () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $p_page = Router::getUriParam(2);
           
            PrivateModel::instance()->UpdValidStatus(array('validate' => 1, 'id' => $p_page));
            $this->redirect(Url::local('private/adverts'));
        }
        
        public function action_p_adverts_deleteimg () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            $imgName = Router::getUriParam(3);
            $folderName = Router::getUriParam(4);
            
            if(unlink($_SERVER['DOCUMENT_ROOT'].'/Media/images/adverts/'.$id.'/'.$imgName.'.png')) {
                $list = scandir($_SERVER['DOCUMENT_ROOT'].'/Media/images/adverts/'.$id.'/');
                // РµСЃР»Рё РґРёСЂРµРєС‚РѕСЂРёРё РЅРµ СЃСѓС‰РµСЃС‚РІСѓРµС‚
                if (!$list) $msg = 'Directori not exists';
                
                // СѓРґР°Р»СЏРµРј . Рё ..
                unset($list[0],$list[1]);
                
                if(!AdvertsModel::Instance()->deleteImageFromAdvert($id, $imgName)) $msg = $addadvert['success_delete_img'];
            } else {
                $msg = $addadvert['error_delete_img'];
            }
            
            $this->redirect('/private/p_adverts_edit/'.$id);
        }
       
       public function action_p_adverts_delete () {
            if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	        }
        
            $p_page = Router::getUriParam(2);
            
            if(empty($p_page)) {
                $this->redirect('/profile');
            } else {
                $u_date = AuthClass::instance()->getUser();
                //$get_adv = AdvertsModel::Instance()->ifAuthuserIsAuthor($u_date['u_id'], $p_page);

                //if(!empty($get_adv)) {
                    //$result_delete = DelHelper::DeleteImages('adverts/'.$p_page);
                    DelHelper::DeleteImages('adverts/'.$p_page);
                    AdvertsModel::Instance()->deleteAdvert($p_page);
                    $this->redirect('/private/adverts');
                //}
            }
        }
        /*----- /Private adverts -----*/
        
        /*----- Private vacancies -----*/
        public function action_vacancies () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_vacancies');
           
           $v->title = 'ЦУП: Все вакансии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $categoryList = VacanciesModel::Instance()->GetCategoryListWithoutParetnId();
           $v->categoryListForVacancies = $this->showCatOption($this->getTree($categoryList), '', '-');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getVacanciesCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->vacancies = PrivateModel::Instance()->getVacanciesPage($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('private/vacancies'));
           /*echo'<pre>';
            print_r($v->vacancies);
            echo'</pre>';*/
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_life_search_vacancies () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchVacancies($this->post('search_tag'), $this->post('cat_id'));
            
            echo json_encode($search_result);
        }
        
        public function action_p_vacancies_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_vacancies_edit');
           
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
        
        public function action_p_vacancies_saveedit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
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
        
        public function action_p_vacancies_upd_valid () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $p_page = Router::getUriParam(2);
           
            PrivateModel::instance()->UpdVacanciesValidStatus(array('valid_status' => 1, 'id' => $p_page));
            $this->redirect(Url::local('private/vacancies'));
        }
       
       public function action_p_vacancies_delete () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
        
            $p_page = Router::getUriParam(2);
            
            if(empty($p_page)) {
                $this->redirect('/profile');
            } else {
                VacanciesModel::Instance()->deleteVacancies($p_page);
                $this->redirect(Url::local('private/vacancies'));
            }
        }
        /*----- /Private vacancies -----*/
        
        /*----- /Private vacancies -----*/
        public function action_adverts_moderation () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_adverts_moderation');
           
           $v->title = 'ЦУП: Все объявления';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->adverts = PrivateModel::Instance()->getAdvertListForModeration();
           
           $v->useTemplate();
	       $this->response($v);
        }
        /*----- /Private vacancies -----*/
        
        /*----- Private fields group -----*/
        public function action_fieldsgroup () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_fieldsgroup');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->fieldsgroup = PrivateModel::Instance()->getFieldsGroup();
           
           $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_p_fieldsgroup_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_fieldsgroup_new');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            if($this->post('title')) {
                $fieldDate = array(
                    'title' => $this->post('title'),
                    'description' => $this->post('desc')
                );
                
                PrivateModel::Instance()->addFieldGroup($fieldDate);
            }
            /*echo '<pre>';
            print_r($fieldDate);
            echo '</pre>';*/
            $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_p_fieldsgroup_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_fieldsgroup_edit');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $id = Router::getUriParam(2);
            
            if($this->post('title')) {
                $fieldDate = array(
                    'title' => $this->post('title'),
                    'description' => $this->post('desc'),
                    'id' => $id
                );
                
                PrivateModel::Instance()->UpdDateFieldsGroup($fieldDate, $id);
            }
            
            $v->fieldDate = PrivateModel::Instance()->getFieldGroupData($id);
            //$data['fieldDate']['categoryes'] = PrivateModel::Instance()->getCategoryForFields($id);
            //$data['fieldDate']['types'] = PrivateModel::Instance()->getTypeForFields($id);
            
            /*echo '<pre>';
            print_r($fieldDate);
            echo '</pre>';*/
            $v->useTemplate();
	       $this->response($v);
        }
        
        public function action_p_fieldsgroup_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
            PrivateModel::Instance()->deleteFieldsGroup($id);
            
            $this->redirect(Url::local('private/fieldsgroup'));
        }
        /*----- /Private fields group -----*/
        
        /*----- Private fields of group -----*/
        public function action_fields() {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_fields');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->FieldsList = PrivateModel::Instance()->getFieldsList();
            /*echo '<pre>';
            print_r($data['FieldsList']);
            echo '</pre>';*/
            $v->useTemplate();
	        $this->response($v);
        }
        
        /*public function sort ($sort) {
            $this->AuthUser();
            
            $_SESSION['sort'] = $sort[0];
            
            header('Location: /lptf_admin/fields');
        }*/
        
        public function action_p_fields_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_fields_new');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $v->FieldsGroupList = PrivateModel::Instance()->getFieldsGroupList();
            $v->TypeList = PrivateModel::Instance()->GetTypeList();
            
            if($this->post('namefield')) {
                $fieldDate = array(
                    'placeholder' => $this->post('placeholder'),
                    'type' => $this->post('typefield'),
                    'name' => $this->post('namefield'),
                    'value' => $this->post('valuefield'),
                    'id_style' => $this->post('id_stylefield'),
                    'class_style' => $this->post('class_stylefield')
                );
                if ($this->post('typeCategory') != '0') {
                    $fieldDate['typeCategory'] = $this->post('typeCategory');
                }
                
                if($this->post('id_group')) $id_group = $this->post('id_group');
                else $id_group = '';
                
                PrivateModel::Instance()->addField($fieldDate, $id_group);
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_p_fields_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_fields_edit');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $id = Router::getUriParam(2);
            $v->FieldsGroupList = PrivateModel::Instance()->getFieldsGroupList();
            $v->TypeList = PrivateModel::Instance()->GetTypeList();
            $v->getFieldsGroupForField = PrivateModel::Instance()->getFieldsGroupForField($id);
            $v->getFieldsForTypeList = PrivateModel::Instance()->getFieldsForTypeList($id);
            $v->fieldDate = PrivateModel::Instance()->getFieldData($id);
            
            if($this->post('namefield')) {
                
                $fieldDate = array(
                    'placeholder' => $this->post('placeholder'),
                    'type' => $this->post('typefield'),
                    'name' => $this->post('namefield'),
                    'value' => $this->post('valuefield'),
                    'id_style' => $this->post('id_stylefield'),
                    'class_style' => $this->post('class_stylefield')
                );
                
                if ($this->post('typeCategory') != '0') {
                    $fieldDate['typeCategory'] = $this->post('typeCategory');
                }
                
                if($this->post('id_group')) $id_group = $this->post('id_group');
                else $id_group = '';
                
                PrivateModel::Instance()->UpdFieldDate($fieldDate, $id_group, $id);
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_p_fields_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
            $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->deleteFields($id);
            
            $this->redirect(Url::local('private/fields'));
        }
        /*----- /Private fields of group -----*/
        
        /*----- Private FQBlog -----*/
        public function action_blog () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_blog');
           
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
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('private/blog'));
           
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_life_search_articles () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchArticle($this->post('search_tag'), $this->post('cat_id'));
            
            echo json_encode($search_result);
        }
        
        public function action_blog_category () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_blog');
           
           $v->title = 'ЦУП: Поля групп';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $CategoryList = PrivateModel::Instance()->ParentBlogList();
            $v->CategoryList = $this->showCatAdmin($this->getTree($CategoryList), 'p_categoryblog_edit', 'p_categoryblog_trash');
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_p_categoryblog_new () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_blogcategory_new');
           
           $v->title = 'ЦУП: Создание категории для блога';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
            $CategoryList = PrivateModel::Instance()->ParentBlogList();
            $v->CategoryList = $this->showCatOption($this->getTree($CategoryList), '', '&rarr;');
            
            if($this->post('seoTitle')) {
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'blogcategory');
                else $image = '';
                
                $addDate = array(
                    'parent_id' => ($this->post('parent_id'))?$this->post('parent_id'):'0',
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> ($this->post('CategoryImage'))?$this->post('CategoryImage'):''
                );
                
               PrivateModel::Instance()->AddNewCategoryBlog($addDate, $this->post('category_description'));
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_p_categoryblog_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_blogcategory_edit');
           
           $v->title = 'ЦУП: Редактирование категории для блога';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->categoryData = PrivateModel::Instance()->GetBlogCategoryData($id);
            
            $CategoryList = PrivateModel::Instance()->ParentBlogList();
            $v->CategoryList = $this->showCatOption($this->getTree($CategoryList), $v->categoryData['parent_id'],  '&rarr;');
            
            if ($this->post('seoTitle')) {
                if(isset($_FILES['CategoryLogo']) and !empty($_FILES['CategoryLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['CategoryLogo'], 'blogcategory/');
                elseif (!empty($v->categoryData['imgicon'])) $image = $v->categoryData['imgicon'];
                else $image = '';
                
                $editDate = array(
                    'id' => (int)$id,
                    'parent_id' => $this->post('parent_id'),
                    'seo' => $this->post('seoTitle'),
                    'imgicon' => $image,
                    'icon' => $this->post('CatecoryIconCode'),
                    'mediaSet'=> $this->post('CategoryImage')
                );
                
               PrivateModel::Instance()->UpdateCategoryBlog($editDate, $id, $this->post('category_description'));
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_p_categoryblog_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
           $img = PrivateModel::Instance()->getImageCategoryBlog($id);
           $img = explode('/', $img['imgicon']);
           
           DelHelper::DeleteFile('images/blogcategory/'.$img[4]);
           
           PrivateModel::Instance()->deletecategoryblog($id);
            
           $this->redirect(Url::local('private/blog_category'));
        }
        
        public function action_blog_newart () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_blog_newart');
           
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
        
        public function action_p_article_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_blog_editart');
           
           $v->title = 'ЦУП: Редактирование';
           $v->description = '';
           $v->keywords = '';
           
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
            
            $v->title = $ArticleData['artDesc'][1]['title'];
            $v->ArticleData = $ArticleData;
            
            if ($this->post('seoTitle')) {
                $v->upd_message = '';
                if(isset($_FILES['artLogo']) and !empty($_FILES['artLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['artLogo'], 'blog/articles/'.$this->post('seoTitle'));
                elseif (!empty($ArticleData['logo'])) $image = $ArticleData['logo']; 
                else $error = 'Logo empty!'; //$image = '';
                
                if($this->post('artcategory') == '0') $error = 'Нужно обязательно выбрать категорию';
                if (!$this->post('seoTitle')) $error = 'Seo title пуст';
                //if(!$this->post('showart')) $error = 'Select show article!';
                
                foreach ($this->post('category_description') as $lang_key => $val) {
                    if(empty($val['title'])) $error = 'Write <b>title</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['keywords'])) $error = 'Write <b>keywords</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['description'])) $error = 'Write <b>description</b> for lang <b>"'.$lang_key.'"</b>!';
                }
                
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
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
           $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->UpdValidArtStatus(array('show_status' => 1, 'id' => $id));
            $this->redirect(Url::local('private/blog'));
        }
        
        public function action_p_article_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
           $id = Router::getUriParam(2);
           
           $img = PrivateModel::Instance()->getArticleDataForView($id);
           $img = explode('/', $img['logo']);
           
           DelHelper::DeleteFile('images/blog/articles/'.$img[4].'/'.$img[5]);
           
           PrivateModel::Instance()->deleteArtBlog($id);
            
           $this->redirect(Url::local('private/blog'));
        }
        /*----- /Private FQBlog -----*/
        
        /*----- /Private informaton letters -----*/
        public function action_information () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_information');
           
           $v->title = 'ЦУП: Редактирование';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->pages = PrivateModel::Instance()->getPagesList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_information_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_information_new');
           
           $v->title = 'ЦУП: Информация';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           if($this->post('page_description')[1]['title']) {
                $addDate = array(
                    'seo' => HTMLHelper::TranslistLetterRU_EN($this->post('page_description')[1]['title']),
                    'date' => time()
                );
            
                PrivateModel::Instance()->AddNewPage($addDate, $this->post('page_description'));
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_information_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_information_edit');
           
           $v->title = 'ЦУП: Редактирование';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           $id = Router::getUriParam(2);
           $v->lang = PrivateModel::Instance()->GetLangNum();
           
           $v->pageData = PrivateModel::Instance()->GetPageData($id);
           
           if($this->post('page_description')[1]['title']) {
                $editDate = array(
                    'id' => $id,
                    'seo' => HTMLHelper::TranslistLetterRU_EN($this->post('page_description')[1]['title']),
                    'date' => time()
                );
            
                PrivateModel::Instance()->UpdatePage($editDate, $id, $this->post('page_description'));
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_information_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
           PrivateModel::Instance()->deleteInfoPage($id);
           
           $this->redirect(Url::local('private/information'));
        }
        /*----- /Private informaton letters -----*/
        
        /*----- Private users -----*/
        public function action_allusers () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_allusers');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getUsersCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->UserList = PrivateModel::Instance()->getUserList($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('private/allusers'));
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_life_search_user () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchUser($this->post('user'));
            
            echo json_encode($search_result);
        }
        
        public function action_life_search_portfolio () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	        } else $this->redirect(Url::local('login'));
            
            $search_result = PrivateModel::Instance()->lifeSearchPortfolio($this->post('user'));
            
            echo json_encode($search_result);
        }
        
        public function action_portfolio () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio');
           
           $v->title = 'ЦУП: Резюме на сайте';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = PrivateModel::Instance()->getPortfolioCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->portfolioList = PrivateModel::Instance()->getAllPortfolio($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('private/portfolio'));
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_interests () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_interests');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->interestsList = PrivateModel::Instance()->GetInterestsList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_interests_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_interests_new');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'interest' => $this->post('interest')
                );
                
                if(PrivateModel::Instance()->addInterests($addDate));
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_interests_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_interests_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользовательские интересы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->interestsData = PrivateModel::Instance()->GetInterestsData($id);
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'interest' => $this->post('interest')
                );
                
                PrivateModel::Instance()->editInterests($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_interests_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteInterests($id);
           $this->redirect(Url::local('private/portfolio_interests'));
        }
        
        public function action_portfolio_hobbi () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_hobbi');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->hobbiList = PrivateModel::Instance()->GetHobbiList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_hobbi_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_hobbi_new');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'hobbi' => $this->post('hobbi')
                );
                
                PrivateModel::Instance()->addHobbi($addDate);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_hobbi_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_hobbi_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользовательские интересы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->hobbiData = PrivateModel::Instance()->GetHobbiData($id);
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'hobbi' => $this->post('hobbi')
                );
                
                PrivateModel::Instance()->editHobbi($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_hobbi_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteHobbi($id);
           $this->redirect(Url::local('private/portfolio_hobbi'));
        }
        
        public function action_portfolio_assests () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_assests');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->assestsList = PrivateModel::Instance()->GetAssestsList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_assests_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_assests_new');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'assests' => $this->post('assests')
                );
                
                PrivateModel::Instance()->addAssests($addDate);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_assests_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_portfolio_assests_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользовательские интересы';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->assestsData = PrivateModel::Instance()->GetAssestsData($id);
           
           if($this->post('active') == '0' or $this->post('active') == '1') {
                $addDate = array(
                    'active' => $this->post('active'),
                    'assests' => $this->post('assests')
                );
                
                PrivateModel::Instance()->editAssests($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_portfolio_assests_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteAssests($id);
           $this->redirect(Url::local('private/portfolio_assests'));
        }
        
        public function action_usertypes () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_usertypes');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->TypeList = PrivateModel::Instance()->GetUsersTypeList();
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_usertypes_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_usertypes_new');
           
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           if($this->post('nameType')) {
                $addDate = array(
                    'index' => $this->post('index'),
                    'type' => $this->post('type'),
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->AddNewUserType($addDate);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        public function action_usertypes_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_usertypes_edit');
           $v->lang = PrivateModel::Instance()->GetLangNum();
           $id = Router::getUriParam(2);
           $v->title = 'ЦУП: Пользователи';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->TypeData = PrivateModel::Instance()->GetUserTypeData($id);
            $TypeDataDescription = PrivateModel::Instance()->GetUserTypeDataDescription($id);
            
            foreach ($TypeDataDescription as $k => $val) {
                $TypeDataDescription[$val['id_lang']] = array (
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'id_user_type' => $val['id_user_type']
                );
            }
            $v->TypeDataDescription = $TypeDataDescription;
            
            if ($this->post('nameType')) {
                $addDate = array(
                    'index' => $this->post('index'),
                    'type' => $this->post('type'),
                    'name' => $this->post('nameType')
                );
                
                PrivateModel::Instance()->updUserTypeDate($addDate, $id);
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        public function action_usertypes_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           PrivateModel::Instance()->deleteUserType($id);
           
           $this->redirect(Url::local('private/usertypes'));
        }
        
        public function action_p_user_details () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_users_details');
           $login = Router::getUriParam(2);
           $v->title = 'ЦУП: Детали пользователя';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->userDate = PrivateModel::Instance()->getUserDateForDetailsPage($login);
           $v->UserAdverts = PrivateModel::Instance()->getUserAdverts($v->userDate['id']);
           $v->review = PrivateModel::Instance()->getUserReview($v->userDate['id']);
           $v->portfolio = PrivateModel::Instance()->getUserPortfolio($v->userDate['id']);
           
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_p_user_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $login = Router::getUriParam(2);
           $getUserId = PrivateModel::getUserId($login);
           
           PrivateModel::deleteUser($getUserId['id']);
           
           $ifUserHaveAdv = PrivateModel::getUserAdverts($getUserId['id']);
           foreach ($ifUserHaveAdv as $k) {
                AdvertsModel::Instance()->deleteAdvert($k['id']);
            }
           
           $this->redirect(Url::local('private/allusers'));
        }
        
        public function action_p_user_lock () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $this->redirect(Url::local('private/allusers'));
        }
        /*----- /Private users -----*/
        
        /*----- FQ support -----*/
        public function action_contacts () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_contacts');
           
           $v->title = 'ЦУП: Пользовательские письма';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $MessageList = PrivateModel::Instance()->GetMessageList();
            
            foreach ($MessageList as $k => $val) {
                if (!empty($val['user_id'])) {
                    $MessageList[$k]['userData'] = PrivateModel::Instance()->getUserDateForDetailsPage($val['user_id']);
                    $MessageList[$k]['respond_msg']  = PrivateModel::Instance()->getRespond($val['id']);
                }
            }
            $v->MessageList = $MessageList;
            /*echo '<pre>';
            print_r($data['MessageList']);
            echo '</pre>';*/
            
            $v->useTemplate();
           $this->response($v);
        }
        
        public function action_respond() {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $m_id = Router::getUriParam(2);
            
            if($this->post('subject')) {
                $add = array(
                    'id_message' => $m_id,
                    'user_id' => ($this->post('user_id_to'))?'0':$this->post('user_id_to'),
                    'user_name_to' => $this->post('user_name_to'),
                    'subject' => $this->post('subject'),
                    'email_to' => $this->post('user_email_to'),
                    'message' => $this->post('message'),
                    'date_send' => time()
                );
                
                PrivateModel::Instance()->AddRespond($add);
                $message = 'Message from Administration: <br />'.$this->post('message');
                EmailTPLHelper::SendEmail($this->post('user_email_to'), $this->post('subject'), $message);
                
                $this->redirect(Url::local('private/contacts'));
            }
        }
        
		public function action_spamlist () {
			if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
			$add = Router::getUriParam(2);
			PrivateModel::Instance()->AddToSpam($add);
		}

        public function action_p_contact_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            PrivateModel::Instance()->delete($id);
            
            $this->redirect(Url::local('private/contacts'));
        }
        /*----- /FQ support -----*/
        
        /*----- FQ comments -----*/
        public function action_comments () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_comments');
           
           $v->title = 'ЦУП: Пользовательские коммнетраии';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->comments = PrivateModel::Instance()->GetComList();
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_comments_respond() {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            
            $add = array(
                'parent_id' => $id,
                'email' => ($u_date['email'])?$u_date['email']:$this->post('email'),
                'name' => ($u_date['name'])?$u_date['name']:$this->post('name'),
                'date' => time(),
                'advert_id' => $this->post('advert_id'),
                'user_id' => ($u_date['u_id'])?$u_date['u_id']:'0',
                'message' => $this->post('message'),
                'moderation' => '0',
                'plus' => '0',
                'minus' => '0'
            );
            
            PrivateModel::Instance()->AddCommentRespond($add);
            $message = 'New reply to comment from Administration: <br />'.$this->post('message');
            EmailTPLHelper::SendEmail($this->post('email'), 'New reply to comment FQ', $message);
            
            $this->redirect(Url::local('private/comments'));
        }
        
        public function action_comments_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->UpdValidCommentStatus($id);
            $this->redirect(Url::local('private/comments'));
        }
        
        public function action_comments_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            
            PrivateModel::Instance()->deleteComment($id);
            $this->redirect(Url::local('private/comments'));
        }
        /*----- /FQ comments -----*/
        
        /*----- FQ Public -----*/
        public function action_public () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_public');
           
           $v->title = 'ЦУП: Пользовательская реклама';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->public = PrivateModel::Instance()->GetPublicList();
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_public_trash () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $id = Router::getUriParam(2);
            DelHelper::DeleteFile('images/blog/articles/'.$img[4].'/'.$img[5]);
            PrivateModel::Instance()->deletePublicCompany($id);
            
            $this->redirect(Url::local('private/public'));
        }
        /*----- /FQ Public -----*/
        
        /*----- FQ Settings -----*/
        public function action_settings () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_settings');
           
           $v->title = 'ЦУП: Настройка портала';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           $v->settings = PrivateModel::Instance()->GetSettings();
           //$v->lang = PrivateModel::Instance()->GetLangNum();
           $v->langs = PrivateModel::Instance()->GetLangList();
           
           if($this->post('title')) {
                if(isset($_FILES['logo']) and !empty($_FILES['logo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['logo'], 'siteLogo');
                else $image = '';
                
                $addDate = array();
                
                $addDate['title'] = $this->post('title');
                $addDate['keywords'] = $this->post('keywords');
                $addDate['description'] = $this->post('description');
                $addDate['lang_default'] = $this->post('lang_default');
                $addDate['logo'] = $image;
                $addDate['tec_work'] = $this->post('tec_work');
                $addDate['admin_name'] = $this->post('admin_name');
                $addDate['admin_mobile'] = $this->post('admin_mobile');
                $addDate['admin_email'] = $this->post('admin_email');
                $addDate['admin_adres'] = $this->post('admin_adres');
                
                if (!$v->settings) $save = PrivateModel::Instance()->insertSettingsData($addDate);
                else {
                    $addDate['id'] = '1';
                    $save = PrivateModel::Instance()->updSettingsData($addDate);
                }
                
                /*echo '<pre>';
                print_r($addDate);
                echo '</pre>';*/
            }
           
           $v->useTemplate();
           $this->response($v);
        }
        /*----- /FQ Settings -----*/
        
        /*----- FQ Languages -----*/
        public function action_language () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_language');
           
           $v->title = 'ЦУП: Настройка языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
            $v->LangList = PrivateModel::Instance()->GetLangList();
            
            $v->useTemplate();
           $this->response($v);
        }
        
        public function action_language_new () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_language_new');
           
           $v->title = 'ЦУП: Настройка портала';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
            
           if($this->post('nameLang')) {
                $addDate = array(
                    'title' => $this->post('nameLang'),
                    'code' => $this->post('codeLang'),
                    'status' => (!$this->post('statusSetup'))?'0':'1'
                );
                
                PrivateModel::Instance()->AddNewLanguage($addDate);
            }
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_language_edit () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_language_edit');
           
           $v->title = 'ЦУП: Редактирование языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $id = Router::getUriParam(2);
           $v->langDate = PrivateModel::Instance()->GetLangData($id);
            
           if($this->post('nameLang')) {
                $addDate = array(
                    'id' => $id,
                    'title' => $this->post('nameLang'),
                    'code' => $this->post('codeLang'),
                    'status' => (!$this->post('statusSetup'))?'0':'1'
                );
                
                PrivateModel::Instance()->SaveNewLanguage($addDate, $id);
            }
            
           $v->useTemplate();
           $this->response($v);
        }
        
        public function action_language_trash ($arg) {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $id = Router::getUriParam(2);
           
           PrivateModel::Instance()->deletelang($id);
            
           $this->redirect(Url::local('private/language'));
        }
        /*----- /FQ Languages -----*/
        
        /*----- FQ DataBase Edition -----*/
        public function action_dbadm () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_dbadm');
           
           $v->title = 'ЦУП: Редактирование языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           //$id = Router::getUriParam(2);
           
            $v->DBNames = PrivateModel::Instance()->DBNames();
            
            $v->useTemplate();
            $this->response($v);
        }
        
        public function action_dbadm_dbname () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_dbadm');
           
           $v->title = 'ЦУП: Редактирование языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $dbname = Router::getUriParam(2);
                      
            $v->DBNames = PrivateModel::Instance()->DBNames();
            
            $v->dbname = $dbname;
            $v->Tables = PrivateModel::Instance()->DBTables($dbname);
            
            if(isset($_POST['tableName'])) {
                echo(json_encode($_POST));
            }
            
            $v->useTemplate();
            $this->response($v);
        }
        
        public function action_dbadm_gettables () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $dbname = Router::getUriParam(2);
            $Tables = PrivateModel::Instance()->DBTables($dbname);
            
            if($this->post('tableName')) {
                $TableColumns = PrivateModel::Instance()->DBTablesColumns($this->post('tableName'));
                
                echo(json_encode($TableColumns));
            }
            
            if($this->post('listrecords')) {
                $listrecords = PrivateModel::Instance()->DBTablesListrecords($this->post('listrecords'));
                
                echo(json_encode($listrecords));
            }
            
            if($this->post('tableColumns')) {
                $TableColumns = PrivateModel::Instance()->DBTablesColumns($this->post('tableColumns'));
                
                $fields = array();
                
                foreach($TableColumns as $k => $v) {
                    $fields[] = $v['Field'];
                }
                
                echo(json_encode($fields));
            }
            
            if($this->post('bdtable')) {
                $addres = PrivateModel::Instance()->addNewRecord($this->post('bdtable'), $this->post('newRecord'));
                
                echo(json_encode(array('err' => '', 'ok' => 'ok')));
            }
            
            if($this->post('deleteRecord')) {
                $addres = PrivateModel::Instance()->deleteRecord($this->post('nameTable'), $this->post('deleteRecord'));
                
                echo(json_encode(array('err' => '', 'ok' => 'ok')));
            }
            
            if($this->post('columnData')) {
                $nameTable = $this->post('columnData')['nameTable'];
                
                $msg = array('err' => array());
                
                if (!$this->post('columnData')['name']) $msg['err'][] = 'Название поля обязательно';
                else $nameColumn = $this->post('columnData')['name'];
                
                if (!$this->post('columnData')['type']) $msg['err'][] = 'Тип поля обязателен';
                else $typeColumn = $this->post('columnData')['type'];
                
                if (!$this->post('columnData')['length']) $msg['err'][] = 'Длина поля обязательна';
                else $lengthColumn = $this->post('columnData')['length'];
                
                $commentColumn = $this->post('columnData')['comment'];
                $defaultColumn = $this->post('columnData')['default'];
                $aiColumn = $this->post('columnData')['AUTO_INCREMENT'];
                
                if (!empty($msg['err'])) {
                    echo(json_encode(array('err' => $msg['err'], 'ok' => '')));
                } else {
                    PrivateModel::Instance()->addNewColumn($nameTable, $nameColumn, $typeColumn, $lengthColumn, $commentColumn, $defaultColumn, $aiColumn);
                    echo(json_encode(array('err' => '', 'ok' => 'ok')));
                }
            }
            
            if($this->post('deleteColumn')) {
                PrivateModel::Instance()->deleteColumn($this->post('nameTable'), $this->post('deleteColumn'));
                
                echo(json_encode(array('err' => '', 'ok' => 'ok')));
            }
        }
        /*----- /FQ DataBase Edition -----*/
        
        /*----- FQ File manager -----*/
        public function action_p_elfinder () {
           if(AuthClass::instance()->isAuth()) {
	          $u_date = AuthClass::instance()->getUser();
              if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('private/p_elfinder');
           
           $v->title = 'ЦУП: Файловый менеджер';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           //$v->footer = $this->module('Footer');
           
            $v->useTemplate();
            $this->response($v);
        }
        /*----- /FQ File manager -----*/
        
        
        
        
        
        
        
        
        
        
        
        
        
        
       
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