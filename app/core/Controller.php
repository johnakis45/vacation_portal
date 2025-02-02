<?php

namespace App\core;

/**
 * Base Controller Class
 * 
 * This class provides utility methods to handle common tasks such as loading models,
 * views, checking if a POST request is made, validating user roles, and checking user login status.
 * @package app\core
 */
class Controller
{

    /**
     * Loads the specified model.
     * 
     * This method is responsible for including a PHP file corresponding to the model
     * and instantiating an object of the model class.
     *
     * @param string $model The name of the model to load (without file extension)
     * @return object Returns an instance of the specified model class
     */
    protected function model(string $model): object
    {
        $modelClass = 'App\\models\\' . $model;
        return new $modelClass();
    }

    /**
     * Loads the specified view.
     * 
     * This method is responsible for including a PHP file corresponding to the view.
     * Optionally, it can pass data to the view for rendering.
     *
     * @param string $view The name of the view to load (without file extension)
     * @param array $data (optional) An associative array of data to pass to the view
     * @return void
     */
    protected function view(string $view, array $data = []): void
    {
        // Define the base path to the views directory
        $viewsBasePath = dirname(__DIR__) . '/views/';
    
        // Construct the full path to the view file
        $viewPath = $viewsBasePath . $view . '.php';
    
        // Check if the view file exists
        if (file_exists($viewPath)) {
            // Extract variables from the data array and make them available in the view
            extract($data);
    
            // Include the view file
            require_once $viewPath;
        } else {
            // Handle the case where the view file does not exist
            // For example, you might throw an exception or log an error
            throw new \Exception("View file '{$viewPath}' not found.");
        }
    }
    


    /**
     * Checks if the current request method is POST.
     * 
     * This method checks whether the HTTP request is a POST request, which is typically
     * used when submitting forms or sending data to the server.
     *
     * @return bool Returns true if the request is a POST request, otherwise false
     */
    protected function checkPost(): bool
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return true;
        }
        return false;
    }

    /**
     * Checks if the user is logged in.
     * 
     * This method checks if the user is logged in by verifying if the session contains
     * the 'id' key. If not, the user is redirected to the login page.
     *
     * @return void
     */
    protected function checkLoggedIn(): void
    {
        if (!isset($_SESSION['id'])) {
            header("Location: " . BASE_URL . "AuthController/login");
            exit();
        }
    }


    /**
     * Checks if the current user has been edited.
     * 
     * @param int id $id The id of the user to check
     * @return bool Returns true if the user has been edited, false otherwise
     */
    protected function checkEdit(int $id): void
    {
            $user = $this->model('UserModel');
            $user->fetchUserById($id);
            
            if ($user->getEditDate() != $_SESSION['edit_date']) {
                header("Location: " . BASE_URL . "AuthController/logout");
                exit();
            }
        }

    /**
     * Checks if the current user has a specific role.
     * 
     * This method checks if the user has the required role (e.g., manager, user).
     * If the role is not set or doesn't match, the user is redirected to the login page.
     *
     * @param string $role The role to check (e.g., 'manager', 'user')
     * @return void
     */
    protected function checkRole(string $role): void
    {
        if (empty($_SESSION['role']) || $_SESSION['role'] != $role) {
            header("Location: " . BASE_URL . "AuthController/login");
            exit();
        }
    }
}

?>
