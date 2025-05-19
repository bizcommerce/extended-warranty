<?php
/**
 * Observer para adicionar a tela de seleção de garantia após adicionar ao carrinho
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\UrlInterface;
use BizCommerce\ExtendedWarranty\Helper\Data;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class AddToCartObserver implements ObserverInterface
{
    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Construtor
     *
     * @param RedirectInterface $redirect
     * @param UrlInterface $url
     * @param Data $helper
     * @param ProductRepositoryInterface $productRepository
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        RedirectInterface $redirect,
        UrlInterface $url,
        Data $helper,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager
    ) {
        $this->redirect = $redirect;
        $this->url = $url;
        $this->helper = $helper;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
    }

    /**
     * Executa o observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // Verifica se o módulo está habilitado
        if (!$this->helper->isEnabled()) {
            return;
        }

        $request = $observer->getEvent()->getRequest();
        $response = $observer->getEvent()->getResponse();
        $productId = $request->getParam('product');
        $quoteItemId = null;

        // Obtém o item adicionado ao carrinho
        $quoteItem = $observer->getEvent()->getQuoteItem();
        if ($quoteItem) {
            $quoteItemId = $quoteItem->getId();
            $productId = $quoteItem->getProductId();
        }

        // Verifica se o produto tem garantia estendida habilitada
        try {
            $product = $this->productRepository->getById($productId);
            $extendedWarrantyEnabled = $product->getData('extended_warranty_enabled');
            
            if ($extendedWarrantyEnabled) {
                // Redireciona para a tela de seleção de garantia
                $url = $this->url->getUrl('extendedwarranty/cart/warranty', [
                    'product_id' => $productId,
                    'item_id' => $quoteItemId
                ]);
                
                $response->setRedirect($url);
                $response->sendResponse();
                exit;
            }
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Produto não encontrado.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Ocorreu um erro ao processar a garantia estendida.'));
        }
    }
}
