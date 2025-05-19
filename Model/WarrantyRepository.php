<?php
/**
 * Repositório para a entidade de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterface;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterfaceFactory;
use BizCommerce\ExtendedWarranty\Api\WarrantyRepositoryInterface;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty as WarrantyResource;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\CollectionFactory as WarrantyCollectionFactory;

class WarrantyRepository implements WarrantyRepositoryInterface
{
    /**
     * @var WarrantyResource
     */
    private $warrantyResource;

    /**
     * @var WarrantyFactory
     */
    private $warrantyFactory;

    /**
     * @var WarrantyCollectionFactory
     */
    private $warrantyCollectionFactory;

    /**
     * @var WarrantySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * Construtor
     *
     * @param WarrantyResource $warrantyResource
     * @param WarrantyFactory $warrantyFactory
     * @param WarrantyCollectionFactory $warrantyCollectionFactory
     * @param WarrantySearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        WarrantyResource $warrantyResource,
        WarrantyFactory $warrantyFactory,
        WarrantyCollectionFactory $warrantyCollectionFactory,
        WarrantySearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->warrantyResource = $warrantyResource;
        $this->warrantyFactory = $warrantyFactory;
        $this->warrantyCollectionFactory = $warrantyCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(WarrantyInterface $warranty)
    {
        try {
            $this->warrantyResource->save($warranty);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Não foi possível salvar a garantia estendida: %1',
                $exception->getMessage()
            ));
        }
        return $warranty;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($warrantyId)
    {
        $warranty = $this->warrantyFactory->create();
        $this->warrantyResource->load($warranty, $warrantyId);
        if (!$warranty->getId()) {
            throw new NoSuchEntityException(__('Garantia estendida com id "%1" não existe.', $warrantyId));
        }
        return $warranty;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->warrantyCollectionFactory->create();
        
        $this->collectionProcessor->process($searchCriteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getListByProductId($productId)
    {
        $collection = $this->warrantyCollectionFactory->create();
        $collection->addProductFilter($productId);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(WarrantyInterface $warranty)
    {
        try {
            $this->warrantyResource->delete($warranty);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Não foi possível excluir a garantia estendida: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($warrantyId)
    {
        return $this->delete($this->getById($warrantyId));
    }
}
