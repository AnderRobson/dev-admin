<?php

/**
 * Responsavel por minificar arquivos da pasta assets.
 */
if ($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "192.168.0.11") {
    require __DIR__ . DS . "Minify.php";
}

/**
 * Responsavel por montar url para redirecionamentos dentro da plataforma.
 *
 * @param string|null $path
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
 * Responsavel por retorna a URL de arquivos
 *
 * @param string $path
 * @param bool $theme
 *
 * @return string
 */
function urlFile(string $path, bool $theme = false): string
{
    if ($theme) {
        return URL_BLOG . DS . $path;
    }

    return URL_ADMIN . "/theme/assets/images/" . $path;
}


/**
 * Responsavel por carregar arquivos css da pasta css dentro de assets.
 *
 * @param string $file
 * @param bool $time
 * @return string
 */
function css(string $file, $time = true)
{
    $file = "theme/assets/css/" . $file . ".css";
    $fileOnDir = ROOT . DS . $file;

    if ($time && file_exists($fileOnDir)) {
        $file .= "?time=" . fileatime($fileOnDir);
    }

    return "<link rel='stylesheet' href='" . URL_ADMIN . "/{$file}'>";
}


/**
 * Responsavel por carregar arquivos js da pasta js dentro de assets.
 *
 * @param string $file
 * @param bool $time
 * @return string
 */
function js(string $file, $time = true)
{
    $file = "theme/assets/js/" . $file . ".js";
    $fileOnDir = ROOT . DS . $file;

    if ($time && file_exists($fileOnDir)) {
        $file .= "?time=" . fileatime($fileOnDir);
    }

    return "<script src='" . URL_ADMIN . "/{$file}'></script>";
}


/**
 * Responsavel por carregar plugins da pasta assets.
 *
 * @param string $file
 * @param bool $time
 * @return string
 */
function plugins(string $file, $time = true)
{
    $return = '';
    $type = explode('.', $file);
    $type = end($type);
    $file = "theme/assets/plugins/" . $file;
    $fileOnDir = ROOT . DS . $file;

    if ($time && file_exists($fileOnDir)) {
        $file .= "?time=" . fileatime($fileOnDir);
    }

    switch ($type) {
        case 'js':
            $return = "<script src='" . URL_ADMIN . "/{$file}'></script>";
            break;
        case 'css':
            $return = "<link rel='stylesheet' href='" . URL_ADMIN . "/{$file}'>";
    }

    return $return;
}

/**
 * Redirecionamento de urls.
 *
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
 * Respons�vel por criar html de mensagens de alerta.
 *
 * @param string $message
 * @param string $type
 * @return string
 */
function message(string $message, string $type): string
{
    return utf8_encode("<div class=\"alert alert-{$type}\">{$message}</div>");
}

/**
 * Respons�vel por criar e renderizar mensagens gravadas na sess�o.
 *
 * @param string|null $type
 * @param string|null $message
 * @return string|null
 */
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

/**
 * Gerador de slug de url.
 *
 * @param $string
 * @return string
 */
function slugify($string): string
{
    return
        strtolower(
            trim(
                preg_replace(
                    '/[^A-Za-z0-9-]+/',
                    '-', $string
                ),
                '-'
            )
        );
}

/**
 * Responsavel por montar filtros para find.
 *
 * @param array $filters
 * @return array
 */
function mountFilters(array $filters): array
{
    $return = [
        "keysFilter" => null,
        "valueToFilter" => null
    ];

    foreach ($filters as $keysFilter => $valueToFilter) {
        $return["keysFilter"][] = $keysFilter . " = :" . $keysFilter;
        $return["valueToFilter"][] =$keysFilter . "=" . $valueToFilter;
    }

    return [
        "keysFilter" => implode(" AND ", $return["keysFilter"]),
        "valueToFilter" => implode(" AND ", $return["valueToFilter"]),
    ];
}

/**
 * Responsavel pormatar o valor no padr�o brasileiro.
 *
 * @param string $currency
 * @param bool $full
 * @return string
 */
function currencyFormatter(string $currency, bool $full = true): string
{
    $currency = number_format($currency, 2, ",", ".");

    if ($full) {
        $currency = "R$ " . $currency;
    }
    return $currency;
}
