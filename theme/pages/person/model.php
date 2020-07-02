<?php


namespace Theme\pages\person;

use Source\Models\Model;
use Theme\pages\address\AddressModel;

class PersonModel extends Model
{
    public function __construct()
    {
        parent::__construct("persons", ["first_name", "last_name", "date_birth"]);
    }

    public function getAddress(): PersonModel
    {
        $this->address = (new AddressModel())->findByIdPerson($this->id);

        return $this;
    }
}
