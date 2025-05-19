<?php
/**
 * Teste unitário para o Observer\AddToCartObserver
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Test\Unit\Observer;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use BizCommerce\ExtendedWarranty\Observer\AddToCartObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\UrlInterface;
use BizCommerce\ExtendedWarranty\Helper\Data;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Event;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Catalog\Model\Product;

class AddToCartObserverTest extends TestCase
{
    /**
     * @var AddToCartObserver
     */
    protected $observer;

    /**
     * @var RedirectInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $redirectMock;

    /**
     * @var UrlInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $urlMock;

    /**
     * @var Data|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $helperMock;

    /**
     * @var ProductRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productRepositoryMock;

    /**
     * @var ManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $messageManagerMock;

    /**
     * @var Observer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $eventObserverMock;

    /**
     * @var Event|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $eventMock;

    /**
     * @var RequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $requestMock;

    /**
     * @var ResponseInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $responseMock;

    /**
     * @var QuoteItem|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteItemMock;

    /**
     * @var Product|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productMock;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Setup
     */
    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        
        $this->redirectMock = $this->createMock(RedirectInterface::class);
        $this->urlMock = $this->createMock(UrlInterface::class);
        $this->helperMock = $this->createMock(Data::class);
        $this->productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $this->messageManagerMock = $this->createMock(ManagerInterface::class);
        
        $this->eventObserverMock = $this->createMock(Observer::class);
        $this->eventMock = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRequest', 'getResponse', 'getQuoteItem'])
            ->getMock();
        
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
        $this->quoteItemMock = $this->createMock(QuoteItem::class);
        $this->productMock = $this->createMock(Product::class);

        $this->eventObserverMock->expects($this->any())
            ->method('getEvent')
            ->willReturn($this->eventMock);

        $this->observer = $this->objectManager->getObject(
            AddToCartObserver::class,
            [
                'redirect' => $this->redirectMock,
                'url' => $this->urlMock,
                'helper' => $this->helperMock,
                'productRepository' => $this->productRepositoryMock,
                'messageManager' => $this->messageManagerMock
            ]
        );
    }

    /**
     * Testa o método execute quando o módulo está desabilitado
     */
    public function testExecuteWhenModuleDisabled()
    {
        $this->helperMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(false);

        $this->eventMock->expects($this->never())
            ->method('getRequest');

        $this->observer->execute($this->eventObserverMock);
    }

    /**
     * Testa o método execute quando o produto tem garantia estendida habilitada
     */
    public function testExecuteWithExtendedWarrantyEnabled()
    {
        $productId = 42;
        $quoteItemId = 1;
        $redirectUrl = 'http://example.com/warranty';

        // Configura o helper para retornar que o módulo está habilitado
        $this->helperMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);

        // Configura o evento para retornar o request, response e quoteItem
        $this->eventMock->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestMock);
        
        $this->eventMock->expects($this->once())
            ->method('getResponse')
            ->willReturn($this->responseMock);
        
        $this->eventMock->expects($this->once())
            ->method('getQuoteItem')
            ->willReturn($this->quoteItemMock);

        // Configura o quoteItem para retornar o ID e o productId
        $this->quoteItemMock->expects($this->once())
            ->method('getId')
            ->willReturn($quoteItemId);
        
        $this->quoteItemMock->expects($this->once())
            ->method('getProductId')
            ->willReturn($productId);

        // Configura o productRepository para retornar o produto
        $this->productRepositoryMock->expects($this->once())
            ->method('getById')
            ->with($productId)
            ->willReturn($this->productMock);

        // Configura o produto para retornar que tem garantia estendida habilitada
        $this->productMock->expects($this->once())
            ->method('getData')
            ->with('extended_warranty_enabled')
            ->willReturn(true);

        // Configura a URL para o redirecionamento
        $this->urlMock->expects($this->once())
            ->method('getUrl')
            ->with('extendedwarranty/cart/warranty', [
                'product_id' => $productId,
                'item_id' => $quoteItemId
            ])
            ->willReturn($redirectUrl);

        // Configura o response para o redirecionamento
        $this->responseMock->expects($this->once())
            ->method('setRedirect')
            ->with($redirectUrl);
        
        $this->responseMock->expects($this->once())
            ->method('sendResponse');

        // Executa o observer
        $this->observer->execute($this->eventObserverMock);
    }
}
