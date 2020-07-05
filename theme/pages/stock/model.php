<?php

    namespace Theme\Pages\Stock;

    use Source\Models\Model;

    class StockModel extends Model
    {
        public function __construct()
        {
            parent::__construct("stocks", ["id_product", "title", "slug", "current_value", "code"]);
        }
    }