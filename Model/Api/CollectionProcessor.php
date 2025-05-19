<?php
/**
 * Implementação do processador de coleção para garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Api;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;

class CollectionProcessor implements CollectionProcessorInterface
{
    /**
     * Aplica os critérios de pesquisa à coleção
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param AbstractDb $collection
     * @return void
     */
    public function process(SearchCriteriaInterface $searchCriteria, AbstractDb $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $this->addFilterGroupToCollection($filterGroup, $collection);
        }
        
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $this->addSortToCollection($sortOrder, $collection);
            }
        }
        
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }
    
    /**
     * Adiciona um grupo de filtros à coleção
     *
     * @param FilterGroup $filterGroup
     * @param AbstractDb $collection
     * @return void
     */
    private function addFilterGroupToCollection(FilterGroup $filterGroup, AbstractDb $collection)
    {
        $fields = [];
        $conditions = [];
        
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
    
    /**
     * Adiciona ordenação à coleção
     *
     * @param SortOrder $sortOrder
     * @param AbstractDb $collection
     * @return void
     */
    private function addSortToCollection(SortOrder $sortOrder, AbstractDb $collection)
    {
        $field = $sortOrder->getField();
        $collection->addOrder(
            $field,
            ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
        );
    }
}
