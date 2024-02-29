<?php
	class BannersController extends Controller {
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_banners');
           
           $v->title = 'ЦУП: Баннеры сайта';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $p_page = Router::getUriParam('page'); // p. num
           $count = BannersModel::Instance()->getBannersCount(9);
           
           if($p_page < 1 or $p_page > $count) Url::local('404');
           
           $v->bannerList = BannersModel::Instance()->GetBannerList($p_page, 9);
           $v->pagination = HTMLHelper::pagination($p_page, $count, Url::local('banners'));
           
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_edit () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_banner_edit');
           
           $v->title = 'ЦУП: Редактирование баннера';
           $v->description = '';
           $v->keywords = '';
           $v->upd_message = null;
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $id = Router::getUriParam(2);
           $v->lang = PrivateModel::Instance()->GetLangNum();
            
            $v->bannerData = BannersModel::Instance()->getBannerDataForEdit($id);
            //echo '<pre>'; print_r($v->bannerData); echo '</pre>';
            if ($this->post('link')) {
                if(isset($_FILES['artLogo']) and !empty($_FILES['artLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['artLogo'], 'banners/'.$id);
                elseif (!empty($v->bannerData['img_src'])) $image = $v->bannerData['img_src']; 
                elseif ($image == 'Error_size') $error = 'Error_size';
                else $error = 'Logo empty!'; //$image = '';
                
                if (!$this->post('link')) $error = 'Link пуст';
                
                foreach ($this->post('bd') as $lang_key => $val) {
                    if(empty($val['title'])) $error = 'Write <b>title</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['text'])) $error = 'Write <b>text</b> for lang <b>"'.$lang_key.'"</b>!';
                }
                /*echo'<pre>';
                print_r($this->post('bd'));
                echo'</pre>';*/
                if (!isset($error)) {
                    $banner = array(
                        'id' => $id,
                        'code' => $this->post('code'),
                        'img_src' => $image,
                        'link' => $this->post('link')
                    );
                    
                    BannersModel::Instance()->seveBannerData($banner, $this->post('bd'));
                } else $v->upd_message = $error;
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_newbanner () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_banner_new');
           
           $v->title = 'ЦУП: Добавить баннер';
           $v->description = '';
           $v->keywords = '';
           $v->upd_message = null;
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->lang = PrivateModel::Instance()->GetLangNum();
            
            //echo '<pre>'; print_r($v->bannerData); echo '</pre>';
            if ($this->post('link')) {
                if(isset($_FILES['artLogo']) and !empty($_FILES['artLogo']['name'])) $image = UploadHelper::UploadOneImage($_FILES['artLogo'], 'banners/'.$id);
                elseif (!empty($v->bannerData['img_src'])) $image = $v->bannerData['img_src']; 
                elseif ($image == 'Error_size') $error = 'Error_size';
                else $error = 'Logo empty!'; //$image = '';
                
                if (!$this->post('link')) $error = 'Link пуст';
                
                foreach ($this->post('bd') as $lang_key => $val) {
                    if(empty($val['title'])) $error = 'Write <b>title</b> for lang <b>"'.$lang_key.'"</b>!';
                    if(empty($val['text'])) $error = 'Write <b>text</b> for lang <b>"'.$lang_key.'"</b>!';
                }
                /*echo'<pre>';
                print_r($this->post('bd'));
                echo'</pre>';*/
                if (!isset($error)) {
                    $banner = array(
                        'code' => $this->post('showart'),
                        'img_src' => $image,
                        'link' => $this->post('link')
                    );
                    
                    BannersModel::Instance()->addBannerData($banner, $this->post('bd'));
                } else $v->upd_message = $error;
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
        
        public function action_trash () {
           if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            
           $id = Router::getUriParam(2);
           
           DelHelper::DeleteFile('images/banners/'.$id);
           
           BannersModel::Instance()->deletebanner($id);
            
           $this->redirect(Url::local('banners'));
        }
    }
?>