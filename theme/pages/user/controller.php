<?php

namespace Theme\Pages\User;

use Source\Controllers\Controller;

/**
 * Class UserController
 * @package Theme\Pages\Exemplos
 */
class UserController extends Controller
{
    /**
     * P�gina index exemplo
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/user"),
            ""
        )->render();

        echo $this->view->render("user/view/index", [
            'head' => $head
        ]);
    }
}
