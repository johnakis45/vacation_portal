<?php


class AuthController extends Controller {


    public function login() : void {
        $user = $this->model('UserModel');

        if (!empty($_SESSION['username'])) {
            if($_SESSION['role'] == 'manager'){
                header("Location: {$this->base_url}ManagerController/getAllUsers"); 
            }else if($_SESSION['role'] == 'user'){
                header("Location: {$this->base_url}EmployeeController/getUserRequests/{$user->getId()}"); 
            }
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user->setUsername($username);
            $user->fetchUserByUsername($username);
            if ($user->authenticateUser($password)) {
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['role'] = $user->getRole();
                $_SESSION['id'] = $user->getId();
                $_SESSION['edit_date'] = $user->getEditDate();


                if($_SESSION['role'] == 'manager'){
                    header("Location: {$this->base_url}ManagerController/getAllUsers"); 
                }else if($_SESSION['role'] == 'user'){
                    header("Location: {$this->base_url}EmployeeController/getUserRequests/{$user->getId()}"); 
                }
                exit();
            }
            
            $this->view('loginView', ["error" => "Wrong credentials"]);
            return;
        }
        $this->view('loginView', []);
    }
    


    public function logout() : void {
        session_unset();
        session_destroy();
        header('Location: login');
        exit();
    }
}


?>