<?php

namespace Nans\Faq\Test\Unit\Model\Repository;

use Exception;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\Faq\Model\Category;
use Nans\Faq\Model\ResourceModel\Category as CategoryResource;
use Nans\Faq\Model\CategoryFactory;
use Nans\Faq\Model\Repository\CategoryRepository;
use Nans\Faq\Api\Data\CategoryInterface;

class CategoryRepositoryTest extends TestCase
{
    /** @var CategoryResource|PHPUnit_Framework_MockObject_MockObject */
    private $_resource;

    /** @var CategoryFactory|PHPUnit_Framework_MockObject_MockObject */
    private $_factory;

    /** @var CategoryRepository|PHPUnit_Framework_MockObject_MockObject */
    private $_categoryRepository;

    protected function setUp()
    {
        $this->_resource = $this->getMockBuilder(CategoryResource::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->_factory = $this->getMockBuilder(CategoryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $objectManager = new ObjectManager($this);
        $this->_categoryRepository = $objectManager->getObject(CategoryRepository::class,
            [
                '_resource' => $this->_resource,
                '_factory' => $this->_factory
            ]
        );
    }

    public function testSave()
    {
        $category = $this->_getCategoryMock();
        $this->_resource->expects($this->once())
            ->method('save')
            ->with($category)
            ->willReturnSelf();
        $this->assertEquals($category, $this->_categoryRepository->save($category));
    }

    public function testCreate()
    {
        $category = $this->_getCategoryMock();
        $this->_factory->expects($this->once())->method('create')->willReturn($category);

        $this->assertEquals($category, $this->_categoryRepository->create());
    }

    public function testGetById()
    {
        $id = 5;
        $category = $this->_getCategoryMock();
        $category->expects($this->once())->method('getId')->willReturn($id);

        $this->_factory->expects($this->once())->method('create')->willReturn($category);
        $this->_resource->expects($this->once())->method('load')->with($category, $id)->willReturnSelf();
        $this->assertEquals($category, $this->_categoryRepository->getById($id));
    }

    public function testDelete()
    {
        $id = 7;
        /** @var CategoryInterface|PHPUnit_Framework_MockObject_MockObject $category */
        $category = $this->_getCategoryMock();
        $category->expects($this->once())->method('getId')->willReturn($id);
        $this->_categoryRepository->delete($category);
    }

    public function testGetByIdThrowException()
    {
        $this->expectException(Exception::class);

        $category = $this->_getCategoryMock();
        $category->expects($this->once())->method('getId')->willReturn(false);

        $id = 5;
        $this->_factory->expects($this->once())->method('create')->willReturn($category);
        $this->_resource->expects($this->once())->method('load')->with($category, $id)->willReturn($category);
        $this->_categoryRepository->getById($id);
    }

    private function _getCategoryMock()
    {
        return $this->getMockBuilder(Category::class)->disableOriginalConstructor()->getMock();
    }
}