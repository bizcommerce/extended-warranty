<?php
/**
 * Observer para salvar informações de garantia estendida no pedido
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\DB\TransactionFactory;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use BizCommerce\ExtendedWarranty\Helper\Data;

class SaveOrderObserver implements ObserverInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var TransactionFactory
     */
    protected $transactionFactory;

    /**
     * @var OrderItemRepositoryInterface
     */
    protected $orderItemRepository;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Construtor
     *
     * @param SerializerInterface $serializer
     * @param TransactionFactory $transactionFactory
     * @param OrderItemRepositoryInterface $orderItemRepository
     * @param Data $helper
     */
    public function __construct(
        SerializerInterface $serializer,
        TransactionFactory $transactionFactory,
        OrderItemRepositoryInterface $orderItemRepository,
        Data $helper
    ) {
        $this->serializer = $serializer;
        $this->transactionFactory = $transactionFactory;
        $this->orderItemRepository = $orderItemRepository;
        $this->helper = $helper;
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

        $order = $observer->getEvent()->getOrder();
        if (!$order) {
            return;
        }

        $transaction = $this->transactionFactory->create();

        foreach ($order->getAllItems() as $orderItem) {
            $quoteItem = $orderItem->getQuoteItem();
            if (!$quoteItem) {
                continue;
            }

            $additionalOptions = $quoteItem->getOptionByCode('additional_options');
            if (!$additionalOptions) {
                continue;
            }

            try {
                $options = $this->serializer->unserialize($additionalOptions->getValue());
                
                foreach ($options as $option) {
                    if (isset($option['warranty_id'])) {
                        // Adiciona as informações de garantia ao item do pedido
                        $extensionAttributes = $orderItem->getExtensionAttributes();
                        if ($extensionAttributes) {
                            $extensionAttributes->setExtendedWarranty([
                                'warranty_name' => $option['value'],
                                'warranty_value' => $option['warranty_value'],
                                'warranty_time' => $option['value'] // Usando o nome como tempo por enquanto
                            ]);
                            $orderItem->setExtensionAttributes($extensionAttributes);
                        }

                        // Adiciona as informações de garantia como opções do produto
                        $productOptions = $orderItem->getProductOptions();
                        if (!isset($productOptions['extended_warranty'])) {
                            $productOptions['extended_warranty'] = [
                                'warranty_name' => $option['value'],
                                'warranty_value' => $option['warranty_value'],
                                'warranty_time' => $option['value'] // Usando o nome como tempo por enquanto
                            ];
                            $orderItem->setProductOptions($productOptions);
                        }

                        $transaction->addObject($orderItem);
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        if ($transaction->getItems()) {
            try {
                $transaction->save();
            } catch (\Exception $e) {
                // Log do erro
            }
        }
    }
}
