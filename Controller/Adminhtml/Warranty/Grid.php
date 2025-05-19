<?php
/**
 * Controlador para exibir o grid de garantias estendidas no admin
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Adminhtml\Warranty;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;

class Grid extends Action
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Magento_Catalog::products';

    /**
     * @var LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * Construtor
     *
     * @param Context $context
     * @param LayoutFactory $resultLayoutFactory
     */
    public function __construct(
        Context $context,
        LayoutFactory $resultLayoutFactory
    ) {
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    /**
     * Executa a ação
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
