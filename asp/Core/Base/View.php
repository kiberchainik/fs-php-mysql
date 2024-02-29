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
            ob_start(); // echo'� ���������� ������ � �����
            extract($this->data); // <-��������� ������ ��������� �� ����������� ����� $v->exemple
            include $this->view;
            
            return ob_get_clean(); //������������� ����� � ����� � ���������� ��� ��� ���������� ������ �����
       }
       
       private function renderTemplate() {
            ob_start();
            extract($this->data); // <-��������� ������ ��������� �� ����������� ����� $v->exemple
            $content = $this->renderView(); // <-������ ������� ������������ � �������
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