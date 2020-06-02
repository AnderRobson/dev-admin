<?php
    if (!defined('URL_BASE')) {
        define('URL_BASE', 'http://localhost:4444/sites/site-dev/ander-admin');
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

    function printrx($data)
    {
        foreach ($data as $key => $line) {
            if (is_array($line)) {
                foreach ($line as $subKey => $subLine) {
                    echo "<strong>'$subKey' => '$subLine'</strong><br />";
                }
            } else {
                echo "<strong>'$key' => '$line'</strong><br />";
            }
        }
        die;
    }

    // Session Start
    session_start();
    require(ENGINE . DS . 'routes.php');
