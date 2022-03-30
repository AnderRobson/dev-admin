<?php


namespace Source\Library\webservice\resources;


use Exception;
use Source\Models\Model;

/**
 * Class Order
 * @package Source\Library\webservice\resources
 */
class Order
{
    /** @var int Requisição inválida */
    const INVALID_REQUEST = 1;

    /** @var int Requisição válida */
    const VALID_REQUEST = 0;

    /** @var int Status pendente */
    public const ORDER_STATUS = 1;

    /** @var array Dados da requisição a ser processada */
    private $request;

    /** @var Model Model de Endereço*/
    private $address;

    /** @var Model Model de Pedido*/
    private $order;

    /** @var array Models de Produtos do Pedido*/
    private $orderProduct;

    /**
     * Order constructor.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = is_array($request) ? $request : json_decode($request, true);
    }

    /**
     * Responsavel por validar os dados da requisição.
     *
     * @return Order
     *
     * @throws Exception
     */
    public function validateRequest(): Order
    {
        if (
            empty($this->request['user'])
            ||
            empty($this->request['cart']['product'])
            ||
            empty($this->request['cart']['freight'])
        ) {
            throw new Exception(
                'Requisição inválida.',
                self::INVALID_REQUEST
            );
        }

        return $this;
    }

    /**
     * Responsavel por cadastrar ou obter do banco o endereço de entrega do pedido.
     *
     * @param Model $model
     *
     * @return Order
     *
     * @throws Exception
     */
    public function constructAddress(Model $model): Order
    {
        $cart = $this->getRequest('cart');
        $freight = $cart['freight'];

        $address = $model->find(
            'zip_code = :zip_code AND number = :number',
            'zip_code=' . $freight["zip_code"] .
            '&number=' . $freight['number']
        )->fetch();


        if (! empty($address)) {
            $this->address = $address;
            return $this;
        } else {
            $model->street = $freight['street'];
            $model->number = $freight['number'];
            $model->district = $freight['district'];
            $model->city = $freight['city'];
            $model->zip_code = $freight['zip_code'];
            $model->id_state = $freight['state'];

            if ($model->save()) {
                $this->address = $model;
                return $this;
            }

            throw new Exception(
                'Erro ao cadastrar o endereço de entrega.',
                '2'
            );
        }
    }

    /**
     * Responsavel por cadastrar pedido.
     *
     * @param Model $model
     *
     * @return Order
     *
     * @throws Exception
     */
    public function constructOrder(Model $model): Order
    {
        $cart = $this->getRequest('cart');

        $model->id_user = $this->getRequest('user');
        $model->status = self::ORDER_STATUS;
        $model->total = $cart['order']['total'];
        $model->sub_total = $cart['order']['sub_total'];
        $model->freight = $cart['freight']['value'];
        $model->address = $this->address->id;

        if ($model->save()) {
            $this->order = $model;
            return $this;
        }

        throw new Exception(
            'Erro ao cadastrar o pedido.',
            '3'
        );
    }

    /**
     * Responsavel por cadastrar produtos do pedido.
     *
     * @param Model $model
     * @param Model $productModel
     *
     * @return Order
     *
     * @throws Exception
     */
    public function constructOrderProduct(Model $model, Model $productModel): Order
    {
        $cart = $this->getRequest('cart');

        foreach ($cart['product'] as $idProduct => $item) {
            $stock = $productModel->findById($idProduct);

            if (empty($stock)) {
                throw new Exception(
                    'Erro ao cadastrar os itens do pedido.',
                    '4'
                );
            }

            $model->id_order = $this->order->id;
            $model->id_product = $stock->id_product;
            $model->id_stock = $stock->id;
            $model->status = self::ORDER_STATUS;
            $model->value = number_format($stock->current_value, 2, '.', '');
            $model->old_value = number_format($stock->old_value, 2, '.', '');
            $model->quantity = $item['qtd'];

            if ($model->save()) {
                $this->orderProduct[] = $model;
            } else {
                throw new Exception(
                    'Erro ao cadastrar os itens do pedido.',
                    '4'
                );
            }

            $model = $model->reset();
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequest($name = null)
    {
        if (! empty($name)) {
            if (! empty($this->request[$name])) {
                return $this->request[$name];
            }

            return null;
        }

        return $this->request;
    }

    /**
     * @param mixed $request
     *
     * @return Order
     */
    public function setRequest($request): Order
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        $return = [
            'order' => [
                'id' => $this->order->id,
                'id_user' => $this->order->id_user,
                'status' => $this->order->status,
                'address' => [
                    'id' => $this->address->id,
                    'street' => $this->address->street,
                    'number' => $this->address->number,
                    'district' => $this->address->district,
                    'city' => $this->address->city,
                    'zip_code' => $this->address->zip_code,
                    'id_state' => $this->address->number,
                ],
                'products' => []
            ]
        ];

        foreach ($this->orderProduct as $item) {
            $return['order']['products'][] = [
                'id' => $item->id,
                'id_product' => $item->id_product,
                'id_stock' => $item->id_stock,
                'status' => $item->status,
                'value' => $item->value,
                'old_value' => $item->old_value,
                'quantity' => $item->quantity
            ];
        }

        return json_encode($return);
    }
}
