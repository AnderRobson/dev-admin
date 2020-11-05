<?php


namespace Source\Models;


/**
 * Class Configures
 * @package Source\Models
 */
class Configures extends Model
{

    /** @var Identificador da configure */
    private $id;

    /** @var Nome da configure */
    private $name;

    /** @var Valor da configure */
    private $value;

    /** @var Status da configure */
    private $status;

    /**
     * Configures constructor.
     */
    public function __construct()
    {
        $this->setTable("configures");

        parent::__construct("configures", ["name", "value", "status"]);
    }

    /**
     * @param $name
     * @return string|null
     */
    public function __get($name)
    {
        if ($name == 'value') {
            return json_decode($this->$name, true);
        }

        return $this->$name;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value): void
    {
        switch ($name) {
            case "value":
                if (is_array($value)) {
                    $value = json_encode($value);
                }

                $this->$name = $value;
                break;
            default:
                $this->$name = $value;
        }

        parent::__set($name, $value);
    }

    public function destroy(): bool
    {
        parent::__set('id', $this->id);
        return parent::destroy();
    }

    /**
     *  Função responsavel por buscar cinfigures do banco de dados.
     *
     * @param string $name
     * @return array|null
     */
    public function getConfigure(string $name)
    {
        return $this->find("name = :name", "name={$name}")->fetch();
    }

    /**
     * @return array|null
     */
    public function getAllConfigures(): ?array
    {
        return $this->find()->order('name')->fetch(true);
    }
}