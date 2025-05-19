<?php
/**
 * Bloco para o formulário de edição de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Block\Adminhtml\Warranty\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use BizCommerce\ExtendedWarranty\Model\Config\Source\CalculationType;

class Form extends Generic
{
    /**
     * @var CalculationType
     */
    protected $calculationType;

    /**
     * Construtor
     *
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param CalculationType $calculationType
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        CalculationType $calculationType,
        array $data = []
    ) {
        $this->calculationType = $calculationType;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepara o formulário
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('warranty_data');
        $productId = $this->getRequest()->getParam('product_id');

        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post'
            ]]
        );

        $form->setHtmlIdPrefix('warranty_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Informações da Garantia Estendida')]
        );

        if ($model->getId()) {
            $fieldset->addField('warranty_id', 'hidden', ['name' => 'warranty_id']);
        }

        $fieldset->addField('product_id', 'hidden', [
            'name' => 'product_id',
            'value' => $productId
        ]);

        $fieldset->addField('warranty_name', 'text', [
            'name' => 'warranty_name',
            'label' => __('Nome da Garantia'),
            'title' => __('Nome da Garantia'),
            'required' => true
        ]);

        $fieldset->addField('calculation_type', 'select', [
            'name' => 'calculation_type',
            'label' => __('Tipo de Cálculo'),
            'title' => __('Tipo de Cálculo'),
            'required' => true,
            'values' => $this->calculationType->toOptionArray()
        ]);

        $fieldset->addField('warranty_value', 'text', [
            'name' => 'warranty_value',
            'label' => __('Valor da Garantia'),
            'title' => __('Valor da Garantia'),
            'required' => true,
            'class' => 'validate-number'
        ]);

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
