<?php
/**
 * Controlador para criar novas garantias estendidas no admin
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Adminhtml\Warranty;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Magento_Catalog::products';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Construtor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Executa a ação
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Catalog::catalog_products');
        $resultPage->getConfig()->getTitle()->prepend(__('Nova Garantia Estendida'));
        
        return $resultPage;
    }
}
