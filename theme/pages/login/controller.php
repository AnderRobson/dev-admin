<?php

namespace Theme\Pages\Login;

use Source\Controllers\Controller;
use Theme\Pages\User\UserModel;

/**
 * Class LoginController
 * @package Theme\Pages\Login
 */
class LoginController extends Controller
{
    /**
     * LoginController constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * @param array|null $data
     */
    public function index(array $data = null): void
    {
        if (! empty($data)) {
            $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
            $password = filter_var($data['password'], FILTER_DEFAULT);

            if (! $email || ! $password) {
                echo $this->ajaxResponse("message", [
                   "type" => "danger",
                   "message" => "Informe seu e-mail e senha para logar!"
                ]);

                return;
            }

            $user = (new UserModel())->find("email = :email", "email={$email}")->fetch();

            if (! $user || ! password_verify($password, $user->password)) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "E-mail ou senha informados não conferem!"
                ]);

                return;
            }

            $_SESSION['user'] = $user->id;
            echo $this->ajaxResponse("redirect", [
                "url" => url('pages/home')
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("login"),
            "",
        )->render();

        echo $this->view->render("login/view/index", [
            "head" => $head
        ]);
    }

    /**
     * @param array|null $data
     */
    public function register(array $data = null): void
    {
        if (! empty($data)) {
//            $data = filter_var($data, FILTER_SANITIZE_STRIPPED);

            if (in_array("", $data)) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Preencha todos os campos !"
                ]);

                return;
            }

            $user = new UserModel();
            $user->first_name = $data['name'];
            $user->last_name = $data['sobrenome'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);


            if (! $user->save()) {
                echo $this->ajaxResponse("message", [
                   "type" => "danger",
                   "message" => $user->fail()->getMessage()
                ]);

                return;
            }

            $_SESSION['user'] = $user->id;
            echo $this->ajaxResponse("redirect", [
                "url" => url('pages/home')
            ]);
            return;
        }

        $formUser = new \stdClass();
        $formUser->first_name = null;
        $formUser->last_name = null;
        $formUser->email = null;

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("register"),
            "",
        )->render();

        echo $this->view->render("login/view/register", [
            "head" => $head,
            'formUser' => $formUser
        ]);
    }

    /**
     * @param array|null $data
     */
    public function forget(): void
    {
        $formUser = new \stdClass();
        $formUser->first_name = null;
        $formUser->last_name = null;
        $formUser->email = null;

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("login"),
            "",
        )->render();

        echo $this->view->render("login/view/forget", [
            "head" => $head,
            'formUser' => $formUser
        ]);
    }

    /**
     * @param array|null $data
     */
    public function reset(array $data): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("login"),
            "",
        )->render();

        echo $this->view->render("login/view/reset", [
            "head" => $head,
            'data' => $data
        ]);
    }
}
