<?php

namespace Theme\Pages\Home;

use Source\Controllers\Controller;

/**
 * Class HomeController
 * @package Theme\Pages\Home
 */
class HomeController extends Controller
{

    /**
     * HomeController constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * Página index home
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/home"),
            "",
        )->render();

        echo $this->view->render("home/view/index", [
            "head" => $head
        ]);
    }
}
