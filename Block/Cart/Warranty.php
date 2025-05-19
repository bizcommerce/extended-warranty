<?php
/**
 * Bloco para a tela de seleção de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Block\Cart;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;

class Warranty extends Template
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CollectionFactory
     */
    protected $warrantyCollectionFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var PricingHelper
     */
    protected $pricingHelper;

    /**
     * Construtor
     *
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $warrantyCollectionFactory
     * @param RequestInterface $request
     * @param PricingHelper $pricingHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        CollectionFactory $warrantyCollectionFactory,
        RequestInterface $request,
        PricingHelper $pricingHelper,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->warrantyCollectionFactory = $warrantyCollectionFactory;
        $this->request = $request;
        $this->pricingHelper = $pricingHelper;
        parent::__construct($context, $data);
    }

    /**
     * Obtém o produto atual
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct()
    {
        $productId = $this->request->getParam('product_id');
        try {
            return $this->productRepository->getById($productId);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Obtém o ID do item do carrinho
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->request->getParam('item_id');
    }

    /**
     * Obtém as opções de garantia para o produto atual
     *
     * @return \BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\Collection
     */
    public function getWarrantyOptions()
    {
        $productId = $this->request->getParam('product_id');
        return $this->warrantyCollectionFactory->create()
            ->addProductFilter($productId);
    }

    /**
     * Formata o preço
     *
     * @param float $price
     * @return string
     */
    public function formatPrice($price)
    {
        return $this->pricingHelper->currency($price, true, false);
    }

    /**
     * Calcula o valor da garantia
     *
     * @param \BizCommerce\ExtendedWarranty\Model\Warranty $warranty
     * @return float
     */
    public function calculateWarrantyValue($warranty)
    {
        $product = $this->getProduct();
        if (!$product) {
            return 0;
        }

        $productPrice = $product->getFinalPrice();
        
        if ($warranty->getCalculationType() == 'fixed') {
            return $warranty->getWarrantyValue();
        } else { // percentual
            return ($productPrice * $warranty->getWarrantyValue()) / 100;
        }
    }

    /**
     * Obtém a URL para adicionar garantia
     *
     * @return string
     */
    public function getAddWarrantyUrl()
    {
        return $this->getUrl('extendedwarranty/cart/addwarranty');
    }

    /**
     * Obtém a URL para continuar sem garantia
     *
     * @return string
     */
    public function getContinueWithoutWarrantyUrl()
    {
        return $this->getUrl('checkout/cart');
    }
}
