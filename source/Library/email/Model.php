<?php


namespace Source\Library\email;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class EmailModel
 * @package Source\Library\email
 */
class EmailModel extends DataLayer
{
    /**
     * EmailModel constructor.
     */
    public function __construct()
    {
        parent::__construct("emails", ["name", "type", "status", "value"]);
    }

    /**
     *  Retorna corpo do email.
     *
     * @param $name
     * @return string|null
     */
    public function getEmail(string $name, array $replace): ?EmailModel
    {
        $email = $this->find("name = :name", "name={$name}")->fetch();
        $email->value = $this->emailReplace($email->value, $replace);

        return $email;
    }

    private function emailReplace(string $emailBody, array $replace)
    {
        foreach ($replace as $key => $value) {
            $emailBody = str_replace($key, $value, $emailBody);
        }

        return $emailBody;
    }
}