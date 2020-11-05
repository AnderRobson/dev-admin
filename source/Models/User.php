<?php


namespace Source\Models;


use Exception;
use Theme\Pages\User\UserModel;

/**
 * Class User
 * @package Source\Models
 */
class User
{
    /** @var UserModel */
    private UserModel $user;

    /** @var bool */
    private bool $islogged;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->user = (new UserModel())->findById($_SESSION['user']);

        $this->islogged = (bool) $this->user;
    }

    /**
     * Responsavel por limpar a sess�o
     */
    public function destruct(): void
    {
        unset($_SESSION["user"]);
    }

    /**
     * Responsavel por validar se tem um usu�rio logado
     *
     * @return bool
     */
    public function validateLogged(): bool
    {
        if ($this->islogged) {
            return $this->islogged;
        }

        $this->destruct();
        return $this->islogged;
    }

    /**
     * Responsavel por retornar usu�rio logado.
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
        throw new Exception('Voc� n�o esta logado !');
    }
}
