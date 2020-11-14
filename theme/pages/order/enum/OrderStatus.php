<?php


namespace Theme\Pages\Order\Enum;


use MyCLabs\Enum\Enum;

/**
 * Enum OrderStatus
 *
 * @package Theme\Pages\Order\Enum
 *
 * @method static OrderStatus CANCELLED()
 * @method static OrderStatus PENDING()
 * @method static OrderStatus APPROVED()
 * @method static OrderStatus TRANSPORT()
 * @method static OrderStatus DELIVERED()
 *
 * @author Ander Robson <ander.robson@hotmail.com>
 */
class OrderStatus extends Enum
{
    /** @var int CANCELLED Pedido cancelado */
    private const CANCELLED = 0;

    /** @var int PENDING Pedido pendente */
    private const PENDING = 1;

    /** @var int APPROVED Pedido aprovado */
    private const APPROVED = 2;

    /** @var int TRANSPORT Pedido em transporte */
    private const TRANSPORT = 3;

    /** @var int DELIVERED Pedido entregue */
    private const DELIVERED = 4;

    /**
     * Responsavel por retornar o nome do status atual
     *
     * @return string
     */
    public function getName(): string
    {
        $names = [
            self::CANCELLED => 'Cancelado',
            self::PENDING => 'Pendente',
            self::APPROVED => 'Aprovado',
            self::TRANSPORT => 'Transporte',
            self::DELIVERED => 'Entregue',
        ];

        return $names[$this->getValue()];
    }
    public function getClass(): string
    {
        $names = [
            self::CANCELLED => 'danger',
            self::PENDING => 'secondary',
            self::APPROVED => 'primary',
            self::TRANSPORT => 'info',
            self::DELIVERED => 'success',
        ];

        return $names[$this->getValue()];
    }

    /**
     * Responsavel por retornar a mensagem do status atual
     *
     * @return string
     */
    public function getMessage(): string
    {
        $names = [
            self::CANCELLED => 'Seu Pedido encontra-se cancelado',
            self::PENDING => 'Seu Pedido encontra-se em pendente, aguarde at� a sua aprova��o',
            self::APPROVED => 'Seu Pedido encontra-se aprovado, aguarde at� a sua postagem/entrega',
            self::TRANSPORT => 'Seu Pedido encontra-se em transporte, aguarde at� a sua entrega',
            self::DELIVERED => 'Seu Pedido j� foi entregue',
        ];

        return $names[$this->getValue()];
    }

    /**
     * Responsavel por encontrar o OrderStatus atrav�s do seu valor
     *
     * @param int $value
     *
     * @return OrderStatus
     *
     * @throw BadMethodCallException
     */
    public static function searchForValue(int $value): OrderStatus
    {
        return static::{static::search($value)}();
    }
}
