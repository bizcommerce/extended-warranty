<?php
/**
 * Teste de integração para o módulo de garantia estendida
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Test\Integration;

use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use BizCommerce\ExtendedWarranty\Helper\Data;
use BizCommerce\ExtendedWarranty\Model\WarrantyRepository;
use BizCommerce\ExtendedWarranty\Model\WarrantyFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class WarrantyIntegrationTest extends TestCase
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var WarrantyRepository
     */
    protected $warrantyRepository;

    /**
     * @var WarrantyFactory
     */
    protected $warrantyFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Setup
     */
    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->helper = $objectManager->get(Data::class);
        $this->warrantyRepository = $objectManager->get(WarrantyRepository::class);
        $this->warrantyFactory = $objectManager->get(WarrantyFactory::class);
        $this->productRepository = $objectManager->get(ProductRepositoryInterface::class);
    }

    /**
     * Testa a criação e recuperação de uma garantia estendida
     */
    public function testCreateAndGetWarranty()
    {
        // Cria uma nova garantia
        $warranty = $this->warrantyFactory->create();
        $warranty->setProductId(1); // Assume que o produto com ID 1 existe
        $warranty->setWarrantyName('Garantia Teste');
        $warranty->setCalculationType('fixed');
        $warranty->setWarrantyValue(99.90);
        
        // Salva a garantia
        $savedWarranty = $this->warrantyRepository->save($warranty);
        
        // Verifica se a garantia foi salva com um ID
        $this->assertNotNull($savedWarranty->getWarrantyId());
        
        // Recupera a garantia pelo ID
        $loadedWarranty = $this->warrantyRepository->getById($savedWarranty->getWarrantyId());
        
        // Verifica se os dados estão corretos
        $this->assertEquals($warranty->getProductId(), $loadedWarranty->getProductId());
        $this->assertEquals($warranty->getWarrantyName(), $loadedWarranty->getWarrantyName());
        $this->assertEquals($warranty->getCalculationType(), $loadedWarranty->getCalculationType());
        $this->assertEquals($warranty->getWarrantyValue(), $loadedWarranty->getWarrantyValue());
        
        // Limpa os dados de teste
        $this->warrantyRepository->delete($loadedWarranty);
        
        // Verifica se a garantia foi excluída
        $this->expectException(NoSuchEntityException::class);
        $this->warrantyRepository->getById($savedWarranty->getWarrantyId());
    }

    /**
     * Testa a listagem de garantias por produto
     */
    public function testGetWarrantiesByProduct()
    {
        // Cria várias garantias para o mesmo produto
        $productId = 1; // Assume que o produto com ID 1 existe
        $warranties = [];
        
        for ($i = 1; $i <= 3; $i++) {
            $warranty = $this->warrantyFactory->create();
            $warranty->setProductId($productId);
            $warranty->setWarrantyName('Garantia Teste ' . $i);
            $warranty->setCalculationType($i % 2 == 0 ? 'fixed' : 'percent');
            $warranty->setWarrantyValue($i * 50);
            
            $warranties[] = $this->warrantyRepository->save($warranty);
        }
        
        // Recupera as garantias pelo ID do produto
        $loadedWarranties = $this->warrantyRepository->getListByProductId($productId);
        
        // Verifica se todas as garantias foram recuperadas
        $this->assertCount(3, $loadedWarranties->getItems());
        
        // Limpa os dados de teste
        foreach ($warranties as $warranty) {
            $this->warrantyRepository->delete($warranty);
        }
    }
}
