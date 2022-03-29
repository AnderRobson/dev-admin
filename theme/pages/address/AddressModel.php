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

    public function getState()
    {
        if (! empty($this->id_state)) {
            $this->state = $this->connect->query("SELECT * FROM states WHERE id = " . $this->id_state)->fetch();
        }

        return $this;
    }

    public function getAllState()
    {
        return $this->connect->query("SELECT * FROM states")->fetchAll();
    }

    public function findByIdPerson($idPerson): AddressModel
    {
        $address = $this->connect->query(
            "SELECT PersonAddress.* FROM person_address AS PersonAddress 
                WHERE PersonAddress.id_person = {$idPerson}")->fetch();

        if (empty($address)) {
            $this->id = '';
            $this->street = '';
            $this->number = '';
            $this->district = '';
            $this->city = '';
            $this->zip_code = '';
            $this->id_state = '';
            $this->updated_at = '';
            $this->created_at = '';

            return $this;
        }

        return $this->findById($address->id_address);
    }
}
