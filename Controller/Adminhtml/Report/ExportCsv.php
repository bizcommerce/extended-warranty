<?php
/**
 * Controlador para exportar o relatório de garantias estendidas em CSV
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Report\CollectionFactory;
use Magento\Framework\Filesystem\DirectoryList;

class ExportCsv extends Action
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'BizCommerce_ExtendedWarranty::reports';

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Construtor
     *
     * @param Context $context
     * @param FileFactory $fileFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        FileFactory $fileFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->fileFactory = $fileFactory;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Executa a ação
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $fileName = 'warranty_report.csv';
        $collection = $this->collectionFactory->create();
        
        $content = $this->getCsvContent($collection);
        
        return $this->fileFactory->create(
            $fileName,
            $content,
            DirectoryList::VAR_DIR
        );
    }

    /**
     * Obtém o conteúdo CSV do relatório
     *
     * @param \BizCommerce\ExtendedWarranty\Model\ResourceModel\Report\Collection $collection
     * @return string
     */
    protected function getCsvContent($collection)
    {
        $content = [];
        
        // Cabeçalho
        $content[] = [
            __('Pedido #'),
            __('Data do Pedido'),
            __('Cliente'),
            __('Produto'),
            __('Garantia'),
            __('Valor da Garantia'),
            __('Status do Pedido')
        ];
        
        // Dados
        foreach ($collection as $item) {
            $content[] = [
                $item->getData('order_id'),
                $item->getData('created_at'),
                $item->getData('customer_name'),
                $item->getData('product_name'),
                $item->getData('warranty_name'),
                $item->getData('warranty_value'),
                $item->getData('status')
            ];
        }
        
        // Converte para CSV
        $csvContent = '';
        foreach ($content as $row) {
            $csvContent .= implode(',', array_map([$this, 'escapeCSV'], $row)) . "\n";
        }
        
        return $csvContent;
    }

    /**
     * Escapa valores para CSV
     *
     * @param string $value
     * @return string
     */
    protected function escapeCSV($value)
    {
        return '"' . str_replace('"', '""', $value) . '"';
    }
}
