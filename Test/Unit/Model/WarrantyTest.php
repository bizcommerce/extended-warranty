<?php
/**
 * Teste unitário para o Model\Warranty
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use BizCommerce\ExtendedWarranty\Model\Warranty;

class WarrantyTest extends TestCase
{
    /**
     * @var Warranty
     */
    protected $model;

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
        $this->model = $this->objectManager->getObject(Warranty::class);
    }

    /**
     * Testa os getters e setters do modelo
     */
    public function testGettersAndSetters()
    {
        // Testa o ID da garantia
        $warrantyId = 1;
        $this->model->setWarrantyId($warrantyId);
        $this->assertEquals($warrantyId, $this->model->getWarrantyId());
        
        // Testa o ID do produto
        $productId = 42;
        $this->model->setProductId($productId);
        $this->assertEquals($productId, $this->model->getProductId());
        
        // Testa o nome da garantia
        $warrantyName = 'Garantia Premium';
        $this->model->setWarrantyName($warrantyName);
        $this->assertEquals($warrantyName, $this->model->getWarrantyName());
        
        // Testa o tipo de cálculo
        $calculationType = 'fixed';
        $this->model->setCalculationType($calculationType);
        $this->assertEquals($calculationType, $this->model->getCalculationType());
        
        // Testa o valor da garantia
        $warrantyValue = 99.90;
        $this->model->setWarrantyValue($warrantyValue);
        $this->assertEquals($warrantyValue, $this->model->getWarrantyValue());
    }
}
