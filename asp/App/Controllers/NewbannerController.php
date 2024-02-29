<?php
	class NewbannerController extends Controller {
        public function action_index () {
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
                        'code' => $this->post('code'),
                        'img_src' => '',
                        'link' => $this->post('link')
                    );
                    
                    $last_id = BannersModel::Instance()->addBannerData($banner, $this->post('bd'));
                    if(isset($_FILES['artLogo']) and !empty($_FILES['artLogo']['name'])) {
                        $image = UploadHelper::UploadOneImage($_FILES['artLogo'], 'banners/'.$last_id);
                        $banner = array(
                            'id' => $last_id,
                            'img_src' => $image
                        );
                        BannersModel::Instance()->updBannerImage($banner, $this->post('bd'));
                    }
                    
                } else $v->upd_message = $error;
            }
            
            $v->useTemplate();
	        $this->response($v);
        }
    }
?>