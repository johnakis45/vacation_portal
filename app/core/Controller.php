<?php
    
    class Controller
    {
        protected string $base_url = BASE_URL; //'http://localhost:8080/public/'

        protected function model(string $model) : object
        {
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }

        protected function view(string $view , array $data = []) : void
        {
            require_once '../app/views/'. $view . '.php';
        }

        protected function checkPost() : bool
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                return true;
            }
            return false;
        }

        protected function checkRole(string $role) : void
        {
            if (empty($_SESSION['role']) || $_SESSION['role'] != $role) {
                header("Location: {$this->base_url}AuthController/login");
                exit();
            }
        }

        protected function checkLoggedIn() : void
        {
            if (!isset($_SESSION['id'])) {
                header("Location: {$this->base_url}AuthController/login");
            }
        }
        
    }