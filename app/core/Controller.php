<?php

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
     * @var string $base_url The base URL for the application
     */
    protected string $base_url = BASE_URL; //'http://localhost:8080/public/'

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
        require_once '../app/models/' . $model . '.php';
        return new $model();
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
        require_once '../app/views/' . $view . '.php';
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
            header("Location: {$this->base_url}AuthController/login");
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
            header("Location: {$this->base_url}AuthController/login");
            exit();
        }
    }
}

?>
