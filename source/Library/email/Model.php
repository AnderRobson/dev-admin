<?php


namespace Source\Library\email;

use Source\Models\Model;

/**
 * Class EmailModel
 * @package Source\Library\email
 */
class EmailModel extends Model
{
    /**
     * EmailModel constructor.
     */
    public function __construct()
    {
        $this->setTable("emails");

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