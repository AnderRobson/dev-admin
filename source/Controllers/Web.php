<?php

    namespace Source\Controllers;

    use League\Plates\Engine;
    use Theme\Pages\Home\HomeController;
    use Theme\Pages\Banner\BannerController;
    use Theme\Pages\Publication\PublicationController;

    class Web
    {

        /** @var Engine  */
        private $controller;

        /** @var Router */
        private $router;

        public function __construct($router)
        {
            $this->router = $router;
        }

        /**
         * @param Engine $controller
         */
        public function setController($controller): void
        {
            $instanciando = null;
            switch ($controller) {
                case 'home':
                    $instanciando = new HomeController($this->router);
                    break;
                case 'banner':
                    $instanciando = new BannerController($this->router);
                    break;
                case 'publication':
                    $instanciando = new PublicationController($this->router);
            }

            if (! empty($instanciando)) {
                $this->controller = $instanciando;
            } else {
                printrx(utf8_encode("<h1 style='text-align: center'>Construtor da controller {$controller}, n�o implementado</h1>"));
            }
        }

        public function home(array $router)
        {
            redirect("/pages/home");
        }

        public function pages(array $data)
        {
            require loadController($data['page']);
            $this->setController($data['page']);
            $function = ! empty($data['function']) ? $data['function'] : "index";

            unset($data['page']);
            unset($data['function']);
            unset($data['action']);

            if (!empty($data)) {
                $this->controller->$function($data);
            } else {
                $this->controller->$function();
            }
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
            echo "<h1 style='text-align: center'> Pesquisa de publica??o pelo slug !</h1>";
            var_dump($slugPost);
        }
        public function error($data)
        {
            echo "<h1 style='text-align: center'>Web Error " . $data['errcode'] . "</h1>";
        }
    }