<?php


namespace Source\Controllers;


use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Source\Models\Configures;
use Theme\Pages\User\UserModel;

/**
 * Class Controller
 * @package Source\Controllers
 *
 * @property UserModel $user
 */
abstract class Controller
{
    /** @var Engine */
    protected $view;

    /** @var Router */
    protected $router;

    /** @var Optimizer */
    protected $seo;

    /** @var UserModel */
    protected $user;

    /** @var Configures */
    private $configures;

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

        $facebookInformation = $this->getConfigure("facebook_login");
        if (! empty($facebookInformation)) {
            $this->seo->openGraph(SITE['NAME'], SITE['LOCALE'], "article")
                ->publisher(SOCIAL["FACEBOOK_PAGE"], SOCIAL["FACEBOOK_AUTHOR"])
                ->twitterCard(SOCIAL["TWITTER_CREATOR"], SOCIAL["TWITTER_SITE"], SITE["DOMAIN"])
                ->facebook($facebookInformation->clientId);
        }

        if (! empty($_SESSION["user"]) && $this->user = (new UserModel())->findById($_SESSION['user'])->getPerson()) {
            $this->view->addData(['user' => $this->user]);
        }
    }

    public function getConfigure(string $name): ?\stdClass
    {
        return (new Configures())->getConfigure($name);
    }

    /**
     * @param string $param
     * @param array $values
     * @return string
     */
    public function ajaxResponse(string $param, array $values): string
    {
        if (! empty($values["message"])) {
            $values["message"] = utf8_encode($values["message"]);
        }

        return json_encode([$param => $values]);
    }
}