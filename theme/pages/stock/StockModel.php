<?php

namespace Theme\Pages\Stock;

use Source\Models\Model;

class StockModel extends Model
{
    public function __construct()
    {
        $this->setTable("stocks");

        parent::__construct("stocks", ["id_product", "title", "slug", "current_value", "code"]);
    }
}
