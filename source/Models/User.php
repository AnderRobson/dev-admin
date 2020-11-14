<?php


namespace Source\Models;


use Exception;
use Theme\Pages\Order\OrderModel;
use Theme\Pages\User\UserModel;

/**
 * Class User
 * @package Source\Models
 */
class User
{
    /** @var UserModel */
    private $user;

    /** @var bool */
    private bool $islogged;

    /** @var array OrderModel Pedidos do usuário */
    private array $orders = [];

    /**
     * User constructor.
     */
    public function __construct()
    {
        $usarId = filter_var($_SESSION['user'], FILTER_VALIDATE_INT);

        $this->user = ! empty($usarId) ? (new UserModel())->findById($usarId) : false;

        $this->islogged = (bool) $this->user;
    }

    /**
     * Responsavel por limpar a sessão
     */
    public function destruct(): void
    {
        unset($_SESSION["user"]);
        $this->islogged = false;
    }

    public function login(string $email, string $password): bool
    {
        if (! empty($_SESSION['user'])) {
            return true;
        }

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $password = filter_var($password, FILTER_DEFAULT);

        $user = (new UserModel())->find("email = :email", "email={$email}")->fetch();

        if (! $user || ! password_verify($password, $user->password)) {
            return false;
        }

        $_SESSION['user'] = $user->id;
        $this->user = $user;

        /** Validação de rede-social */
        $this->socialValidate();

        return true;
    }

    /**
     * Responsavel por validar se tem um usuário logado
     *
     * @return bool
     */
    public function validateLogged(): bool
    {
        if (! $this->islogged) {
            $this->destruct();
        }

        return $this->islogged;
    }

    /**
     * Responsavel por retornar usuário logado.
     *
     * @return UserModel
     *
     * @throws Exception
     */
    public function getUser(): UserModel
    {
        if ($this->islogged) {
            return $this->user;
        }

        $this->destruct();
        throw new Exception('Você não esta logado !');
    }

    /**
     *  Valida se existe uma Classe de rede social na sessão e vincula ao usuário logado.
     *
     * @param UserModel $user
     */
    private function socialValidate(): void
    {
        /**
         *  Facebook
         */
        if (! empty($_SESSION["facebook_auth"])) {
            $facebookUser = unserialize($_SESSION["facebook_auth"]);

            $this->user->facebook_id = $facebookUser->getId();

            if (empty($this->user->photo)) {
                $this->user->photo = $facebookUser->getPictureUrl();
            }

            $this->user->save();

            unset($_SESSION["facebook_auth"]);
        }

        /**
         *  Google
         */
        if (! empty($_SESSION["google_auth"])) {
            $googleUser = unserialize($_SESSION["google_auth"]);

            $this->user->google_id = $googleUser->getId();

            if (empty($this->user->photo)) {
                $this->user->photo = $googleUser->getAvatar();
            }

            $this->user->save();

            unset($_SESSION["google_auth"]);
        }
    }

    public function getOrders(): ?array
    {
        if (! empty($this->orders)) {
            return $this->orders;
        }

        $this->orders = (new OrderModel())->find(
            'id_user = :id_user',
            'id_user=' . $this->user->id
        )->fetch(true);

        return $this->orders;
    }

    public function setOrders($orders)
    {
        $this->orders = $orders;
    }
}
