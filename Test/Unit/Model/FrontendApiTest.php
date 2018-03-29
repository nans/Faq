<?php

namespace Nans\Faq\Test\Unit\Model;

use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use PHPUnit\Framework\TestCase;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Model\FrontendApi;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;
use Nans\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;

class FrontendApiTest extends TestCase
{
    /** @var  FrontendApi */
    private $frontendApi;

    /** @var ObjectManagerInterface */
    private $objectManagerMock;

    /** @var  QuestionRepositoryInterface */
    private $questionRepositoryMock;

    /** @var  array */
    private $categoriesArray;

    /** @var  array */
    private $questionsArray;

    private $questionId = 1;
    private $storeId = 1;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $startUseful = 1;
        $updatedUseful = 2;
        $categoryRecord = $this->getMockBuilder(CategoryInterface::class)->disableOriginalConstructor()->getMock();
        $questionRecord = $this->getMockBuilder(QuestionInterface::class)->disableOriginalConstructor()->getMock();
        $questionRecord->expects($this->any())->method('getUseful')->willReturn($startUseful);
        $questionRecord->expects($this->any())->method('setUseful')->with($updatedUseful);

        $questionRecord->expects($this->any())->method('getUseless')->willReturn($startUseful);
        $questionRecord->expects($this->any())->method('setUseless')->with($updatedUseful);

        $this->categoriesArray = [$categoryRecord];
        $this->questionsArray = [$questionRecord];

        $questionCollection = $this->getMockBuilder(QuestionCollection::class)->setMethods([
            'getDataByStoreId',
            'getData'
        ])->disableOriginalConstructor()
            ->getMock();

        $questionCollection
            ->expects($this->any())
            ->method('getDataByStoreId')
            ->with($this->storeId)
            ->willReturn($questionCollection);

        $questionCollection
            ->expects($this->any())
            ->method('getData')
            ->willReturn($this->questionsArray);


        $categoryCollection = $this->getMockBuilder(CategoryCollection::class)->setMethods([
            'getDataByStoreId',
            'getData'
        ])->disableOriginalConstructor()
            ->getMock();
        $categoryCollection->expects($this->any())->method('getDataByStoreId')->with($this->storeId)->willReturn($categoryCollection);
        $categoryCollection->expects($this->any())->method('getData')->willReturn($this->categoriesArray);

        $objectManagerCreateMap = [
            [QuestionCollection::class, [], $questionCollection],
            [CategoryCollection::class, [], $categoryCollection]
        ];

        $this->objectManagerMock = $this->getMockBuilder(ObjectManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectManagerMock->expects($this->any())->method('create')->will($this->returnValueMap($objectManagerCreateMap));

        $this->questionRepositoryMock = $this->getMockBuilder(QuestionRepositoryInterface::class)->setMethods([
            'getById',
            'save'
        ])->getMockForAbstractClass();
        $this->questionRepositoryMock->expects($this->any())->method('getById')->with($this->questionId)->willReturn($questionRecord);
        $this->questionRepositoryMock->expects($this->any())->method('save')->willReturn($questionRecord);


        $this->frontendApi = $objectManager->getObject(FrontendApi::class,
            ['_questionRepository' => $this->questionRepositoryMock, '_objectManager' => $this->objectManagerMock]);
    }

    public function testGetQuestions()
    {
        $this->assertEquals($this->questionsArray, $this->frontendApi->getQuestions($this->storeId));
    }

    public function testGetCategories()
    {
        $this->assertEquals($this->categoriesArray, $this->frontendApi->getCategories($this->storeId));
    }

    public function testChangeUseful()
    {
        $this->assertTrue($this->frontendApi->changeUseful($this->questionId, 1));
    }

    public function testChangeUseless()
    {
        $this->assertTrue($this->frontendApi->changeUseless($this->questionId, 1));
    }
}