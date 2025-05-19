<?php
/**
 * Interface para a entidade de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Api\Data;

interface WarrantyInterface
{
    /**#@+
     * Constantes para nomes de colunas
     */
    const WARRANTY_ID = 'warranty_id';
    const PRODUCT_ID = 'product_id';
    const WARRANTY_NAME = 'warranty_name';
    const CALCULATION_TYPE = 'calculation_type';
    const WARRANTY_VALUE = 'warranty_value';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**#@-*/

    /**
     * Obtém o ID da garantia
     *
     * @return int|null
     */
    public function getWarrantyId();

    /**
     * Define o ID da garantia
     *
     * @param int $warrantyId
     * @return $this
     */
    public function setWarrantyId($warrantyId);

    /**
     * Obtém o ID do produto
     *
     * @return int
     */
    public function getProductId();

    /**
     * Define o ID do produto
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId);

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
     * Obtém o tipo de cálculo
     *
     * @return string
     */
    public function getCalculationType();

    /**
     * Define o tipo de cálculo
     *
     * @param string $calculationType
     * @return $this
     */
    public function setCalculationType($calculationType);

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
     * Obtém a data de criação
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Define a data de criação
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Obtém a data de atualização
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Define a data de atualização
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
