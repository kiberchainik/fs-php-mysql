<?php
	class View {
	   const DEFAULT_TEMPLATE = TEMPLATE_DEFAULT;
       private $view, $moduletemplate, $template = NULL, $data = [];
       
       public function __construct($name) {
            $this->view = VIEWS_PATH.TEMPLATE_DEFAULT.'/'.$name.'.tpl';
            $this->moduletemplate = $name;
       }
       
       public function useTemplate ($name = self::DEFAULT_TEMPLATE) {
            $this->template = TEMPLATES_PATH.TEMPLATE_DEFAULT.'/'.$name.'.tpl';
       }
       
       private function renderView () {
            ob_start(); // echo'м отправляем данные в буфер
            extract($this->data); // <-извлекаем данные переданые из контроллера через $v->exemple
            include $this->view;
            
            return ob_get_clean(); //останавливает вывод в буфер и возвращает все его содержимое очищая буфер
       }
       
       private function renderTemplate() {
            ob_start();
            extract($this->data); // <-извлекаем данные переданые из контроллера через $v->exemple
            $content = $this->renderView(); // <-вьюшка которая используется в шаблоне
            include $this->template;
            /*echo'<pre>';
            print_r($this->data);
            echo'</pre>';*/
            return ob_get_clean();
       }
       
       public function render () {
            return $this->template ? $this->renderTemplate() : $this->renderView();
       }
       
       public function __toString () {
            return $this->render();
       }
       
       public function __set($name, $value) {
            $this->data[$name] = $value;
       }
       
       public function __get($name) {
            return @$this->data[$name];
       }
	}
?>