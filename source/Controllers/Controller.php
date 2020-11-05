<?php


namespace Source\Controllers;


use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;
use Exception;
use League\Plates\Engine;
use Source\Models\Configures;
use Source\Models\User;

/**
 * Class Controller
 * @package Source\Controllers
 *
 * @property User $user
 */
abstract class Controller
{
    /** @var Engine */
    protected Engine $view;

    /** @var Router */
    protected Router $router;

    /** @var Optimizer */
    protected Optimizer $seo;

    /** @var User */
    protected User $user;

    /** @var array */
    protected array $configures = [];

    /**
     * Controller constructor.
     * @param $router
     *
     * @throws Exception
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->view = Engine::create(ROOT . DS . "theme" . DS . "pages", "php");
        $this->view->addData(["router" => $this->router]);

        $this->seo = new Optimizer();

        $facebookInformation = $this->getConfigure("facebook_login");
        if (! empty((int) $facebookInformation->id)) {
            $this->seo->openGraph(SITE['NAME'], SITE['LOCALE'], "article")
                ->publisher(SOCIAL["FACEBOOK_PAGE"], SOCIAL["FACEBOOK_AUTHOR"])
                ->twitterCard(SOCIAL["TWITTER_CREATOR"], SOCIAL["TWITTER_SITE"], SITE["DOMAIN"])
                ->facebook($facebookInformation->value['clientId']);
        }

        $this->user = new User();

        if ($this->user->validateLogged()) {
            $this->view->addData(['user' => $this->user->getUser()->getPerson()]);
        }
    }

    public function getConfigure(string $name)
    {
        if ($this->configures[$name]) {
            return $this->configures[$name];
        }

        $this->configures[$name] = (new Configures())->getConfigure($name);

        return $this->configures[$name];
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