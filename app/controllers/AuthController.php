<?php

namespace App\controllers;
use App\core\Controller;

/**
 * Authentication Controller
 * 
 * This class handles user login, logout, and authentication actions. It checks if the
 * user is already logged in and redirects to appropriate pages based on user roles.
 * @package app\controllers
 */
class AuthController extends Controller
{
    /**
     * Login method
     * 
     * This method handles user login functionality. It checks if the user is already logged
     * in by looking at the session. If the user is logged in, they are redirected based on their role.
     * If the user is not logged in, it validates the login credentials and sets session variables.
     * It then redirects the user based on their role (manager or user).
     *
     * @return void
     */
    public function login(): void
    {
        $user = $this->model('UserModel');
        if (!empty($_SESSION['username'])) {
            if ($_SESSION['role'] == 'manager') {
                header("Location: " . BASE_URL . "ManagerController/getAllUsers");
            } else if ($_SESSION['role'] == 'user') {
                header("Location: " . BASE_URL . "EmployeeController/getUserRequests/{$user->getId()}");
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user->setUsername($username); //initialize
            $user->fetchUserByUsername($username); //fetch user data

            if ($user->authenticateUser($password)) {
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['role'] = $user->getRole();
                $_SESSION['id'] = $user->getId();
                $_SESSION['edit_date'] = $user->getEditDate();
                if ($_SESSION['role'] == 'manager') {
                    header("Location: " . BASE_URL . "ManagerController/getAllUsers");
                } else if ($_SESSION['role'] == 'user') {
                    header("Location: " . BASE_URL . "EmployeeController/getUserRequests/{$user->getId()}");
                }
                exit();
            }
            $this->view('loginView', ["error" => "Wrong credentials"]);
            return;
        }

        $this->view('loginView', []);
    }

    /**
     * Logout method
     * 
     * This method logs the user out by clearing the session data and destroying the session.
     * After logging out, the user is redirected to the login page.
     *
     * @return void
     */
    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: login');
        exit();
    }
}

?>
