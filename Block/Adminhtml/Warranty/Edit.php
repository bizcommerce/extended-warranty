<?php
/**
 * Bloco para o formulário de edição de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Block\Adminhtml\Warranty;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Construtor
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Inicialização do bloco
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'warranty_id';
        $this->_blockGroup = 'BizCommerce_ExtendedWarranty';
        $this->_controller = 'adminhtml_warranty';

        parent::_construct();

        $productId = $this->getRequest()->getParam('product_id');

        $this->buttonList->update('save', 'label', __('Salvar Garantia'));
        $this->buttonList->update(
            'back',
            'onclick',
            "setLocation('" . $this->getUrl('catalog/product/edit', ['id' => $productId, 'active_tab' => 'extended_warranty_section']) . "')"
        );

        $this->buttonList->remove('reset');
    }

    /**
     * Obtém o título da página
     *
     * @return string
     */
    public function getHeaderText()
    {
        $warrantyId = $this->coreRegistry->registry('warranty_data')->getId();
        if ($warrantyId) {
            return __('Editar Garantia Estendida');
        } else {
            return __('Nova Garantia Estendida');
        }
    }
}
