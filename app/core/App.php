<?php
    
    class App
    {

        protected $route;
        protected $controller ;
        protected $method;
        protected $params = [];


        public function __construct()
        {
            $url = $this->parseUrl();
            if (!empty($url)) {
                $controllerPath = '../app/controllers/' . $url[0] . '.php';
                if (is_readable($controllerPath)) {
                    require_once $controllerPath;
                    if (class_exists($url[0])) {
                        $this->controller = new $url[0];
                        unset($url[0]);
                    } else {
                        $this->handleError();
                        return;
                    }
                } else {
                    $this->handleError();
                    return;
                }
        
                if (isset($url[1])) {
                    if (method_exists($this->controller, $url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    } else {
                        $this->handleError();
                        return;
                    }
                }
        
                $this->params = $url ? array_values($url) : [];
        
                call_user_func_array([$this->controller, $this->method], $this->params);
            } else {
                $this->handleError();
            }
        }
        
        private function handleError() : void
        {
            header('HTTP/1.1 404 Not Found');
        }

              
        protected function parseUrl() : array
        {
            if(empty($_GET['url'])) {
                return $url = 'login';
            }
            if (isset($_GET['url'])) {
                return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            }
        }
    }