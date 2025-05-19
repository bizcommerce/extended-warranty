<?php
/**
 * Controlador para adicionar garantia estendida ao item do carrinho
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Cart;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartRepositoryInterface;
use BizCommerce\ExtendedWarranty\Model\WarrantyFactory;
use BizCommerce\ExtendedWarranty\Api\WarrantyRepositoryInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

class AddWarranty implements HttpPostActionInterface
{
    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var WarrantyFactory
     */
    protected $warrantyFactory;

    /**
     * @var WarrantyRepositoryInterface
     */
    protected $warrantyRepository;

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
     * @param RedirectFactory $resultRedirectFactory
     * @param CheckoutSession $checkoutSession
     * @param CartRepositoryInterface $quoteRepository
     * @param WarrantyFactory $warrantyFactory
     * @param WarrantyRepositoryInterface $warrantyRepository
     * @param ManagerInterface $messageManager
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        RedirectFactory $resultRedirectFactory,
        CheckoutSession $checkoutSession,
        CartRepositoryInterface $quoteRepository,
        WarrantyFactory $warrantyFactory,
        WarrantyRepositoryInterface $warrantyRepository,
        ManagerInterface $messageManager,
        RequestInterface $request
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
        $this->warrantyFactory = $warrantyFactory;
        $this->warrantyRepository = $warrantyRepository;
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
        $itemId = $this->request->getParam('item_id');
        $warrantyId = $this->request->getParam('warranty_id');
        
        if (!$itemId) {
            $this->messageManager->addErrorMessage(__('Item do carrinho não encontrado.'));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
        
        try {
            $quote = $this->checkoutSession->getQuote();
            $item = $quote->getItemById($itemId);
            
            if (!$item) {
                throw new NoSuchEntityException(__('Item do carrinho não encontrado.'));
            }
            
            // Se o usuário escolheu uma garantia
            if ($warrantyId) {
                $warranty = $this->warrantyRepository->getById($warrantyId);
                
                // Adiciona as informações da garantia ao item do carrinho
                $additionalOptions = [];
                $additionalOptions[] = [
                    'label' => __('Garantia Estendida'),
                    'value' => $warranty->getWarrantyName(),
                    'warranty_id' => $warranty->getWarrantyId(),
                    'warranty_value' => $warranty->getWarrantyValue(),
                    'calculation_type' => $warranty->getCalculationType()
                ];
                
                // Salva as opções adicionais no item
                $item->addOption([
                    'code' => 'additional_options',
                    'value' => json_encode($additionalOptions)
                ]);
                
                // Atualiza o preço do item se necessário
                if ($warranty->getCalculationType() == 'fixed') {
                    $newPrice = $item->getPrice() + $warranty->getWarrantyValue();
                    $item->setCustomPrice($newPrice);
                    $item->setOriginalCustomPrice($newPrice);
                } else { // percentual
                    $percentValue = $warranty->getWarrantyValue() / 100;
                    $additionalValue = $item->getPrice() * $percentValue;
                    $newPrice = $item->getPrice() + $additionalValue;
                    $item->setCustomPrice($newPrice);
                    $item->setOriginalCustomPrice($newPrice);
                }
                
                $this->messageManager->addSuccessMessage(__('Garantia estendida adicionada com sucesso.'));
            } else {
                $this->messageManager->addNoticeMessage(__('Nenhuma garantia estendida foi selecionada.'));
            }
            
            // Salva o carrinho
            $this->quoteRepository->save($quote);
            
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Ocorreu um erro ao adicionar a garantia estendida.'));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
    }
}
