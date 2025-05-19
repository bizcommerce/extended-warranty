<?php
/**
 * Plugin para adicionar informações de garantia estendida ao endpoint GET /V1/orders/{orderId}
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Plugin\Order;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use BizCommerce\ExtendedWarranty\Api\Data\OrderItemWarrantyInterfaceFactory;
use BizCommerce\ExtendedWarranty\Helper\Data;

class OrderGet
{
    /**
     * @var OrderItemWarrantyInterfaceFactory
     */
    protected $orderItemWarrantyFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Construtor
     *
     * @param OrderItemWarrantyInterfaceFactory $orderItemWarrantyFactory
     * @param Data $helper
     */
    public function __construct(
        OrderItemWarrantyInterfaceFactory $orderItemWarrantyFactory,
        Data $helper
    ) {
        $this->orderItemWarrantyFactory = $orderItemWarrantyFactory;
        $this->helper = $helper;
    }

    /**
     * Plugin para o método get do OrderRepository
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $order
    ) {
        // Verifica se o módulo está habilitado
        if (!$this->helper->isEnabled()) {
            return $order;
        }

        $this->processOrderItems($order->getItems());
        
        return $order;
    }

    /**
     * Plugin para o método getList do OrderRepository
     *
     * @param OrderRepositoryInterface $subject
     * @param \Magento\Sales\Api\Data\OrderSearchResultInterface $searchResult
     * @return \Magento\Sales\Api\Data\OrderSearchResultInterface
     */
    public function afterGetList(
        OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderSearchResultInterface $searchResult
    ) {
        // Verifica se o módulo está habilitado
        if (!$this->helper->isEnabled()) {
            return $searchResult;
        }

        $orders = $searchResult->getItems();
        
        foreach ($orders as $order) {
            $this->processOrderItems($order->getItems());
        }
        
        return $searchResult;
    }

    /**
     * Processa os itens do pedido para adicionar informações de garantia estendida
     *
     * @param OrderItemInterface[] $orderItems
     * @return void
     */
    private function processOrderItems($orderItems)
    {
        if (!$orderItems) {
            return;
        }
        
        foreach ($orderItems as $item) {
            $productOptions = $item->getProductOptions();
            
            if (isset($productOptions['extended_warranty'])) {
                $warrantyData = $productOptions['extended_warranty'];
                
                $warranty = $this->orderItemWarrantyFactory->create();
                $warranty->setWarrantyName($warrantyData['warranty_name']);
                $warranty->setWarrantyValue($warrantyData['warranty_value']);
                $warranty->setWarrantyTime($warrantyData['warranty_time']);
                
                $extensionAttributes = $item->getExtensionAttributes();
                if ($extensionAttributes) {
                    $extensionAttributes->setExtendedWarranty($warranty);
                    $item->setExtensionAttributes($extensionAttributes);
                }
            }
        }
    }
}
