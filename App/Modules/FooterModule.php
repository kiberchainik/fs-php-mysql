<?php
	class FooterModule extends Controller {
	   public function action_index() {
	       $v = new View('site/footer');
           $lang_footer = $this->lang('footer');
           $settings = MainModel::Instance()->GetSettings();
           
           $v->logo = $settings['logo'];
           $v->image = $settings['logo'];
           $v->admin_name = $settings['admin_name'];
           $v->admin_mobile = $settings['admin_mobile'];
           $v->admin_email = $settings['admin_email'];
           $v->admin_adres = $settings['admin_adres'];
           $v->text_cookie = $lang_footer['cookie'];
           //$this->module('Statsusers');
           
           if(AuthClass::instance()->isAuth()) {
				$v->auth = AuthClass::instance()->getUser();
			} else $v->auth = false;
           $v->information = HeaderModel::Instance()->HeaderInformation();
           
	       $this->response($v);
	   }
	}
?>