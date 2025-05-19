<?php
/**
 * Implementação da API para garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use BizCommerce\ExtendedWarranty\Api\WarrantyRepositoryInterface;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface;
use BizCommerce\ExtendedWarranty\Model\WarrantyFactory;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\CollectionFactory;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;

class WarrantyRepository implements WarrantyRepositoryInterface
{
    /**
     * @var WarrantyFactory
     */
    private $warrantyFactory;

    /**
     * @var \BizCommerce\ExtendedWarranty\Model\WarrantyRepository
     */
    private $warrantyRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Construtor
     *
     * @param WarrantyFactory $warrantyFactory
     * @param \BizCommerce\ExtendedWarranty\Model\WarrantyRepository $warrantyRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        WarrantyFactory $warrantyFactory,
        \BizCommerce\ExtendedWarranty\Model\WarrantyRepository $warrantyRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->warrantyFactory = $warrantyFactory;
        $this->warrantyRepository = $warrantyRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function save(WarrantyInterface $warranty)
    {
        try {
            // Verifica se o produto existe
            $productId = $warranty->getProductId();
            $this->productRepository->getById($productId);
            
            return $this->warrantyRepository->save($warranty);
        } catch (NoSuchEntityException $e) {
            throw new CouldNotSaveException(__(
                'Não foi possível salvar a garantia estendida. O produto com ID %1 não existe.',
                $productId
            ));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__(
                'Não foi possível salvar a garantia estendida: %1',
                $e->getMessage()
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getById($warrantyId)
    {
        return $this->warrantyRepository->getById($warrantyId);
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        return $this->warrantyRepository->getList($searchCriteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getListByProductId($productId)
    {
        try {
            // Verifica se o produto existe
            $this->productRepository->getById($productId);
            
            return $this->warrantyRepository->getListByProductId($productId);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__(
                'O produto com ID %1 não existe.',
                $productId
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(WarrantyInterface $warranty)
    {
        try {
            return $this->warrantyRepository->delete($warranty);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__(
                'Não foi possível excluir a garantia estendida: %1',
                $e->getMessage()
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($warrantyId)
    {
        try {
            return $this->warrantyRepository->deleteById($warrantyId);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__(
                'A garantia estendida com ID %1 não existe.',
                $warrantyId
            ));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__(
                'Não foi possível excluir a garantia estendida: %1',
                $e->getMessage()
            ));
        }
    }
}
