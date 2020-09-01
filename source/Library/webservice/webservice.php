<?php


namespace Source\Library\webservice;


use Source\Library\webservice\resources\Order;
use Theme\pages\address\AddressModel;
use Theme\pages\order\OrderModel;
use Theme\pages\orderProduct\OrderProductModel;
use Theme\Pages\Stock\StockModel;

class Webservice
{
    const RESPONSE = [
        '0' => [
            'httpCode' => '200',
            'message' => 'Requisição realizada com Sucesso'
        ],
        '1' => [
            'httpCode' => '400',
            'message' => 'Requisição Inválida'
        ],
        '2' => [
            'httpCode' => '400',
            'message' => 'Erro ao cadastrar o endereço de entrega.'
        ],
        '3' => [
            'httpCode' => '400',
            'message' => 'Erro ao cadastrar o pedido.'
        ],
        '4' => [
            'httpCode' => '400',
            'message' => 'Erro ao cadastrar os itens do pedido.'
        ]
    ];


    public function getPosts($data)
    {
        echo json_encode($data);
        return;
    }

    public function getPost($data)
    {
        echo json_encode($data);
        return;
    }

    public function createOrder($data)
    {
        try {
            $order = new Order($data);
            $order->validateRequest();
            $order->constructAddress((new AddressModel()));
            $order->constructOrder((new OrderModel()));
            $order->constructOrderProduct(
                (new OrderProductModel()),
                (new StockModel())
            );

            echo $order->toJson();
        } catch (\Exception $exception) {
            $this->finish($exception->getCode());
        }
    }

    private function finish($responseCode = 0)
    {
        echo json_encode([
            'code' => SELF::RESPONSE[$responseCode]['httpCode'],
            'message' => utf8_encode(SELF::RESPONSE[$responseCode]['message'])
        ]);

        die;
    }
}