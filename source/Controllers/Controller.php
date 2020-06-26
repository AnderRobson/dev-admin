<?php


namespace Source\Controllers;


use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Theme\Pages\Home\HomeModel;

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

    /** @var HomeModel */
    protected $user;

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

        if (! empty($_SESSION["user"])) {
            $this->user = (new HomeModel())->findById($_SESSION["user"]);
            $this->view->addData(['user' => $this->user]);
        }
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