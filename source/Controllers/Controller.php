<?php


namespace Source\Controllers;


use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;
use League\Plates\Engine;

/**
 * Class Controller
 * @package Source\Controllers
 */
abstract class Controller
{
    /** @var Engine */
    protected $view;

    /** @var Router */
    protected $router;

    /** @var Optimizer */
    protected $seo;

    /**
     * Controller constructor.
     * @param $router
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->view = Engine::create(ROOT . DS . "theme" . DS . "pages", "php");
        $this->view->addData(["router" => $this->router]);

        $this->seo = new Optimizer();
        $this->seo->openGraph(SITE['NAME'], SITE['LOCALE'], "article")
            ->publisher(SOCIAL["FACEBOOK_PAGE"], SOCIAL["FACEBOOK_AUTHOR"])
            ->twitterCard(SOCIAL["TWITTER_CREATOR"], SOCIAL["TWITTER_SITE"], SITE["DOMAIN"])
            ->facebook(SOCIAL["FACEBOOK_APP_ID"]);
    }

    /**
     * @param string $param
     * @param array $values
     * @return string
     */
    public function ajaxResponse(string $param, array $values): string
    {
        return json_encode([$param => $values]);
    }
}