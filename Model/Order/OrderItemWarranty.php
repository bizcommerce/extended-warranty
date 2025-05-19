<?php
/**
 * Implementação para os dados de garantia estendida no item do pedido
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Order;

use Magento\Framework\DataObject;
use BizCommerce\ExtendedWarranty\Api\Data\OrderItemWarrantyInterface;

class OrderItemWarranty extends DataObject implements OrderItemWarrantyInterface
{
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
    public function getWarrantyTime()
    {
        return $this->getData(self::WARRANTY_TIME);
    }

    /**
     * {@inheritdoc}
     */
    public function setWarrantyTime($warrantyTime)
    {
        return $this->setData(self::WARRANTY_TIME, $warrantyTime);
    }
}
