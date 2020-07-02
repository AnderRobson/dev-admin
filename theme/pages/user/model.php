<?php

namespace Theme\Pages\User;

use Exception;
use Source\Models\Model;
use Theme\pages\person\PersonModel;

/**
 * Class UserModel
 * @package Theme\Pages\User
 *
 * @property PersonModel $person
 */
class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct("users", ["id_person", "email", "password"]);
    }

    public function getPerson()
    {
        $this->person = (new PersonModel())->findById($this->id_person);

        return $this;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (! $this->validateEmail() ||
            ! $this->validatePassword() ||
            ! parent::save()
        ) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validateEmail(): bool
    {
        if (empty($this->email) || ! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->fail = new Exception("Inform um e-mail válido !");
            return false;
        }

        $userByEmail = null;
        if (! $this->id) {
            $userByEmail = $this->find("email = :email", "email={$this->email}")->count();
        } else {
            $userByEmail = $this->find("email = :email AND id != :id", "email={$this->email}&id={$this->id}")->count();
        }

        if ($userByEmail) {
            $this->fail = new Exception("O e-mail informado já está em uso !");
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validatePassword(): bool
    {
        if (empty($this->password) || strlen($this->password) < 5) {
            $this->fail = new Exception("Informe ua senha com pelo menos 5 caracteres !");
            return false;
        }

        if (password_get_info($this->password)['algo']) {
            return true;
        }

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return true;
    }
}
