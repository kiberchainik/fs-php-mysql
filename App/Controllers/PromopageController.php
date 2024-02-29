<?php
	class PromopageController extends Controller {
	   public function action_index () {
	       if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
	       $userDate = AuthClass::instance()->getUser();
           if($userDate['validStatus'] != '1') $this->redirect(Url::local('profile/edit'));
           
	       $v = new View('account/promo_page_new');
           $promo = $this->lang('promo');
           
           $v->title = $promo['title'];
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->profilemenu = $this->module('ProfileMenu');
           
           $v->text_title_advert = $promo['title_advert'];
           $v->text_keywords = $promo['keywords'];
           $v->text_category = $promo['category'];
           $v->text_select = $promo['select'];
           $v->text_description = $promo['description'];
           $v->text_main_promo_img = $promo['main_promo_img'];
           $v->text_cover_images = $promo['cover_images'];
           $v->text_other_images = $promo['other_images'];
           $v->text_save = $promo['save'];
           
           $v->categoryList = PromoModel::Instance()->GetCategoryListWithoutParetnId();
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_save () {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           
           echo'<pre>';
           print_r($_FILE);
           echo'</pre>';
           echo'<pre>';
           print_r($_POST);
           echo'</pre>';
       }
       
       public function action_subcategory () {
           if(!AuthClass::instance()->isAuth()) {
	           $this->redirect(Url::local(''));
	       }
           header('Content-type: application/json');
           $type_list = PromoModel::Instance()->ParentSubCategoryList($this->post('id_cat'), $this->post('lang'));
           echo json_encode($type_list);
       }
	}
?>