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
     * Model constructor.
     * @param $entity
     * @param $required
     */
    public function __construct($entity, $required)
    {
        $this->connect = Connect::getInstance();

        parent::__construct($entity, $required);
    }
}