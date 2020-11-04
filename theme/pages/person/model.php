<?php


namespace Theme\Pages\Person;

use Source\Models\Model;
use Theme\Pages\Address\AddressModel;

class PersonModel extends Model
{
    public function __construct()
    {
        $this->setTable("persons");

        parent::__construct("persons", ["first_name", "last_name", "date_birth"]);
    }

    public function getAllInformationFromPersons()
    {
        return $this->search([
            'join' => [
                'person_address' => [
                    'Person_address.id_person' => "Persons.id"
                ],
                'address' => [
                    'Address.id' => "Person_address.id_address"
                ]
            ],
            'where' => [
                'Persons.id' => 1,
            ]
        ], true);
    }

    public function getAllInformationFromPersonById($id): ?\PDORow
    {
        return $this->search([
            'join' => [
                'person_address' => [
                    'Person_address.id_person' => "Persons.id"
                ],
                'address' => [
                    'Address.id' => "Person_address.id_address"
                ],
                'states' => [
                    'States.id' => "Address.id_state"
                ]
            ],
            'where' => [
                'Persons.id' => $id,
            ]
        ]);
    }
}
