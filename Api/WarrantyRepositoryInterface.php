<?php
/**
 * Interface para o repositório de garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface;

interface WarrantyRepositoryInterface
{
    /**
     * Salva uma garantia estendida
     *
     * @param WarrantyInterface $warranty
     * @return WarrantyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(WarrantyInterface $warranty);

    /**
     * Recupera uma garantia estendida pelo ID
     *
     * @param int $warrantyId
     * @return WarrantyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($warrantyId);

    /**
     * Recupera garantias estendidas que correspondem a critérios de pesquisa especificados
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Recupera garantias estendidas para um produto específico
     *
     * @param int $productId
     * @return \BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListByProductId($productId);

    /**
     * Exclui uma garantia estendida
     *
     * @param WarrantyInterface $warranty
     * @return bool true em caso de sucesso
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(WarrantyInterface $warranty);

    /**
     * Exclui uma garantia estendida pelo ID
     *
     * @param int $warrantyId
     * @return bool true em caso de sucesso
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($warrantyId);
}
