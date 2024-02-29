<?php
	class BannersModule extends Controller {
	   public function action_index() {
	       $v = new View('site/banners');
           
           $lang = $this->lang('banners');
           
           $v->text_more = $lang['more'];
           $v->banners = BannerModel::Instance()->getBanners();
           
	       $this->response($v);
	   }
        
	}
?>