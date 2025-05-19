<?php
/**
 * Implementação da fábrica de garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\Api;

use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterfaceFactory;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantyInterface;
use BizCommerce\ExtendedWarranty\Model\WarrantyFactory;

class WarrantyInterfaceFactory implements WarrantyInterfaceFactory
{
    /**
     * @var WarrantyFactory
     */
    private $warrantyFactory;

    /**
     * Construtor
     *
     * @param WarrantyFactory $warrantyFactory
     */
    public function __construct(
        WarrantyFactory $warrantyFactory
    ) {
        $this->warrantyFactory = $warrantyFactory;
    }

    /**
     * Cria uma nova instância de WarrantyInterface
     *
     * @return WarrantyInterface
     */
    public function create()
    {
        return $this->warrantyFactory->create();
    }
}
