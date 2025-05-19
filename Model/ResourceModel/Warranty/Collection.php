<?php
/**
 * Collection para a entidade de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use BizCommerce\ExtendedWarranty\Model\Warranty;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty as WarrantyResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'warranty_id';

    /**
     * Inicialização da collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Warranty::class, WarrantyResource::class);
    }

    /**
     * Adiciona filtro por ID de produto
     *
     * @param int $productId
     * @return $this
     */
    public function addProductFilter($productId)
    {
        $this->addFieldToFilter('product_id', $productId);
        return $this;
    }
}
