<?php

    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => DATABASE_HOST,
        "port" => DATABASE_PORT,
        "dbname" => DATABASE_DBNAME,
        "username" => DATABASE_USER,
        "passwd" => DATABASE_PASSWORD,
        "options" => [
//            '1002' => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);

    /**
     * Retorna o caminho
     *
     * @param string $path
     * @return string
     */
    function url(string $path): string
    {
        if ($path) {
            return URL_BASE. $path;
        }

        return URL_BASE;
    }

    function getFile($root): string
    {
        if (file_exists($root)) {
            return file_get_contents($root);
        }
        return $root;
    }

    function message(string $message, string $type): string
    {
        return "<div class='message{$type}'>{$message}</div>";
    }

    function loadController(string $controller)
    {
        return ROOT . DS . 'theme/pages/' . $controller . '/controller.php';
    }