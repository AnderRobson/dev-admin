<?php

    namespace Source\Controllers;

    use League\Plates\Engine;
    use Theme\Pages\Home\HomeController;
    use Theme\Pages\Banner\BannerController;
    use Theme\Pages\Login\LoginController;
    use Theme\Pages\Publication\PublicationController;
    use Theme\Pages\Exemplos\ExemploController;
    use Theme\Pages\User\UserModel;

    /**
     * Class Web
     * @package Source\Controllers
     */
    class Web extends Controller
    {
        /** @var UserModel */
        protected $user;

        /** @var Engine  */
        private $controller;

        /**
         * Web constructor.
         * @param $router
         */
        public function __construct($router)
        {
            parent::__construct($router);
        }

        /**
         * @param Engine $controller
         */
        public function setController(string $controllerName): void
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
                printrx(utf8_encode("<h1 style='text-align: center'>Construtor da controller {$controllerName}, n?o implementado</h1>"));
            }
        }

        /**
         *  redirect caso URL seja apenas /
         */
        public function home(): void
        {
            redirect("pages/home");
        }

        /**
         * @param array $data
         */
        public function pages(array $data): void
        {
            if (empty($_SESSION['user']) || ! $this->user = (new UserModel())->findById($_SESSION['user'])) {
                unset($_SESSION["user"]);

//                flash("error", "Acesso negado. Favor logue-se");
                redirect("login");
            }

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

        /**
         * @param array|null $data
         */
        public function login(array $data = null): void
        {
            if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
                redirect("pages/home");
            }

            require loadController('login');
            $this->controller = new LoginController($this->router);

            if (! empty($data)) {
                $this->controller->index($data);
            } else {
                $this->controller->index();
            }
        }

        /**
         *
         */
        public function logoff(): void
        {
            unset($_SESSION["user"]);

//            flash("info", "Você saiu com sucesso, volte logo {$this->user->name}");
            redirect("login");
        }

        /**
         * @param array|null $data
         */
        public function register(array $data = null): void
        {
            if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
                redirect("pages/home");
            }

            require loadController('login');
            $this->controller = new LoginController($this->router);

            if (! empty($data)) {
                $this->controller->register($data);
            } else {
                $this->controller->register();
            }
        }

        /**
         * @param $slugPost
         */
        public function slugPost($slugPost)
        {
            echo "<h1 style='text-align: center'> Pesquisa de publicação pelo slug !</h1>";
            var_dump($slugPost);
        }

        /**
         * @param $data
         */
        public function error($data)
        {
            echo "<h1 style='text-align: center'>Web Error " . $data['errcode'] . "</h1>";
        }
    }