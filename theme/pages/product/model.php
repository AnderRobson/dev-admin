<?php

    namespace Theme\Pages\Product;

    use Source\Models\Model;

    class ProductModel extends Model
    {
        public function __construct()
        {
            $this->setTable("products");

            parent::__construct("products", ["title", "slug", "code", "description"]);
        }
    }