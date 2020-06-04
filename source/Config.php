<?php

    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => DATABASE_HOST,
        "port" => DATABASE_PORT,
        "dbname" => DATABASE_DBNAME,
        "username" => DATABASE_USER,
        "passwd" => DATABASE_PASSWORD,
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND  => "SET NAMES utf8",
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
    function url(string $path = null): string
    {
        if ($path) {
            return URL_BASE. $path;
        }

        return URL_BASE;
    }

    function redirect($route, $external = false)
    {
        if ($external) {
            header("location: " . $route);
            exit;
        }
        
        header("location: " . url($route));
        exit;
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
        return utf8_encode("<div class='message {$type}'>{$message}</div>");
    }

    function loadController(string $controller)
    {
        $route = ROOT . DS . 'theme' . DS . 'pages' . DS . $controller . DS . 'controller.php';

        if (file_exists($route))
            return $route;
        else
            printrx(utf8_encode("<h1 style='text-align: center'>Página {$controller} não encontrada</h1>"));
    }