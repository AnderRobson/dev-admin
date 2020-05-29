<?php

namespace Theme\pages\home;

use League\Plates\Engine;

class HomeController
{
    /** @var Engine  */
    private $view;

    public function __construct($router)
    {
        $this->view = Engine::create(
            ROOT . DS . 'theme/assets/',
            'php'
        );

        $this->view->addData(["router" => $router]);
    }

    public function index(): void
    {

        echo $this->view->render("home", [
//            "users" => (new User())->find()->order('first_name')->fetch(true)
        ]);
    }
}