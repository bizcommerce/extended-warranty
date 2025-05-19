<?php
/**
 * Controlador para gerenciar garantias estendidas no admin
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Adminhtml\Warranty;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use BizCommerce\ExtendedWarranty\Model\WarrantyFactory;
use BizCommerce\ExtendedWarranty\Api\WarrantyRepositoryInterface;

class Edit extends Action
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
     * @var WarrantyFactory
     */
    protected $warrantyFactory;

    /**
     * @var WarrantyRepositoryInterface
     */
    protected $warrantyRepository;

    /**
     * Construtor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param WarrantyFactory $warrantyFactory
     * @param WarrantyRepositoryInterface $warrantyRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        WarrantyFactory $warrantyFactory,
        WarrantyRepositoryInterface $warrantyRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->warrantyFactory = $warrantyFactory;
        $this->warrantyRepository = $warrantyRepository;
        parent::__construct($context);
    }

    /**
     * Executa a ação
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $warrantyId = $this->getRequest()->getParam('warranty_id');
        $productId = $this->getRequest()->getParam('product_id');
        
        $warranty = $this->warrantyFactory->create();
        
        if ($warrantyId) {
            try {
                $warranty = $this->warrantyRepository->getById($warrantyId);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Esta garantia não existe mais.'));
                return $this->resultRedirectFactory->create()->setPath(
                    'catalog/product/edit',
                    ['id' => $productId, 'active_tab' => 'extended_warranty_section']
                );
            }
        } else {
            $warranty->setProductId($productId);
        }
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Catalog::catalog_products');
        $title = $warrantyId ? __('Editar Garantia Estendida') : __('Nova Garantia Estendida');
        $resultPage->getConfig()->getTitle()->prepend($title);
        
        return $resultPage;
    }
}
