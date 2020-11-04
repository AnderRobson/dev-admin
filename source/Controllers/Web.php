<?php

namespace Source\Controllers;

use League\Plates\Engine;
use Theme\Pages\Login\LoginController;
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
     * Responsavel por instanciar Controller
     *
     * @param string $controllerName
     */
    private function setController(string $controllerName): void
    {
        $controller = null;
        $controllerName = str_replace('-', '', ucwords($controllerName, '-'));
        $namespace = 'Theme\Pages\\' . $controllerName;
        $className = $namespace . '\\' . $controllerName . 'Controller';

        if (class_exists($className)) {
            $controller = new $className($this->router);
        }

        if (! empty($controller)) {
            $this->controller = $controller;
        } else {
            redirect('pages/home');
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

            flash("danger", "Acesso negado. Favor logue-se");
            redirect("login");
        }

        $this->setController($data['page']);
        $function = ! empty($data['function']) ? $data['function'] : "index";

        unset($data['page']);
        unset($data['function']);
        unset($data['action']);

        if (! empty($data)) {
            $this->controller->$function($data);
        } else {
            $this->controller->$function();
        }
    }

    /**
     * Responsavel por tratar rota de login
     *
     * @param array $data
     */
    public function login(array $data = []): void
    {
        if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
            redirect("pages/home");
        }

        $this->controller = new LoginController($this->router);

        $this->controller->index($data);
    }

    /**
     * Responsavel por desconectar usuário
     */
    public function logoff(): void
    {
        unset($_SESSION["user"]);

        flash("success", "Você saiu com sucesso, volte logo {$this->user->person->first_name}!");
        unset($this->user);

        redirect("login");
    }

    /**
     * Responsavel por tratar rota de recuperação de senha
     *
     * @param array $data
     */
    public function forget(array $data = []): void
    {
        if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
            redirect("pages/home");
        }

        $this->controller = new LoginController($this->router);

        $this->controller->forget($data);
    }

    public function reset(array $data): void
    {
        if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
            redirect("pages/home");
        }

        $this->controller = new LoginController($this->router);

        $this->controller->reset($data);
    }

    public function resetPassword(array $data): void
    {
        if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
            redirect("pages/home");
        }

        $this->controller = new LoginController($this->router);

        $this->controller->resetPassword($data);
    }

    /**
     * @param array $data
     */
    public function register(array $data = []): void
    {
        if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
            redirect("pages/home");
        }

        $this->controller = new LoginController($this->router);

        if (! empty($data)) {
            $this->controller->register($data);
        } else {
            $this->controller->register();
        }
    }

    public function facebook(array $data = []): void
    {
        if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
            redirect("pages/home");
        }

        $this->controller = new LoginController($this->router);

        if (! empty($data)) {
            $this->controller->facebook($data);
        } else {
            $this->controller->facebook();
        }
    }

    public function google(array $data = []): void
    {
        if (! empty($_SESSION['user']) && $this->user = (new UserModel())->findById($_SESSION['user'])) {
            redirect("pages/home");
        }

        $this->controller = new LoginController($this->router);

        if (! empty($data)) {
            $this->controller->google($data);
        } else {
            $this->controller->google();
        }
    }

    /**
     * Auxiliares
     */
    /**
     * @param $slugPost
     */
    public function slugPost($slugPost)
    {
        echo "<h1 style='text-align: center'> Pesquisa de publicação pelo slug !</h1>";
        var_dump($slugPost);
    }

    /**
     * @param $errcode
     */
    public function error($errcode): void
    {
        $errcode = filter_var($errcode["errcode"], FILTER_VALIDATE_INT);

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("home"),
            ""
        )->render();

        echo $this->view->render("error/error", [
            'errcode' => $errcode,
            'head' => $head
        ]);
    }
}