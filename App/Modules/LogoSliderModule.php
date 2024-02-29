<?php
	class LogoSliderModule extends Controller {
	   public function action_index($id) {
	       $v = new View('site/logo_slider');
           
           //$lang = $this->lang('banners');
           
           //$v->text_more = $lang['more'];
           $logoCompany = CompanyModel::Instance()->getListCompany();
           
           foreach($logoCompany as $k => $s) {
                $logoCompany[$k]['webp'] = preg_replace('".(jpg|jpeg|png)$"', '.webp', $s['user_img']);
           }
           $v->logoCompany = $logoCompany;
           
	       $this->response($v);
	   }
        
	}
?>