<?php

namespace Nans\Faq\Model;

use Exception;
use Magento\Framework\ObjectManagerInterface;
use Nans\Faq\Api\FrontendInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;
use Nans\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;

class FrontendApi implements FrontendInterface
{
    /**
     * @var QuestionRepositoryInterface
     */
    protected $_questionRepository;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param QuestionRepositoryInterface $questionRepository
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        QuestionRepositoryInterface $questionRepository,
        ObjectManagerInterface $objectManager
    ) {
        $this->_questionRepository = $questionRepository;
        $this->_objectManager = $objectManager;
    }

    /**
     * @param int $questionId
     * @param int $delta
     *
     * @return boolean
     */
    public function changeUseless(int $questionId, int $delta): bool
    {
        try {
            /** @var QuestionInterface $question */
            $question = $this->_questionRepository->getById($questionId);
            $question->setUseless($question->getUseless() + $delta);
            $this->_questionRepository->save($question);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $questionId
     * @param int $delta
     *
     * @return boolean
     */
    public function changeUseful(int $questionId, int $delta): bool
    {
        try {
            /** @var QuestionInterface $question */
            $question = $this->_questionRepository->getById($questionId);
            $question->setUseful($question->getUseful() + $delta);
            $this->_questionRepository->save($question);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function getQuestions(int $storeId): array
    {
        /** @var QuestionCollection $questionCollection */
        $questionCollection = $this->_objectManager->create(QuestionCollection::class);
        $questions = $questionCollection->getDataByStoreId($storeId)->getData();
        return $questions;
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function getCategories(int $storeId): array
    {
        /** @var CategoryCollection $categoryCollection */
        $categoryCollection = $this->_objectManager->create(CategoryCollection::class);
        $categories = $categoryCollection->getDataByStoreId($storeId)->getData();
        return $categories;
    }
}