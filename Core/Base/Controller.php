<?php
	abstract class Controller {
	   private $response;
       private $gz = false;
       
       protected function header($name, $value) {
            header("$name:$value");
       }
       
       protected function redirect ($url) {
            $this->header('Location', $url);
       }
       
       private function _responseGZ (){
            $this->header('Content-Encoding', 'gzip');
            return gzencode($this->response, 5);
       }
       
       private function _response (){
            return $this->response;
       }
       
       private function supportGZ () {
            return (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false);
       }
       
	   protected function response ($text, $gz = false) {
	       $this->response = $text;
           $this->gz = $gz;
	   }
       
       public function getResponse ($route_get = false) {
            return ($this->gz && $route_get && $this->_responseGZ())?$this->_responseGZ():$this->_response();
       }
       
       protected function get($name) {
            //return @$_GET[$name];
            $data = $this->clean($_GET);
            return @$data[$name];
       }
       
       protected function post($name) {
            if($_POST) {
                $data = $this->clean($_POST);
                return @$data[$name];
            }
       }
       
       protected function files($name) {
            if($_FILES) {
                $data = $this->clean($_FILES);
                return $data[$name];
            }
       }
       
       protected function session ($name) {
            $data = $this->clean($_SESSION);
            return $data[$name];
       }
       
       protected function cookie ($name) {
            $data = $this->clean($_COOKIE);
            return $data[$name];
       }
       
       private function clean($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);

				$data[$this->clean($key)] = $this->clean($value);
			}
		} else {
			$data = trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
		}

		return $data;
	}
       
       public function module($name, $arg = '') {
            if(is_file(MODULES_PATH.$name.'Module.php')) {
			     $class = $name.'Module';
                 $mod = new $class;
                 
                 $action = 'action_index';
                 $mod->$action($arg);
                 
                 return $mod->getResponse();
                 
			} else {
				return 'Error: Could not load module {' . $actions[0] . 'Module}!';
			}
	   }
       
       public function lang ($name) {
            if (!isset($_SESSION['lang'])) {
                $_SESSION['lang'] = LANG_DEFAULT;
            }
            $lang = '';
            if(file_exists(LANG_PATH.$_SESSION['lang'].'/'.$name.'.php')) {
                require_once (LANG_PATH.$_SESSION['lang'].'/'.$name.'.php');
                return @$lang;
            } else {
                return 'Cannot include language (<b>'.$name.'</b>) file!';
            }
	   }
	}
?>