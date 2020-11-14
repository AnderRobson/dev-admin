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
     * Página index home
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/home"),
            urlFile("upload/images/logo.png", true)
        )->render();

        echo $this->view->render("home/view/index", [
            "head" => $head
        ]);
    }
}
