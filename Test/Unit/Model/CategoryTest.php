<?php

namespace Nans\Faq\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\Faq\Model\Category;

class CategoryTest extends TestCase
{
    /** @var Category */
    protected $_categoryModel;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->_categoryModel = $objectManager->getObject(Category::class);
    }

    public function testGettersAndSetters()
    {
        $id = 1;
        $this->_categoryModel->setId($id);
        $this->assertEquals($this->_categoryModel->getId(), $id);

        $status = 2;
        $this->_categoryModel->setStatus($status);
        $this->assertEquals($this->_categoryModel->getStatus(), $status);

        $title = 'title';
        $this->_categoryModel->setTitle($title);
        $this->assertEquals($this->_categoryModel->getTitle(), $title);

        $storeIds = 5;
        $this->_categoryModel->setStoreIds($storeIds);
        $this->assertEquals($this->_categoryModel->getStoreIds(), $storeIds);

        $sortOrder = 10;
        $this->_categoryModel->setSortOrder($sortOrder);
        $this->assertEquals($this->_categoryModel->getSortOrder(), $sortOrder);

        $time = time();
        $this->_categoryModel->setData(Category::KEY_UPDATE_TIME, $time);
        $this->assertEquals($this->_categoryModel->getUpdateTime(), $time);

        $this->_categoryModel->setData(Category::KEY_CREATION_TIME, $time);
        $this->assertEquals($this->_categoryModel->getCreationTime(), $time);
    }

    public function testGetIdentities()
    {
        $id = 10;
        $this->_categoryModel->setId($id);
        $this->assertEquals($this->_categoryModel->getIdentities(), [Category::CACHE_TAG . '_' . $id]);
    }

    public function testActiveStatus()
    {
        $this->_categoryModel->setStatus(Category::STATUS_ACTIVE);
        $this->assertTrue($this->_categoryModel->isActive());
    }

    public function testActivate()
    {
        $this->_categoryModel->activate();
        $this->assertEquals(Category::STATUS_ACTIVE, $this->_categoryModel->getStatus());
    }

    public function testDeactivate()
    {
        $this->_categoryModel->deactivate();
        $this->assertEquals(Category::STATUS_INACTIVE, $this->_categoryModel->getStatus());
    }
}