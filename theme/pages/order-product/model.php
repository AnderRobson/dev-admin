<?php


namespace Theme\Pages\OrderProduct;


use Source\Models\Model;

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
}