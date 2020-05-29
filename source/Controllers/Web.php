<?php

    namespace Source\Controllers;

    use League\Plates\Engine;
    use Theme\pages\home\HomeController;
    use function Composer\Autoload\includeFile;

    class Web
    {

        /** @var Engine  */
        private $controller;

        public function __construct($router)
        {
            require loadController("home");
            $this->controller = new HomeController($router);
        }

        public function __call($function, $args)
        {
            var_dump('Fnção não existe !');
//            require loadController("home");
//            HomeController::index();
        }

        public function home(array $router)
        {
            $this->controller->index();
        }

        public function create(array $data)
        {
            $callback["data"] = $data;
            echo json_encode($data);
        }

        public function delete(array $data)
        {
            $callback["data"] = $data;
            echo json_encode($data);
        }

        public function load(array $data)
        {
            includeFile(ROOT . DS . 'theme/assets/' . $data['pasta'] . DS . $data['arquivo'] . '.' . $data['type']);
        }

        public function banner($data)
        {
            echo "<h1 style='text-align: center'> Bem vindo a tela banner</h1>";
        }

        public function slugPost($slugPost)
        {
            echo "<h1 style='text-align: center'> Pesquisa de publicação pelo slug !</h1>";
            var_dump($slugPost);
        }
        public function error($data)
        {
            echo "<h1 style='text-align: center'>Web Error " . $data['errcode'] . "</h1>";
        }
    }