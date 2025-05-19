<?php
/**
 * Implementação do provedor de dados para garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Api;

use Magento\Framework\Api\DataObjectHelper;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterfaceFactory;

class WarrantyDataProvider
{
    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var WarrantyInterfaceFactory
     */
    private $warrantyFactory;

    /**
     * Construtor
     *
     * @param DataObjectHelper $dataObjectHelper
     * @param WarrantyInterfaceFactory $warrantyFactory
     */
    public function __construct(
        DataObjectHelper $dataObjectHelper,
        WarrantyInterfaceFactory $warrantyFactory
    ) {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->warrantyFactory = $warrantyFactory;
    }

    /**
     * Converte um array de dados em um objeto WarrantyInterface
     *
     * @param array $data
     * @return WarrantyInterface
     */
    public function populateWithArray(array $data)
    {
        $warranty = $this->warrantyFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $warranty,
            $data,
            WarrantyInterface::class
        );
        
        return $warranty;
    }
}
