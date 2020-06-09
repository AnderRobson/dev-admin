<?php

    namespace Source\Controllers;

    use League\Plates\Engine;
    use Theme\Pages\Home\HomeController;
    use Theme\Pages\Banner\BannerController;
    use Theme\Pages\Publication\PublicationController;
    use Theme\Pages\Exemplos\ExemploController;

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
        public function setController($controllerName): void
        {
            $controller = null;
            switch ($controllerName) {
                case 'home':
                    $controller = new HomeController($this->router);
                    break;
                case 'banner':
                    $controller = new BannerController($this->router);
                    break;
                case 'publication':
                    $controller = new PublicationController($this->router);
                    break;
                case 'exemplos':
                    $controller = new ExemploController($this->router);
                    break;
            }

            if (! empty($controller)) {
                $this->controller = $controller;
            } else {
                printrx(utf8_encode("<h1 style='text-align: center'>Construtor da controller {$controllerName}, não implementado</h1>"));
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