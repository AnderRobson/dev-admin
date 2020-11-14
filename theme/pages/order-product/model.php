<?php


namespace Theme\Pages\OrderProduct;


use Source\Models\Model;
use Theme\Pages\Product\ProductModel;

class OrderProductModel extends Model
{

    public function __construct()
    {
        $this->setTable("orders_products");

        parent::__construct("orders_products", ["id_order", "id_product", "id_stock", "status", "value", "old_value", "quantity"]);
    }

    public function reset(): OrderProductModel
    {
        return new OrderProductModel();
    }

    public function getProduct()
    {
        $this->product = (new ProductModel())->findById($this->id_product);

        return $this;
    }
}