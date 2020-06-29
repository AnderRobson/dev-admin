<?php

    /**
     * Site Minify
     */
    if ($_SERVER["SERVER_NAME"] == "localhost" OR $_SERVER["SERVER_NAME"] == "192.168.0.11") {
        require __DIR__ . DS . "Minify.php";
    }

    /**
     * Retorna o caminho
     *
     * @param string $path
     * @return string
     */
    function url(string $path = null): string
    {
        if ($path) {
            return URL_BASE. "/" . $path;
        }

        return URL_BASE;
    }

    /**
     * @param string $controller
     * @return string
     */
    function loadController(string $controller)
    {
        $route = ROOT . DS . 'theme' . DS . 'pages' . DS . $controller . DS . 'controller.php';

        if (file_exists($route))
            return $route;
        else
            printrx(utf8_encode("<h1 style='text-align: center'>P�gina {$controller} n�o encontrada</h1>"));
    }

    /**
     * Retorna a URL de arquivos
     *
     * @param string $path
     * @return string
     */
    function urlFile(string $path, bool $theme = false): string
    {
        if ($theme) {
            return URL_BLOG . DS . $path;
        }

        return URL_ADMIN . "/theme/upload/" . $path;
    }


    function css(string $file, $time = true)
    {
        $file = "theme/assets/css/" . $file . ".css";
        $fileOnDir = ROOT . DS . $file;

        if ($time && file_exists($fileOnDir)) {
            $file .= "?time=" . fileatime($fileOnDir);
        }

        return "<link rel='stylesheet' href='/Plataforma/dev-admin/{$file}'>";
    }


    function js(string $file, $time = true)
    {
        $file = "theme/assets/js/" . $file . ".js";
        $fileOnDir = ROOT . DS . $file;

        if ($time && file_exists($fileOnDir)) {
            $file .= "?time=" . fileatime($fileOnDir);
        }

        return "<script src='/Plataforma/dev-admin/{$file}'></script>";
    }


    function plugins(string $file, $time = true)
    {
        $return = null;
        $type = explode('.', $file);
        $type = end($type);
        $file = "theme/assets/plugins/" . $file;
        $fileOnDir = ROOT . DS . $file;

        if ($time && file_exists($fileOnDir)) {
            $file .= "?time=" . fileatime($fileOnDir);
        }

        switch ($type) {
            case 'js':
                $return = "<script src='/Plataforma/dev-admin/{$file}'></script>";
            case 'css':
                $return = "<link rel='stylesheet' href='/Plataforma/dev-admin/{$file}'>";
        }

        return $return;
    }

    function bootstrap(string $file, $time = true)
    {
        $return = null;
        $type = explode('.', $file);
        $type = end($type);

        $file = "vendor/twbs/bootstrap/" . $file;
        $fileOnDir = ROOT . DS . $file;

        if ($time && file_exists($fileOnDir)) {
            $file .= "?time=" . fileatime($fileOnDir);
        }

        switch ($type) {
            case 'js':
                $return = "<script src='/Plataforma/dev-admin/{$file}'></script>";
                break;
            case 'css':
                $return = "<link rel='stylesheet' href='/Plataforma/dev-admin/{$file}'>";
        }

        return $return;
    }

    /**
     * @param $route
     * @param bool $external
     */
    function redirect($route, $external = false)
    {
        if ($external) {
            header("location: " . $route);
            exit;
        }

        header("location: " . url($route));
        exit;
    }

    /**
     * @param string $message
     * @param string $type
     * @return string
     */
    function message(string $message, string $type): string
    {
        return utf8_encode("<div class=\"alert alert-{$type}\">{$message}</div>");
    }

    function flash(string $type = null, string $message = null): ?string
    {
        if ($type && $message) {
            $_SESSION['FLASH'] = [
                "type" => $type,
                "message" => $message
            ];

            return null;
        }

        if (! empty($_SESSION['FLASH'])) {
            $flash = $_SESSION['FLASH'];
            unset($_SESSION['FLASH']);

            return message($flash['message'], $flash['type']);
        }

        return null;
    }