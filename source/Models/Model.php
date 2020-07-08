<?php


namespace Source\Models;


use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Model
 * @package Source\Models
 *
 * @property Connect $connect
 */
abstract class Model extends DataLayer
{
    /**
     * @var Connect
     */
    protected $connect;

    /**
     * Tabela que vai ser cabeçalho da consulta.
     *
     * @var $table
     */
    protected $table;

    /**
     * Model constructor.
     * @param $entity
     * @param $required
     */
    public function __construct($entity, $required)
    {
        $this->connect = Connect::getInstance();

        parent::__construct($entity, $required);
    }

    /**
     * Setando tabela que vai ser cabeçalho da consulta.
     *
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * Consulta tabela que vai ser cabeçalho da consulta.
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Estrutura responsavel por montar querys mais específicas
     *
     * @param array $data
     * @return array|null
     */
    public function search(array $data): ?array
    {
        $filds = null;
        $joins = [];
        $filters = [];

        foreach ($data as $key => $value) {
            if ($key == "select") {
                $filds = $value;
            } elseif ($key == "join") {
                $joins = $value;
            } elseif ($key == "where") {
                $filters = $value;
            }
        }

        $fild = "*";
        if (! empty($filds)) {
            $fild = implode(" ,", $filds);
        }

        $join = "";
        if (! empty($joins)) {
            $join = [];

            foreach ($joins as $key => $value) {
                $join[] = "INNER JOIN {$key} AS " . ucfirst($key) . " ON " . key($value) . " = " . current($value);
            }

            $join = implode(" ", $join);
        }

        $where = null;
        if (! empty($filters)) {
            $where = [];

            foreach ($filters as $key => $value) {
                $where[] = $key . " = " . $value;
            }
            $where = implode(" AND ", $where);
        }

        if (! empty($where)) {
            $query = "SELECT {$fild} FROM {$this->getTable()} AS " . ucfirst($this->getTable()) . " {$join} WHERE {$where}";
        } else {
            $query = "SELECT {$fild} FROM {$this->getTable()} AS " . ucfirst($this->getTable()) . " {$join}";
        }

        if (isset($data['sql']) && $data['sql']) {
            return $query;
        }

        try {
            $return = $this->connect->query($query)->fetch(true);
        } catch (\Exception $exception) {
            $return = null;
        }

        $returnToArray = null;
        if ($return && ! is_array($return)) {
            $returnToArray[] = $return;
        }

        return $returnToArray ?: $return;
    }
}