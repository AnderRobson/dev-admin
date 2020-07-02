<?php


namespace Theme\pages\address;

use Source\Models\Model;

/**
 * Class AddressModel
 * @package Theme\pages\address
 *
 *
 */
class AddressModel extends Model
{
    public function __construct()
    {
        parent::__construct("address", ["street", "number", "district", "city", "id_state"]);
    }

    public function findByIdPerson($idPerson): AddressModel
    {
        $address = $this->connect->query(
            "SELECT Address.* FROM person_address AS PersonAddress
                          INNER JOIN address AS Address 
                            ON Address.id = PersonAddress.id_address
                      WHERE
                          PersonAddress.id_person = {$idPerson}
                            ")->fetch();

        $this->id = $address->id;
        $this->street = $address->street;
        $this->number = $address->number;
        $this->district = $address->district;
        $this->city = $address->city;
        $this->id_state = $address->id_state;
        $this->updated_at = $address->updated_at;
        $this->created_at = $address->created_at;

        return $this;
    }
}
