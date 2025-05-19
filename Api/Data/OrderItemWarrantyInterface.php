<?php
/**
 * Interface para os dados de garantia estendida no item do pedido
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Api\Data;

interface OrderItemWarrantyInterface
{
    /**#@+
     * Constantes para nomes de campos
     */
    const WARRANTY_NAME = 'warranty_name';
    const WARRANTY_VALUE = 'warranty_value';
    const WARRANTY_TIME = 'warranty_time';
    /**#@-*/

    /**
     * Obtém o nome da garantia
     *
     * @return string
     */
    public function getWarrantyName();

    /**
     * Define o nome da garantia
     *
     * @param string $warrantyName
     * @return $this
     */
    public function setWarrantyName($warrantyName);

    /**
     * Obtém o valor da garantia
     *
     * @return float
     */
    public function getWarrantyValue();

    /**
     * Define o valor da garantia
     *
     * @param float $warrantyValue
     * @return $this
     */
    public function setWarrantyValue($warrantyValue);

    /**
     * Obtém o tempo de garantia
     *
     * @return string
     */
    public function getWarrantyTime();

    /**
     * Define o tempo de garantia
     *
     * @param string $warrantyTime
     * @return $this
     */
    public function setWarrantyTime($warrantyTime);
}
