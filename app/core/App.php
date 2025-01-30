<?php
    
    class App
    {

        protected $route;
        protected $controller ;
        protected $method;
        protected $params = [];


        public function __construct()
        {
            $this->route = $this->parseUrl();
            // if($this->route === 'user_dashboard' || $this->route === 'requests' || $this->route === 'user_edit' || $this->route === 'user_creation') {
            //     require_once '../app/controllers/ManagerController.php';
            //     $this->controller = new ManagerController();
            // } else if($this->route === 'employee/vacation_dashboard' || $this->route === 'employee/vacation_request') {
            //     require_once '../app/controllers/EmployeeController.php';
            //     $this->controller = new EmployeeController();
            // }else{
            //     require_once '../app/controllers/AuthController.php';
            //     $this->controller = new AuthController();
            // }

            // if($route === 'login') {
            //     require_once '../app/controllers/UserController.php';
            //     $controller = new UserController();
            //     $controller->view('login', []);
            // } else if($route === 'create') {
            //     $controller->view('manager/requests', []);
            // } else {
            //     echo "404";
            // }

            $url = $this->parseUrl();
            if (!empty($url)){
            if(file_exists('../app/controllers/' . $url[0] . '.php')) {
                $this->controller =  $url[0];
                unset($url[0]);
            }
            require_once '../app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;

            if(isset($url[1])) {
                if(method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }
       
            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->controller, $this->method], $this->params);
             }

        }

        

        
        public function router()
        {
            switch ($this->route[0]) {
                case 'login':
                    $this->controller = new AuthController();
                    ($_SERVER['REQUEST_METHOD'] === 'POST') 
                        ? $this->controller->login() 
                        : $this->controller->view('login', []);
                    break;
                
                case 'logout':
                    $this->controller->logout();
                    break;
                
                case 'user_dashboard':
                    require_once '../app/controllers/ManagerController.php';
                    $this->controller = new ManagerController;
                    $this->controller->getAllUsers();
                    break;
                
                case 'create_user':
                    ($_SERVER['REQUEST_METHOD'] === 'POST') 
                        ? $this->controller->createUser($_POST) 
                        : $this->controller->view('user_creation', []);
                    break;
                
                case 'update_user':
                    ($_SERVER['REQUEST_METHOD'] === 'POST') 
                        ? $this->controller->updateUser($_GET['id'], $_POST) 
                        : $this->controller->editUser($_GET['id']);
                    break;
                
                case 'delete_user':
                case 'approve_request':
                case 'reject_request':
                case 'delete_request':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $method = str_replace('delete_', '', $this->route[0]);
                        $this->controller->$method($_GET['id']);
                    }
                    break;
                
                case 'requests':
                    $this->controller->viewVacationRequests();
                    break;
                
                case 'employee':
                    $this->controller->home($_SESSION['user']['id']);
                    break;
                
                case 'request_vacation':
                    ($_SERVER['REQUEST_METHOD'] === 'POST') 
                        ? $this->controller->requestVacation($_SESSION['user']['id'], $_POST) 
                        : $this->controller->view('request_vacation', []);
                    break;
                
                default:
                    $this->controller->view('login', []);
                    break;
            }
        }
        



        protected function parseUrl()
        {
            //echo $_GET['url'];
            if(empty($_GET['url'])) {
                return $url = 'login';
            }
            if (isset($_GET['url'])) {
                return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            }
        }
    }