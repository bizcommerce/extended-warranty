<?php
/**
 * Bloco para o relatório de garantias estendidas
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Block\Adminhtml\Report;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Grid\Container;

class Warranty extends Container
{
    /**
     * Construtor
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Inicialização do bloco
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_report_warranty';
        $this->_blockGroup = 'BizCommerce_ExtendedWarranty';
        $this->_headerText = __('Relatório de Garantias Estendidas');
        
        parent::_construct();
        
        $this->buttonList->remove('add');
        $this->addButton(
            'filter_form_submit',
            [
                'label' => __('Mostrar Relatório'),
                'onclick' => 'filterFormSubmit()',
                'class' => 'primary'
            ]
        );
        $this->addButton(
            'export_csv',
            [
                'label' => __('Exportar CSV'),
                'onclick' => 'setLocation(\'' . $this->getUrl('*/*/exportCsv') . '\')',
                'class' => 'secondary'
            ]
        );
    }

    /**
     * Obtém a URL para exportar o relatório em CSV
     *
     * @return string
     */
    public function getExportCsvUrl()
    {
        return $this->getUrl('*/*/exportCsv');
    }
}
