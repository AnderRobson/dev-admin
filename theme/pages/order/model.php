<?php


namespace Theme\Pages\Order;


use Source\Models\Model;

class OrderModel extends Model
{
    /** @var int Status pendente */
    public const ORDER_STATUS = 1;

    public function __construct()
    {
        $this->setTable("orders");

        parent::__construct("orders", ["id_user", "status", "total", "sub_total", "freight", "address"]);
    }
}