<?php

namespace Theme\Pages\Login;

use Source\Controllers\Controller;
use Source\Library\email\Email;
use Source\Library\email\EmailModel;
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
    public function forget(array $data = null): void
    {
        if (! empty($data)) {
            $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);

            if (empty($email)) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Informe o seu e-mail para recuperar a senha"
                ]);

                return;
            }

            $user = (new UserModel())->find("email = :email", "email={$email}")->fetch();

            if (empty($user)) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "O e-mail informado não é cadastrado"
                ]);

                return;
            }

            $user->forget = md5(uniqid(rand(), true));
            $user->save();

            $_SESSION["forget"] = $user->id;

            $userName = "{$user->first_name}  {$user->last_name}";
            $replace = [
                "\${USER_NAME}" => $userName,
                "\${LINK_REDIRECT}" => url("reset/{$user->email}/{$user->forget}"),
                "\${SITE_NAME}" => SITE["SHORT_NAME"]
            ];

            $email = new Email();
            $emailBody = (new EmailModel())->getEmail("recuperar_senha", $replace);

            $email->add(
                "Recupere sua senha | " . SITE["SHORT_NAME"],
                $emailBody->value,
                $userName,
                $user->email
            )->send();

            flash("success", "Enviamos um lik de recuperação para seu e-mail");

            echo $this->ajaxResponse("redirect", [
                "url" => url('forget')
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
            url("login"),
            "",
        )->render();

        echo $this->view->render("login/view/forget", [
            "head" => $head,
            'formUser' => $formUser
        ]);
    }

    public function resetPassword(array $data): void
    {
        if (empty($_SESSION["forget"]) || ! $user = (new UserModel())->findById($_SESSION["forget"])) {
            if ($data["password"] != $data["password_confirmation"]) {
                flash("danger", "Não foi possível recuperar, tente novamente");
                echo $this->ajaxResponse("redirect", [
                    "url" => url("forget")
                ]);
                return;
            }
        }

        if (empty($data["password"]) || empty($data["password_confirmation"])) {
            echo $this->ajaxResponse("message", [
                "type" => "warning",
                "message" => "Informe e repita sua nova senha"
            ]);
            return;
        }

        if ($data["password"] != $data["password_confirmation"]) {
            echo $this->ajaxResponse("message", [
                "type" => "warning",
                "message" => "Você informou duas senhas diferentes"
            ]);
            return;
        }

        $user->password = $data["password"];
        $user->forget = null;

        if (! $user->save()) {
            echo $this->ajaxResponse("message", [
                "type" => "warning",
                "message" => $user->fail->getMessage()
            ]);
            return;
        }

        unset($_SESSION["forget"]);

        flash("success", "Sua senha foi atualizada com sucesso");

        echo $this->ajaxResponse("redirect", [
            "url" => url("login")
        ]);
        return;
    }

    /**
     * @param array|null $data
     */
    public function reset(array $data): void
    {
        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data["forget"], FILTER_DEFAULT);

        $errorForget = "Não foi possível recuperar, tente novamente";

        if (empty($email) || empty($forget) || empty($_SESSION["forget"])) {
            flash("danger", $errorForget);
            redirect("forget");
        }

        $user = (new UserModel())->find("email = :email AND forget = :forget", "email={$email}&forget={$forget}")->fetch();

        if (empty($user)) {
            flash("danger", $errorForget);
            redirect("forget");
        }


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
