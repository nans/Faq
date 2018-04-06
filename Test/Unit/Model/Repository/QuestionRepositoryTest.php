<?php

namespace Nans\Faq\Test\Unit\Model\Repository;

use Exception;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\Faq\Model\Question;
use Nans\Faq\Model\ResourceModel\Question as QuestionResource;
use Nans\Faq\Model\QuestionFactory;
use Nans\Faq\Model\Repository\QuestionRepository;
use Nans\Faq\Api\Data\QuestionInterface;

class QuestionRepositoryTest extends TestCase
{
    /** @var QuestionResource|PHPUnit_Framework_MockObject_MockObject */
    private $_resource;

    /** @var QuestionFactory|PHPUnit_Framework_MockObject_MockObject */
    private $_factory;

    /** @var QuestionRepository|PHPUnit_Framework_MockObject_MockObject */
    private $_questionRepository;

    protected function setUp()
    {
        $this->_resource = $this->getMockBuilder(QuestionResource::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->_factory = $this->getMockBuilder(QuestionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $objectManager = new ObjectManager($this);
        $this->_questionRepository = $objectManager->getObject(QuestionRepository::class,
            [
                '_resource' => $this->_resource,
                '_factory' => $this->_factory
            ]
        );
    }

    public function testSave()
    {
        $question = $this->_getQuestionMock();
        $this->_resource->expects($this->once())
            ->method('save')
            ->with($question)
            ->willReturnSelf();
        $this->assertEquals($question, $this->_questionRepository->save($question));
    }

    public function testCreate()
    {
        $question = $this->_getQuestionMock();
        $this->_factory->expects($this->once())->method('create')->willReturn($question);

        $this->assertEquals($question, $this->_questionRepository->create());
    }

    public function testGetById()
    {
        $id = 5;
        $question = $this->_getQuestionMock();
        $question->expects($this->once())->method('getId')->willReturn($id);

        $this->_factory->expects($this->once())->method('create')->willReturn($question);
        $this->_resource->expects($this->once())->method('load')->with($question, $id)->willReturnSelf();
        $this->assertEquals($question, $this->_questionRepository->getById($id));
    }

    public function testDelete()
    {
        $id = 7;
        /** @var QuestionInterface|PHPUnit_Framework_MockObject_MockObject $question */
        $question = $this->_getQuestionMock();
        $question->expects($this->once())->method('getId')->willReturn($id);
        $this->_questionRepository->delete($question);
    }

    public function testGetByIdThrowException()
    {
        $this->expectException(Exception::class);

        $question = $this->_getQuestionMock();
        $question->expects($this->once())->method('getId')->willReturn(false);

        $id = 5;
        $this->_factory->expects($this->once())->method('create')->willReturn($question);
        $this->_resource->expects($this->once())->method('load')->with($question, $id)->willReturn($question);
        $this->_questionRepository->getById($id);
    }

    private function _getQuestionMock()
    {
        return $this->getMockBuilder(Question::class)->disableOriginalConstructor()->getMock();
    }
}