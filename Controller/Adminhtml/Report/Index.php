<?php
/**
 * Controlador para o relatório de garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'BizCommerce_ExtendedWarranty::reports';

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
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Executa a ação
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('BizCommerce_ExtendedWarranty::warranty_report');
        $resultPage->getConfig()->getTitle()->prepend(__('Relatório de Garantias Estendidas'));
        
        return $resultPage;
    }
}
