<?php

namespace Nans\Faq\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Model\FrontendApi;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;
use Nans\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;
use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Nans\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;

class FrontendApiTest extends TestCase
{
    /** @var ObjectManager  */
    private $objectManager;

    const QUESTION_ID = 1;
    const STORE_ID = 1;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);
    }

    public function testGetQuestions()
    {
        $questionRecord = $this->getMockBuilder(QuestionInterface::class)->disableOriginalConstructor()->getMock();

        $questionsArray = [$questionRecord];

        $questionCollection = $this->getMockBuilder(QuestionCollection::class)->setMethods(['getDataByStoreId', 'getData'])->disableOriginalConstructor()->getMock();
        $questionCollection->expects($this->once())->method('getDataByStoreId')->with(self::STORE_ID)->willReturn($questionCollection);
        $questionCollection->expects($this->once())->method('getData')->willReturn($questionsArray);

        $questionCollectionFactory = $this->getMockBuilder(QuestionCollectionFactory::class)->setMethods(['create'])->getMockForAbstractClass();
        $questionCollectionFactory->expects($this->once())->method('create')->with(Array ())->willReturn($questionCollection);

        /** @var FrontendApi $frontendApi */
        $frontendApi = $this->objectManager->getObject(FrontendApi::class,
            [
                '_questionRepository' => $this->getMockBuilder(QuestionRepositoryInterface::class)->getMockForAbstractClass(),
                '_categoryCollectionFactory' => $this->getMockBuilder(CategoryCollectionFactory::class)->getMockForAbstractClass(),
                '_questionCollectionFactory' => $questionCollectionFactory
            ]);

        $this->assertEquals($questionsArray, $frontendApi->getQuestions(self::STORE_ID));
    }

    public function testGetCategories()
    {
        $categoryRecord = $this->getMockBuilder(CategoryInterface::class)->disableOriginalConstructor()->getMock();
        $categoriesArray = [$categoryRecord];

        $categoryCollection = $this->getMockBuilder(CategoryCollection::class)->setMethods([
            'getDataByStoreId',
            'getData'
        ])->disableOriginalConstructor()->getMock();

        $categoryCollection->expects($this->once())->method('getDataByStoreId')->with(self::STORE_ID)->willReturn($categoryCollection);
        $categoryCollection->expects($this->once())->method('getData')->willReturn($categoriesArray);

        $categoryCollectionFactory = $this->getMockBuilder(CategoryCollectionFactory::class)->setMethods(['create'])->getMockForAbstractClass();
        $categoryCollectionFactory->expects($this->once())->method('create')->with(Array ())->willReturn($categoryCollection);

        /** @var FrontendApi $frontendApi */
        $frontendApi = $this->objectManager->getObject(FrontendApi::class,
            [
                '_questionRepository' => $this->getMockBuilder(QuestionRepositoryInterface::class)->getMockForAbstractClass(),
                '_categoryCollectionFactory' => $categoryCollectionFactory,
                '_questionCollectionFactory' => $this->getMockBuilder(QuestionCollectionFactory::class)->getMockForAbstractClass()
            ]);

        $this->assertEquals($categoriesArray, $frontendApi->getCategories(self::STORE_ID));
    }

    public function testChangeUseful()
    {
        $startUseful = 1;
        $updatedUseful = 2;

        $questionRecord = $this->getMockBuilder(QuestionInterface::class)->disableOriginalConstructor()->getMock();
        $questionRecord->expects($this->once())->method('getUseful')->willReturn($startUseful);
        $questionRecord->expects($this->once())->method('setUseful')->with($updatedUseful);

        $questionRepositoryMock = $this->getMockBuilder(QuestionRepositoryInterface::class)->setMethods(['getById', 'save'])->getMockForAbstractClass();
        $questionRepositoryMock->expects($this->once())->method('getById')->with(self::QUESTION_ID)->willReturn($questionRecord);
        $questionRepositoryMock->expects($this->once())->method('save')->willReturn($questionRecord);

        /** @var FrontendApi $frontendApi */
        $frontendApi = $this->objectManager->getObject(FrontendApi::class,
            [
                '_questionRepository' => $questionRepositoryMock,
                '_categoryCollectionFactory' =>  $this->getMockBuilder(CategoryCollectionFactory::class)->getMockForAbstractClass(),
                '_questionCollectionFactory' => $this->getMockBuilder(QuestionCollectionFactory::class)->getMockForAbstractClass()
            ]);

        $this->assertTrue($frontendApi->changeUseful(self::QUESTION_ID, 1));
    }

    public function testChangeUseless()
    {
        $startUseless = 1;
        $updatedUseless = 2;

        $questionRecord = $this->getMockBuilder(QuestionInterface::class)->disableOriginalConstructor()->getMock();
        $questionRecord->expects($this->once())->method('getUseless')->willReturn($startUseless);
        $questionRecord->expects($this->once())->method('setUseless')->with($updatedUseless);

        $questionRepositoryMock = $this->getMockBuilder(QuestionRepositoryInterface::class)->setMethods(['getById', 'save'])->getMockForAbstractClass();
        $questionRepositoryMock->expects($this->once())->method('getById')->with(self::QUESTION_ID)->willReturn($questionRecord);
        $questionRepositoryMock->expects($this->once())->method('save')->willReturn($questionRecord);

        /** @var FrontendApi $frontendApi */
        $frontendApi = $this->objectManager->getObject(FrontendApi::class,
            [
                '_questionRepository' => $questionRepositoryMock,
                '_categoryCollectionFactory' => $this->getMockBuilder(CategoryCollectionFactory::class)->getMockForAbstractClass(),
                '_questionCollectionFactory' => $this->getMockBuilder(QuestionCollectionFactory::class)->getMockForAbstractClass()
            ]);

        $this->assertTrue($frontendApi->changeUseless(self::QUESTION_ID, 1));
    }
}