<?php
/**
 * Bloco para gerenciar garantias estendidas no formulário de produto
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Block\Adminhtml\Catalog\Product\Edit\Tab;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\CollectionFactory;
use BizCommerce\ExtendedWarranty\Model\Config\Source\CalculationType;

class Warranty extends Extended
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var CollectionFactory
     */
    protected $warrantyCollectionFactory;

    /**
     * @var CalculationType
     */
    protected $calculationType;

    /**
     * Construtor
     *
     * @param Context $context
     * @param Data $backendHelper
     * @param Registry $coreRegistry
     * @param CollectionFactory $warrantyCollectionFactory
     * @param CalculationType $calculationType
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        Registry $coreRegistry,
        CollectionFactory $warrantyCollectionFactory,
        CalculationType $calculationType,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->warrantyCollectionFactory = $warrantyCollectionFactory;
        $this->calculationType = $calculationType;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Inicialização do bloco
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('extended_warranty_grid');
        $this->setDefaultSort('warranty_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepara a collection
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->warrantyCollectionFactory->create();
        $productId = $this->getProductId();
        if ($productId) {
            $collection->addProductFilter($productId);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepara as colunas
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'warranty_id',
            [
                'header' => __('ID'),
                'index' => 'warranty_id',
                'type' => 'number',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'warranty_name',
            [
                'header' => __('Nome da Garantia'),
                'index' => 'warranty_name',
                'type' => 'text',
            ]
        );

        $this->addColumn(
            'calculation_type',
            [
                'header' => __('Tipo de Cálculo'),
                'index' => 'calculation_type',
                'type' => 'options',
                'options' => $this->calculationType->toArray(),
            ]
        );

        $this->addColumn(
            'warranty_value',
            [
                'header' => __('Valor da Garantia'),
                'index' => 'warranty_value',
                'type' => 'price',
                'currency_code' => $this->_storeManager->getStore()->getBaseCurrencyCode(),
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Ação'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Editar'),
                        'url' => [
                            'base' => 'extendedwarranty/warranty/edit',
                            'params' => ['product_id' => $this->getProductId()]
                        ],
                        'field' => 'warranty_id'
                    ],
                    [
                        'caption' => __('Excluir'),
                        'url' => [
                            'base' => 'extendedwarranty/warranty/delete',
                            'params' => ['product_id' => $this->getProductId()]
                        ],
                        'field' => 'warranty_id',
                        'confirm' => [
                            'title' => __('Excluir Garantia'),
                            'message' => __('Tem certeza que deseja excluir esta garantia?')
                        ]
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'warranty_id',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Obtém o ID do produto atual
     *
     * @return int|null
     */
    public function getProductId()
    {
        $product = $this->coreRegistry->registry('current_product');
        return $product ? $product->getId() : null;
    }

    /**
     * Obtém a URL para o grid
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('extendedwarranty/warranty/grid', ['product_id' => $this->getProductId()]);
    }

    /**
     * Obtém a URL para adicionar uma nova garantia
     *
     * @return string
     */
    public function getAddWarrantyUrl()
    {
        return $this->getUrl('extendedwarranty/warranty/new', ['product_id' => $this->getProductId()]);
    }
}
