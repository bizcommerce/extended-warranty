<?php
/**
 * Controlador para a tela de seleção de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Cart;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\CollectionFactory;
use BizCommerce\ExtendedWarranty\Helper\Data;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\RequestInterface;

class Warranty implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CollectionFactory
     */
    protected $warrantyCollectionFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Construtor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param RedirectFactory $resultRedirectFactory
     * @param CheckoutSession $checkoutSession
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $warrantyCollectionFactory
     * @param Data $helper
     * @param ManagerInterface $messageManager
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        RedirectFactory $resultRedirectFactory,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository,
        CollectionFactory $warrantyCollectionFactory,
        Data $helper,
        ManagerInterface $messageManager,
        RequestInterface $request
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->warrantyCollectionFactory = $warrantyCollectionFactory;
        $this->helper = $helper;
        $this->messageManager = $messageManager;
        $this->request = $request;
    }

    /**
     * Executa a ação
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // Verifica se o módulo está habilitado
        if (!$this->helper->isEnabled()) {
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }

        $productId = $this->request->getParam('product_id');
        $itemId = $this->request->getParam('item_id');

        if (!$productId || !$itemId) {
            $this->messageManager->addErrorMessage(__('Parâmetros inválidos.'));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }

        try {
            // Verifica se o produto existe e tem garantia estendida habilitada
            $product = $this->productRepository->getById($productId);
            $extendedWarrantyEnabled = $product->getData('extended_warranty_enabled');
            
            if (!$extendedWarrantyEnabled) {
                return $this->resultRedirectFactory->create()->setPath('checkout/cart');
            }

            // Verifica se existem opções de garantia para o produto
            $warrantyCollection = $this->warrantyCollectionFactory->create()
                ->addProductFilter($productId);
            
            if ($warrantyCollection->getSize() == 0) {
                $this->messageManager->addNoticeMessage(__('Não há opções de garantia estendida disponíveis para este produto.'));
                return $this->resultRedirectFactory->create()->setPath('checkout/cart');
            }

            // Exibe a página de seleção de garantia
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__('Selecionar Garantia Estendida'));
            
            return $resultPage;
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Produto não encontrado.'));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Ocorreu um erro ao processar a garantia estendida.'));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
    }
}
