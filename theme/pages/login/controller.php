<?php

namespace Theme\Pages\Login;

use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\GoogleUser;
use Source\Controllers\Controller;
use Source\Library\email\Email;
use Source\Library\email\EmailModel;
use Theme\Pages\User\UserModel;

/**
 * Class LoginController
 *
 * @property $email Email
 * @property $emailBody EmailModel
 * @property $google Google
 * @property $googleUser GoogleUser
 * @property $facebook Facebook
 * @property $facebookUser FacebookUser
 *
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

            /** Validação de rede-social */
            $this->socialValidate($user);

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

            /** Validação de rede-social */
            $this->socialValidate($user);

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

        $socialUser = (
            ! empty($_SESSION["facebook_auth"])
                ? unserialize($_SESSION["facebook_auth"])
                : (
                    ! empty($_SESSION["google_auth"])
                        ? unserialize($_SESSION["google_auth"])
                        : null
                )
        );

        if (! empty($socialUser)) {
            $formUser->first_name = $socialUser->getFirstName();
            $formUser->last_name = $socialUser->getLastName();
            $formUser->email = $socialUser->getEmail();
        }

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
     *  Responsavel por realizar a solicitação de recuperação de senha.
     *
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

    /**
     *  Responsavel por salvar nova senha pos resetar a senha.
     *
     * @param array $data
     */
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
     *  Responsavel por resetar senhar, acessando url enviado para o e-mail.
     *
     * @param array $data
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

    /**
     *  Realizando login via autenticação Facebook.
     *
     * @param array|null $data
     */
    public function facebook(): void
    {
        $configure = $this->getConfigure("facebook_login");

        if (empty($configure)) {
            flash("danger", "Login com o Facebook não configurado");
            redirect("login");
        }

        $facebook = new Facebook([
            "clientId" => $configure->clientId,
            "clientSecret" => $configure->clientSecret,
            "redirectUri" => $configure->redirectUri,
            "graphApiVersion" => $configure->graphApiVersion
        ]);

        $error = filter_input(INPUT_GET, "error", FILTER_SANITIZE_STRIPPED);
        $code = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRIPPED);

        if (! $error && ! $code) {
            $authUrl = $facebook->getAuthorizationUrl(["scope" => "email"]);
            redirect($authUrl, true);
            return;
        }

        if ($error) {
            flash("danger", "Não foi possível logar com o Facebook");
            redirect("login");
            return;
        }

        if ($code && empty($_SESSION["facebook_auth"])) {
            try {
                $token = $facebook->getAccessToken("authorization_code", ["code" => $code]);
                $_SESSION["facebook_auth"] = serialize($facebook->getResourceOwner($token));
            } catch (\Exception $exception) {
                flash("danger", "Não foi possível logar com o Facebook");
                redirect("login");
                return;
            }
        }

        $facebookUser = unserialize($_SESSION["facebook_auth"]);

        /** Login pelo Facebook */
        $userById = (new UserModel())->find("facebook_id = :facebook_id", "facebook_id={$facebookUser->getId()}")->fetch();
        if (! empty($userById)) {
            unset($_SESSION["facebook_auth"]);
            $_SESSION["user"] = $userById->id;
            redirect("pages/home");
            return;
        }

        /** Login pelo email */
        $userByEmail = (new UserModel())->find("email = :email", "email={$facebookUser->getEmail()}")->fetch();
        if (! empty($userByEmail)) {
            flash("warning", "Olá {$facebookUser->getFirstName()}, faça login para conectar sua conta Facebook");
            redirect("login");
            return;
        }

        /** Registrar usuário via Facebook */
        flash(
            "warning",
            "Olá {$facebookUser->getFirstName()}, <strong>se já tem uma conta clique em <a title='Fazer Login' href='" . url("login") . "'>FAZER LOGIN</a></strong>, ou complete seu cadastro"
        );
        redirect("register");
        return;
    }

    /**
     *  Realizando login via autenticação Google.
     *
     */
    public function google(): void
    {
        $configure = $this->getConfigure("google_login");

        if (empty($configure)) {
            flash("danger", "Login com o Google não configurado");
            redirect("login");
        }

        $google = new Google([
            "clientId" => $configure->clientId,
            "clientSecret" => $configure->clientSecret,
            "redirectUri" => $configure->redirectUri
        ]);

        $error = filter_input(INPUT_GET, "error", FILTER_SANITIZE_STRIPPED);
        $code = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRIPPED);

        if (! $error && ! $code) {
            $authUrl = $google->getAuthorizationUrl();
            redirect($authUrl, true);
            return;
        }

        if ($error) {
            flash("danger", "Não foi possível logar com o Google");
            redirect("login");
            return;
        }

        if ($code && empty($_SESSION["google_auth"])) {
            try {
                $token = $google->getAccessToken("authorization_code", ["code" => $code]);
                $_SESSION["google_auth"] = serialize($google->getResourceOwner($token));
            } catch (\Exception $exception) {
                flash("danger", "Não foi possível logar com o Google");
                redirect("login");
                return;
            }
        }

        $googleUser = unserialize($_SESSION["google_auth"]);

        /** Login pelo Google */
        $userById = (new UserModel())->find("google_id = :google_id", "google_id={$googleUser->getId()}")->fetch();
        if (! empty($userById)) {
            unset($_SESSION["google_auth"]);
            $_SESSION["user"] = $userById->id;
            redirect("pages/home");
            return;
        }

        /** Login pelo email */
        $userByEmail = (new UserModel())->find("email = :email", "email={$googleUser->getEmail()}")->fetch();
        if (! empty($userByEmail)) {
            flash("warning", "Olá {$googleUser->getFirstName()}, faça login para conectar sua conta Google");
            redirect("login");
            return;
        }

        /** Registrar usuário via Google */
        flash(
            "warning",
            "Olá {$googleUser->getFirstName()}, <strong>se já tem uma conta clique em <a title='Fazer Login' href='" . url("login") . "'>FAZER LOGIN</a></strong>, ou complete seu cadastro"
        );
        redirect("register");
        return;
    }

    /**
     *  Valida se existe uma Classe de rede social na seção e vincula ao usuário logado.
     *
     * @param UserModel $user
     */
    public function socialValidate(UserModel $user): void
    {
        /**
         *  Facebook
         */
        if (! empty($_SESSION["facebook_auth"])) {
            $facebookUser = unserialize($_SESSION["facebook_auth"]);

            $user->facebook_id = $facebookUser->getId();
            $user->photo = $facebookUser->getPictureUrl();
            $user->save();

            unset($_SESSION["facebook_auth"]);
        }

        /**
         *  Google
         */
        if (! empty($_SESSION["google_auth"])) {
            $googleUser = unserialize($_SESSION["google_auth"]);

            $user->google_id = $googleUser->getId();
            $user->photo = $googleUser->getAvatar();
            $user->save();

            unset($_SESSION["google_auth"]);
        }
    }
}
