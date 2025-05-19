<?php
/**
 * Controlador para excluir garantias estendidas no admin
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Adminhtml\Warranty;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use BizCommerce\ExtendedWarranty\Api\WarrantyRepositoryInterface;

class Delete extends Action
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Magento_Catalog::products';

    /**
     * @var WarrantyRepositoryInterface
     */
    protected $warrantyRepository;

    /**
     * Construtor
     *
     * @param Context $context
     * @param WarrantyRepositoryInterface $warrantyRepository
     */
    public function __construct(
        Context $context,
        WarrantyRepositoryInterface $warrantyRepository
    ) {
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
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($warrantyId) {
            try {
                $this->warrantyRepository->deleteById($warrantyId);
                $this->messageManager->addSuccessMessage(__('Garantia estendida excluída com sucesso.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__('Não foi possível encontrar a garantia estendida para excluir.'));
        }
        
        return $resultRedirect->setPath(
            'catalog/product/edit',
            ['id' => $productId, 'active_tab' => 'extended_warranty_section']
        );
    }
}
