<?php
/**
 * Modelo para a entidade de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model;

use Magento\Framework\Model\AbstractModel;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty as WarrantyResource;

class Warranty extends AbstractModel implements WarrantyInterface
{
    /**
     * Inicialização do modelo
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(WarrantyResource::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getWarrantyId()
    {
        return $this->getData(self::WARRANTY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setWarrantyId($warrantyId)
    {
        return $this->setData(self::WARRANTY_ID, $warrantyId);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * {@inheritdoc}
     */
    public function getWarrantyName()
    {
        return $this->getData(self::WARRANTY_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setWarrantyName($warrantyName)
    {
        return $this->setData(self::WARRANTY_NAME, $warrantyName);
    }

    /**
     * {@inheritdoc}
     */
    public function getCalculationType()
    {
        return $this->getData(self::CALCULATION_TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function setCalculationType($calculationType)
    {
        return $this->setData(self::CALCULATION_TYPE, $calculationType);
    }

    /**
     * {@inheritdoc}
     */
    public function getWarrantyValue()
    {
        return $this->getData(self::WARRANTY_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setWarrantyValue($warrantyValue)
    {
        return $this->setData(self::WARRANTY_VALUE, $warrantyValue);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
