<?php
    class Route {
        private $components = [];
        private $controller_name = NULL, $action_name = NULL, $params = [];
        
        const PARAM_PATTERN = '/\<([a-z0-9]+)\>(\??)/i';
        const PARAM_TMP_PATTERN = '/\<[a-z0-9]+\>\?/i';
        
        public function __construct ($route, array $params) {
            $this->components = explode('/', $route);
            $this->controller_name = @$params['controller'];
            $this->action_name = @$params['action'];
            $this->params = $params;
        }
        
        private function isTempParam ($name) {
            return preg_match(self::PARAM_TMP_PATTERN, $name);
        }
        
        private function isParam ($param, $value) {
            if(!preg_match(self::PARAM_PATTERN, $param, $arr)) return false;
            
            $name = $arr[1];
            //var_dump($arr);
            if ($name == 'controller') 
                $this->controller_name = $value;
            else if ($name == 'action') 
                $this->action_name = $value;
            else 
                $this->params[$name] = $value;
            
            return true;
        }
        
        public function exec ($realrouteparams) {
            
            //if(count($realrouteparams) != count($this->components)) return false;
            $count = max(count($realrouteparams), count($this->components));
            
            for($i = 0; $i < $count; $i++) {
                if(!isset($this->components[$i])) return false;
                if(empty($realrouteparams[$i]) && $this->isTempParam($this->components[$i])) return true;
                else if(empty($realrouteparams[$i])) return false; 
                if($this->isParam($this->components[$i], $realrouteparams[$i])) continue;
                if($this->components[$i] != $realrouteparams[$i]) return false;
            }
            
            return true;
        }
        
        public function getData () {
            if ($this->controller_name === NULL || $this->action_name === NULL) throw new RouteException('InvalideRoute', 404);
            return [
                'controller' => $this->controller_name,
                'action' => $this->action_name,
                'params' => $this->params
            ];
        }
    }

	class Router {
	   const DEFAULT_CONTROLLER = 'main';
       const DEFAULT_ACTION = 'index';
       
       private static $URL_ARR = NULL;
       private static $routes = [];
       private static $params = [];
       
       private static function parceURL () {
            if (self::$URL_ARR !== NULL) return;
            
            $url = explode('?', $_SERVER['REQUEST_URI'])[0]; //�������� �� ������ �� ��� ����� ����� �������
            $components = explode('/', $url); //�������� �� �����
            $degree = count(explode('/', URLROOT)); // ������� ������ �����������
            
            self::$URL_ARR = array_slice($components, $degree); //Выбирает срез массива
       }
       
       public static function getUriParam ($n) {
            self::parceURL();
            
            if(is_integer($n) and isset(self::$URL_ARR[$n])) return @self::$URL_ARR[$n];
            elseif(isset(self::$params[$n])) return @urldecode(trim(self::$params[$n]));
       }
       
       public static function Load ($controller, $action = self::DEFAULT_ACTION) {
            
            $controller = ucfirst(strtolower($controller)).'Controller';
            $action = 'action_'.strtolower($action);
            $controller_path = CONTROLLERS_PATH.$controller.'.php';
            
            if(!file_exists($controller_path)) throw new RouteException('Controller {'.$controller.'} not found', 404);
            include $controller_path;
            
            $ctrl = new $controller();
            
            if(!method_exists($ctrl, $action)) throw new RouteException('Action {'.$action.'} not found', 404);
            $ctrl->$action();
            
            echo $ctrl->getResponse(true);
       }
       
       private static function defaultRun () {
            $controller = self::getUriParam(0);
            $action = self::getUriParam(1);
            
            $controller = $controller?$controller:self::DEFAULT_CONTROLLER;
            $action = $action?$action:self::DEFAULT_ACTION;
            
            self::Load($controller, $action);
       }
       
       private static function routeRun (Route $route) {
            $data = $route->getData();
            self::$params = $data['params'];
            self::Load($data['controller'], $data['action']);
       }
       
       public static function Run () {
            self::parceURL();
            foreach(self::$routes as $route) {
                //var_dump($route->exec(self::$URL_ARR));
                if($route->exec(self::$URL_ARR)) { // false
                    self::routeRun($route);
                }
            }
            self::defaultRun();
       }
       
       public static function add ($route, array $params) {
            self::$routes[] = new Route($route, $params);
            /*echo'<pre>';
            var_dump(self::$routes);
            echo'</pre>';*/
       }
	}
?>