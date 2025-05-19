<?php
/**
 * Implementação da fábrica de resultados de pesquisa para garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Api;

use Magento\Framework\Api\SearchResultsInterfaceFactory;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterfaceFactory;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterface;
use BizCommerce\ExtendedWarranty\Model\WarrantySearchResults;

class WarrantySearchResultsFactory implements WarrantySearchResultsInterfaceFactory
{
    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Construtor
     *
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Cria uma nova instância de WarrantySearchResultsInterface
     *
     * @return WarrantySearchResultsInterface
     */
    public function create()
    {
        $searchResults = $this->searchResultsFactory->create();
        return new WarrantySearchResults($searchResults);
    }
}
