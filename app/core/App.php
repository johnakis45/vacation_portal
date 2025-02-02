<?php

/**
 * Main Application Class
 * 
 * This class is responsible for routing the request, loading the appropriate controller,
 * method, and parameters, and invoking the correct method based on the parsed URL.
 * @package app\core
 */
class App
{
    /**
     * @var string $route The route parsed from the URL (not used directly in the current version)
     */
    protected $route;

    /**
     * @var object $controller The controller instance that will handle the request
     */
    protected $controller;

    /**
     * @var string $method The method to be invoked on the controller
     */
    protected $method;

    /**
     * @var array $params The parameters passed to the method
     */
    protected $params = [];

    /**
     * Constructor
     * 
     * The constructor is called when the App class is instantiated. It parses the URL, loads
     * the controller, method, and parameters, and calls the method with the parameters.
     */
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

    /**
     * Handles errors by sending a 404 HTTP status code.
     * 
     * This method is called when the requested controller or method cannot be found.
     *
     * @return void
     */
    private function handleError(): void
    {
        header('HTTP/1.1 404 Not Found');
        echo '404 - Not Found';
    }

    /**
     * Parses the URL from the query string.
     * 
     * This method extracts and sanitizes the URL from the query parameter, splits it into
     * an array, and returns the URL parts. If no URL is provided, it defaults to 'login'.
     *
     * @return array The parsed URL parts
     */
    protected function parseUrl(): array
    {
        if (empty($_GET['url'])) {
            return $url = ['login'];
        }
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}

?>
