<?php
    
    class Controller
    {
        protected $base_url = BASE_URL; //'http://localhost:8080/public/'

        protected function model($model)
        {
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }

        protected function view($view , $data = [])
        {
            require_once '../app/views/'. $view . '.php';
        }

        protected function checkPost($post)
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                return true;
            }
            return false;
        }

        protected function checkRole($role)
        {
            if (empty($_SESSION['role']) || $_SESSION['role'] != $role) {
                header("Location: {$this->base_url}AuthController/login");
                exit(); // Ensure the script stops execution after redirection
            }
        }
        
    }