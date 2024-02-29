<?php
	class HeaderModule extends Controller {
	   public function action_index() {
	       $v = new View('header');
           $lang_header = $this->lang('header');
           $settings = MainModel::Instance()->GetSettings();
           
           if(AuthClass::instance()->isAuth()) {
				$profile_data = AuthClass::instance()->getUser();
                $v->profile_logo = ($profile_data['user_img'])?$profile_data['user_img']:'Media/images/no_avatar.png';
				$v->auth = $profile_data['u_id'];
			} else $v->auth = false;
            
            $v->usersonline = $this->module('Usersonline');
            
           $v->logo = $settings['logo'];
           $v->image = $settings['logo'];
           $v->admin_name = $settings['admin_name'];
           $v->admin_mobile = $settings['admin_mobile'];
           $v->admin_email = $settings['admin_email'];
           $v->admin_adres = $settings['admin_adres'];
           
	       $this->response($v);
	   }
	}
?>