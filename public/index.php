<?php
    session_start();
    /* CORE STUFFF */
    require '../core/Database.php';
    require '../core/Router.php';
    require '../core/Auth.php';
    require '../core/Ajax.php';
    require '../core/View.php';
    /* MODELS */
    require '../model/Model.php';
    require '../model/User.php';
    require '../model/Route.php';
    require '../model/Station.php';

    $router = Router::getInstance();
    $auth = Auth::getInstance();
    if ($confArray = json_decode(file_get_contents('../conf.json'), true)) {
        Database::getInstance()->init($confArray['db']);
        $auth->init();
        $router->route($confArray['base_url']);
    } else {
        
    }

?>
