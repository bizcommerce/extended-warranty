<?php
/**
 * Resource Model para a entidade de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Warranty extends AbstractDb
{
    /**
     * Inicialização do resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('bizcommerce_extended_warranty', 'warranty_id');
    }
}
