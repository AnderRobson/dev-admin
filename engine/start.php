<?php
    if (!defined('URL_BASE')) {
//        define('URL_BASE', 'http://localhost:4444/sites/site-dev/ander-admin');
        define('URL_BASE', 'http://localhost/Plataforma/sites/site-dev/ander-admin');
    }

    if (!defined('DS')) {
        define('DS', DIRECTORY_SEPARATOR);
    }

    if (!defined('BASE_PATH')) {
        define('BASE_PATH', dirname(str_replace('/', DS, $_SERVER['SCRIPT_FILENAME'])));
    }

    if (!defined('SITE_ROOT')) {
        define('SITE_ROOT', dirname(BASE_PATH));
    }

    if (!defined('ENGINE')) {
        define('ENGINE', ROOT . DS . 'engine');
    }

    if (file_exists(__DIR__ . '/../vendor' . DS . 'autoload.php')) {
        include_once  __DIR__ . '/../vendor' . DS . 'autoload.php';
    }

    /**
     * Imprime valores dependendo do formato
     */
    function printr () {
        $args = func_get_args();
        foreach($args as &$arg){
            echo '<pre>';
            if (is_object($arg) || is_array($arg)) print_r($arg);
            elseif (empty($arg) || is_resource($arg)) var_dump($arg);
            else echo (string) $arg;
            echo '</pre>';
        }
    }

    /**
     * Imprime valores dependendo do formato e morre
     */
    function printrx () {
        $args = func_get_args();
        call_user_func_array('printr', $args);
        die();
    }

    // Session Start
    session_start();
    require(ENGINE . DS . 'routes.php');
