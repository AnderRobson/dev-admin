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
                   "type" => "alert",
                   "message" => "Informe seu e-mail e senha para logar"
                ]);

                return;
            }

            $user = (new UserModel())->find("email = :email", "email={$email}")->fetch();

            if (! $user || ! password_verify($password, $user->password)) {
                echo $this->ajaxResponse("message", [
                    "type" => "error",
                    "message" => "E-mail ou senha informados não conferem"
                ]);

                return;
            }

            $_SESSION['user'] = $user->id;
            redirect('pages/home');

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
            if ($data['password'] != $data['password_confirmation']) {
                printrx($data);
            }

            $user = new UserModel();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];

            if (! $user->save()) {
                echo $this->ajaxResponse("message", [
                   "type" => "error",
                   "message" => $user->fail()->getMessage()
                ]);

                return;
            }

            $_SESSION['user'] = $user->id;
            redirect('pages/home');
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("registrar"),
            "",
        )->render();

        echo $this->view->render("login/view/register", [
            "head" => $head
        ]);
    }
}
