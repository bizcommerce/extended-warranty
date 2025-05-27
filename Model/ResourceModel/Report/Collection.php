<?php
/**
 * Coleção para o relatório de garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Model\ResourceModel\Report;

use Magento\Sales\Model\ResourceModel\Order\Item\Collection as OrderItemCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot;

class Collection extends OrderItemCollection
{
    /**
     * Construtor
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param Snapshot $entitySnapshot
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        Snapshot $entitySnapshot,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $entitySnapshot,
            $connection,
            $resource
        );
    }

    /**
     * Inicialização da coleção
     *
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        
        $this->getSelect()
            ->join(
                ['order' => $this->getTable('sales_order')],
                'main_table.order_id = order.entity_id',
                [
                    'order_id' => 'order.increment_id',
                    'created_at' => 'order.created_at',
                    'status' => 'order.status'
                ]
            )
            ->where('main_table.product_options LIKE ?', '%extended_warranty%');
        
        $this->addFilterToMap('order_id', 'order.increment_id');
        $this->addFilterToMap('created_at', 'order.created_at');
        $this->addFilterToMap('status', 'order.status');
        
        $this->getSelect()->columns([
            'customer_name' => new \Zend_Db_Expr("CONCAT(order.customer_firstname, ' ', order.customer_lastname)"),
            'product_name' => 'main_table.name',
            'warranty_name' => new \Zend_Db_Expr("SUBSTRING_INDEX(SUBSTRING_INDEX(main_table.product_options, '\"warranty_name\";s:', -1), '\"', 2)"),
            'warranty_value' => new \Zend_Db_Expr("SUBSTRING_INDEX(SUBSTRING_INDEX(main_table.product_options, '\"warranty_value\";s:', -1), '\"', 2)")
        ]);
    }
}
