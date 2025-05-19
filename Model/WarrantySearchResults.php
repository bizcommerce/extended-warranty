<?php
/**
 * Factory para os resultados de pesquisa de garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model;

use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterfaceFactory;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterface;

class WarrantySearchResults implements WarrantySearchResultsInterface
{
    /**
     * @var SearchResultsInterface
     */
    private $searchResults;

    /**
     * Construtor
     *
     * @param SearchResultsInterface $searchResults
     */
    public function __construct(
        SearchResultsInterface $searchResults
    ) {
        $this->searchResults = $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->searchResults->getItems();
    }

    /**
     * {@inheritdoc}
     */
    public function setItems(array $items)
    {
        return $this->searchResults->setItems($items);
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchCriteria()
    {
        return $this->searchResults->getSearchCriteria();
    }

    /**
     * {@inheritdoc}
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        return $this->searchResults->setSearchCriteria($searchCriteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalCount()
    {
        return $this->searchResults->getTotalCount();
    }

    /**
     * {@inheritdoc}
     */
    public function setTotalCount($totalCount)
    {
        return $this->searchResults->setTotalCount($totalCount);
    }
}
