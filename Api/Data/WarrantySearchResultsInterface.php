<?php
/**
 * Interface para os resultados de pesquisa de garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface WarrantySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Obtém a lista de garantias estendidas
     *
     * @return \BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface[]
     */
    public function getItems();

    /**
     * Define a lista de garantias estendidas
     *
     * @param \BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
