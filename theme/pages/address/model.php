<?php


namespace Theme\pages\address;

use CoffeeCode\DataLayer\Connect;
use Source\Models\Model;

/**
 * Class AddressModel
 * @package Theme\pages\address
 *
 * @property Connect $connect
 */
class AddressModel extends Model
{
    public function __construct()
    {
        $this->setTable("address");

        parent::__construct("address", ["street", "number", "district", "city", "id_state"]);
    }

    public function getAllState()
    {
        return $this->connect->query("SELECT * FROM states")->fetchAll();
    }
}
