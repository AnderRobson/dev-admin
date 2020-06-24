<?php
    if (!defined("URL_BASE")) {
        define("URL_BASE", "http://" . $_SERVER['HTTP_HOST'] . "/Plataforma/sites/" . SITE["PATH"] . "/admin");
    }

    if (!defined('URL_ADMIN')) {
        define('URL_ADMIN', 'http://' . $_SERVER['HTTP_HOST'] . '/Plataforma/dev-admin');
    }

    if (!defined('URL_BLOG')) {
    define('URL_BLOG', 'http://' . $_SERVER['HTTP_HOST'] . "/Plataforma/sites/" . SITE["PATH"]);
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

    if (file_exists(ROOT . DS . "vendor" . DS . "autoload.php")) {
        include_once  ROOT . DS . "vendor" . DS . "autoload.php";
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

    ob_start();
    session_start();
        require ENGINE . DS . 'routes.php';
    ob_end_flush();
