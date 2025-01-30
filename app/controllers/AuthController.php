<?php


class AuthController extends Controller {

    public function login() {
        $base_url = BASE_URL;
        $user = $this->model('User');
        
        if (!empty($_SESSION['username'])) {
            if($_SESSION['role'] == 'manager'){
                return $this->view('manager/user_dashboard', ['users' => $user->getAllUsers()]);
            }else if($_SESSION['role'] == 'user'){
                return $this->view('employee/vacation_dashboard', []);
            }
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            if ($user->loginUser($username, $password)) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user->getRole();
                $_SESSION['id'] = $user->getId();
                if($_SESSION['role'] == 'manager'){
                    header("Location: {$base_url}ManagerController/getAllUsers"); 
                    //return $this->view('manager/user_dashboard', ['users' => $user->getAllUsers()]);
                }else if($_SESSION['role'] == 'user'){
                    header("Location: {$base_url}EmployeeController/requests/{$user->getId()}"); 
                    //return $this->view('employee/vacation_dashboard', ['requests' => $vacation->getUserRequests($user->getId())]);
                }
                exit();
            }
            
            return $this->view('login', ["error" => "Wrong credentials"]);
        }
        
        return $this->view('login', []);
    }
    


    public function logout() {
        session_unset();
        session_destroy();
        header('Location: login');

        exit();
    }
}


?>