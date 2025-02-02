<?php
    declare(strict_types=1);
    require  '../vendor/autoload.php';
    use App\core\App;
    use App\core\Controller;
    use App\config\SessionConfig;
    SessionConfig::start();
    $app = new App;
?>
