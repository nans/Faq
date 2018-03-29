<?php

namespace Nans\Faq\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\Faq\Model\Question;

class QuestionTest extends TestCase
{
    /** @var Question */
    protected $_questionModel;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->_questionModel = $objectManager->getObject(Question::class);
    }

    public function testGettersAndSetters()
    {
        $id = 1;
        $this->_questionModel->setId($id);
        $this->assertEquals($this->_questionModel->getId(), $id);

        $status = 2;
        $this->_questionModel->setStatus($status);
        $this->assertEquals($this->_questionModel->getStatus(), $status);

        $title = 'title';
        $this->_questionModel->setTitle($title);
        $this->assertEquals($this->_questionModel->getTitle(), $title);

        $storeIds = 5;
        $this->_questionModel->setStoreIds($storeIds);
        $this->assertEquals($this->_questionModel->getStoreIds(), $storeIds);

        $sortOrder = 10;
        $this->_questionModel->setSortOrder($sortOrder);
        $this->assertEquals($this->_questionModel->getSortOrder(), $sortOrder);

        $time = time();
        $this->_questionModel->setData(Question::KEY_UPDATE_TIME, $time);
        $this->assertEquals($this->_questionModel->getUpdateTime(), $time);

        $this->_questionModel->setData(Question::KEY_CREATION_TIME, $time);
        $this->assertEquals($this->_questionModel->getCreationTime(), $time);

        $content = 'content';
        $this->_questionModel->setContent($content);
        $this->assertEquals($this->_questionModel->getContent(), $content);

        $categoryId = 7;
        $this->_questionModel->setCategoryId($categoryId);
        $this->assertEquals($this->_questionModel->getCategoryId(), $categoryId);

        $usefulCount = 20;
        $this->_questionModel->setUseful($usefulCount);
        $this->assertEquals($this->_questionModel->getUseful(), $usefulCount);

        $uselessCount = 5;
        $this->_questionModel->setUseless($uselessCount);
        $this->assertEquals($this->_questionModel->getUseless(), $uselessCount);
    }

    public function testGetIdentities()
    {
        $id = 10;
        $this->_questionModel->setId($id);
        $this->assertEquals($this->_questionModel->getIdentities(), [Question::CACHE_TAG . '_' . $id]);
    }

    public function testActiveStatus()
    {
        $this->_questionModel->setStatus(Question::STATUS_ACTIVE);
        $this->assertTrue($this->_questionModel->isActive());
    }

    public function testActivate()
    {
        $this->_questionModel->activate();
        $this->assertEquals(Question::STATUS_ACTIVE, $this->_questionModel->getStatus());
    }

    public function testDeactivate()
    {
        $this->_questionModel->deactivate();
        $this->assertEquals(Question::STATUS_INACTIVE, $this->_questionModel->getStatus());
    }
}