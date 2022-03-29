<?php


namespace Theme\Pages\Order;


use Source\Models\Model;
use Theme\Pages\Address\AddressModel;
use Theme\Pages\Order\Enum\OrderStatus;
use Theme\Pages\OrderProduct\OrderProductModel;

class OrderModel extends Model
{
    /** @var int Status pendente */
    public const ORDER_STATUS = 1;

    public function __construct()
    {
        $this->setTable("orders");

        parent::__construct("orders", ["id_user", "status", "total", "sub_total", "freight", "address"]);
    }

    public function getStatus($option = null)
    {
        $orderStatus = OrderStatus::searchForValue($this->status);

        if (! empty($option)) {
            return $orderStatus->{$option}();
        }

        return $orderStatus;
    }

    public function getOrderProduct($fetch = false)
    {
        if (empty($this->orderProduct) || $fetch) {
            $this->orderProduct = (new OrderProductModel())
                ->find('id_order = :id_order', 'id_order=' . $this->id)
                ->fetch(true);
        }

        return $this->orderProduct;
    }

    public function getAddress()
    {
        if (empty($this->orderAddress)) {
            $this->orderAddress = (new AddressModel())->findById($this->address);
        }

        return $this->orderAddress;
    }
}