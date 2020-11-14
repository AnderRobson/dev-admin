<?php

namespace Theme\Pages\Product;

use Source\Models\Model;
use Theme\Pages\ProductImage\ProductImageModel;
use Theme\Pages\Stock\StockModel;

class ProductModel extends Model
{
    public function __construct()
    {
        $this->setTable("products");

        parent::__construct("products", ["title", "slug", "code", "description"]);
    }

    public function getImage()
    {
        $idProduct = $this->id;

        $result = (new ProductImageModel())->find('id_product=:id_product', ':id_product=' . $idProduct)->fetch();

        if (empty($result)) {
            $result = new \stdClass();
            $result->image = 'semimage.png';
        }

        return $result;
    }

    public function getStock()
    {
        $this->stock = (new StockModel())->find('id_product = :id_product', 'id_product=' . $this->id)->fetch();
        return $this->stock;
    }
}
