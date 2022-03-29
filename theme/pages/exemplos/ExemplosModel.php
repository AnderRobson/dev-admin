<?php

namespace Theme\Pages\Exemplos;

use Source\Models\Model;

class ExemplosModel extends Model
{
    public function __construct()
    {
        $this->setTable("users");

        parent::__construct("users", ["first_name"]);
    }
}
