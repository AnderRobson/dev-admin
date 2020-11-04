<?php


namespace Theme\Pages\Address;

use CoffeeCode\DataLayer\Connect;
use Source\Models\Model;

/**
 * Class AddressModel
 * @package Theme\Pages\Address
 *
 * @property Connect $connect
 */
class AddressModel extends Model
{
    public function __construct()
    {
        $this->setTable("address");

        parent::__construct("address", ["street", "number", "district", "city", "zip_code", "id_state"]);
    }

    public function getAllState()
    {
        return $this->connect->query("SELECT * FROM states")->fetchAll();
    }
}
