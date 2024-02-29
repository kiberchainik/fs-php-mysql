<?php
	class SliderModule extends Controller {
	   public function action_index() {
	       $v = new View('site/slider');
           $lang_slider = $this->lang('slider');
           
           $v->text_read_more = $lang_slider['text_read_more'];
           $sliderData = SliderModel::Instance()->getSliderList();
           $v->slider_content = SliderModel::Instance()->getSliderContent();
           
           foreach($sliderData as $k => $s) {
                $sliderData[$k]['webp'] = preg_replace('".(jpg|jpeg|png)$"', '.webp', $s['img']);
           }
           $v->sliderData = $sliderData;
	       $this->response($v, true);
	   }
	}
?>