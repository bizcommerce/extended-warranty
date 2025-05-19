<?php
/**
 * Teste unitário para o Helper\Data
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Test\Unit\Helper;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use BizCommerce\ExtendedWarranty\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class DataTest extends TestCase
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var ScopeConfigInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $scopeConfigMock;

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
        $this->scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->helper = $this->objectManager->getObject(
            Data::class,
            [
                'scopeConfig' => $this->scopeConfigMock
            ]
        );
    }

    /**
     * Testa o método isEnabled quando o módulo está habilitado
     */
    public function testIsEnabledReturnsTrue()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(
                'extended_warranty/general/enabled',
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn(1);

        $this->assertTrue($this->helper->isEnabled());
    }

    /**
     * Testa o método isEnabled quando o módulo está desabilitado
     */
    public function testIsEnabledReturnsFalse()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(
                'extended_warranty/general/enabled',
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn(0);

        $this->assertFalse($this->helper->isEnabled());
    }

    /**
     * Testa o método getCalculationType
     */
    public function testGetCalculationType()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(
                'extended_warranty/general/calculation_type',
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('fixed');

        $this->assertEquals('fixed', $this->helper->getCalculationType());
    }
}
