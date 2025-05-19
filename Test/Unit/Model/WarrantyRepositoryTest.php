<?php
/**
 * Teste unitário para o Model\WarrantyRepository
 *
 * @category  BizCommerce
 * @package   BizCommerce_ExtendedWarranty
 * @author    BizCommerce
 */
namespace BizCommerce\ExtendedWarranty\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use BizCommerce\ExtendedWarranty\Model\WarrantyRepository;
use BizCommerce\ExtendedWarranty\Model\Warranty;
use BizCommerce\ExtendedWarranty\Model\WarrantyFactory;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty as WarrantyResource;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\CollectionFactory;
use BizCommerce\ExtendedWarranty\Model\ResourceModel\Warranty\Collection;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterfaceFactory;
use BizCommerce\ExtendedWarranty\Api\Data\WarrantySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;

class WarrantyRepositoryTest extends TestCase
{
    /**
     * @var WarrantyRepository
     */
    protected $repository;

    /**
     * @var WarrantyFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $warrantyFactoryMock;

    /**
     * @var WarrantyResource|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $resourceMock;

    /**
     * @var Warranty|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $warrantyMock;

    /**
     * @var Collection|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collectionMock;

    /**
     * @var CollectionFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collectionFactoryMock;

    /**
     * @var WarrantySearchResultsInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $searchResultsMock;

    /**
     * @var WarrantySearchResultsInterfaceFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $searchResultsFactoryMock;

    /**
     * @var CollectionProcessorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collectionProcessorMock;

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
        
        $this->warrantyFactoryMock = $this->createMock(WarrantyFactory::class);
        $this->resourceMock = $this->createMock(WarrantyResource::class);
        $this->warrantyMock = $this->createMock(Warranty::class);
        $this->collectionMock = $this->createMock(Collection::class);
        $this->collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->searchResultsMock = $this->createMock(WarrantySearchResultsInterface::class);
        $this->searchResultsFactoryMock = $this->createMock(WarrantySearchResultsInterfaceFactory::class);
        $this->collectionProcessorMock = $this->createMock(CollectionProcessorInterface::class);

        $this->repository = $this->objectManager->getObject(
            WarrantyRepository::class,
            [
                'warrantyFactory' => $this->warrantyFactoryMock,
                'resource' => $this->resourceMock,
                'collectionFactory' => $this->collectionFactoryMock,
                'searchResultsFactory' => $this->searchResultsFactoryMock,
                'collectionProcessor' => $this->collectionProcessorMock
            ]
        );
    }

    /**
     * Testa o método save
     */
    public function testSave()
    {
        $this->resourceMock->expects($this->once())
            ->method('save')
            ->with($this->warrantyMock)
            ->willReturnSelf();

        $this->assertEquals($this->warrantyMock, $this->repository->save($this->warrantyMock));
    }

    /**
     * Testa o método save com exceção
     */
    public function testSaveWithException()
    {
        $this->expectException(CouldNotSaveException::class);

        $this->resourceMock->expects($this->once())
            ->method('save')
            ->with($this->warrantyMock)
            ->willThrowException(new \Exception());

        $this->repository->save($this->warrantyMock);
    }

    /**
     * Testa o método getById
     */
    public function testGetById()
    {
        $warrantyId = 1;

        $this->warrantyFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->warrantyMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($this->warrantyMock, $warrantyId)
            ->willReturnSelf();

        $this->warrantyMock->expects($this->once())
            ->method('getId')
            ->willReturn($warrantyId);

        $this->assertEquals($this->warrantyMock, $this->repository->getById($warrantyId));
    }

    /**
     * Testa o método getById com exceção
     */
    public function testGetByIdWithException()
    {
        $this->expectException(NoSuchEntityException::class);

        $warrantyId = 1;

        $this->warrantyFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->warrantyMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($this->warrantyMock, $warrantyId)
            ->willReturnSelf();

        $this->warrantyMock->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->repository->getById($warrantyId);
    }
}
