<?php
/**
 * Controlador para salvar garantias estendidas no admin
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Adminhtml\Warranty;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use BizCommerce\ExtendedWarranty\Model\WarrantyFactory;
use BizCommerce\ExtendedWarranty\Api\WarrantyRepositoryInterface;

class Save extends Action
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Magento_Catalog::products';

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
     * @param WarrantyFactory $warrantyFactory
     * @param WarrantyRepositoryInterface $warrantyRepository
     */
    public function __construct(
        Context $context,
        WarrantyFactory $warrantyFactory,
        WarrantyRepositoryInterface $warrantyRepository
    ) {
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
        $data = $this->getRequest()->getPostValue();
        $productId = $this->getRequest()->getParam('product_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($data) {
            $warrantyId = $this->getRequest()->getParam('warranty_id');
            
            if ($warrantyId) {
                try {
                    $warranty = $this->warrantyRepository->getById($warrantyId);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('Esta garantia não existe mais.'));
                    return $resultRedirect->setPath(
                        'catalog/product/edit',
                        ['id' => $productId, 'active_tab' => 'extended_warranty_section']
                    );
                }
            } else {
                $warranty = $this->warrantyFactory->create();
            }
            
            try {
                $warranty->setData($data);
                $this->warrantyRepository->save($warranty);
                $this->messageManager->addSuccessMessage(__('Garantia estendida salva com sucesso.'));
                
                return $resultRedirect->setPath(
                    'catalog/product/edit',
                    ['id' => $productId, 'active_tab' => 'extended_warranty_section']
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                
                return $resultRedirect->setPath(
                    'extendedwarranty/warranty/edit',
                    ['warranty_id' => $warrantyId, 'product_id' => $productId]
                );
            }
        }
        
        return $resultRedirect->setPath(
            'catalog/product/edit',
            ['id' => $productId, 'active_tab' => 'extended_warranty_section']
        );
    }
}
