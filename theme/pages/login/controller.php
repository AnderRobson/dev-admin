<?php

namespace Theme\Pages\Login;

use League\Plates\Engine;
use Theme\Pages\User\UserModel;

class LoginController
{
    /** @var Engine  */
    private $view;

    public function __construct($router)
    {
        $this->view = Engine::create(
            ROOT . DS . 'theme/pages/',
            'php'
        );

        $this->view->addData(["router" => $router]);

        return $this;
    }

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
            redirect('/pages/home');

            return;
        }

        echo $this->view->render("login/view/index");
    }

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
                printrx($user->fail()->getMessage());

                echo $this->ajaxResponse("message", [
                   "type" => "error",
                   "message" => $user->fail()->getMessage()
                ]);

                return;
            }

            $_SESSION['user'] = $user->id;
            redirect('/pages/home');
        }

        echo $this->view->render("login/view/register");
    }
}
