<?php

namespace Nans\Faq\Model;

use Exception;
use Nans\Faq\Api\FrontendInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;
use Nans\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;
use Nans\Faq\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Nans\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;

class FrontendApi implements FrontendInterface
{
    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var QuestionCollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @param QuestionRepositoryInterface $questionRepository
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param QuestionCollectionFactory $questionCollectionFactory
     */
    public function __construct(
        QuestionRepositoryInterface $questionRepository,
        CategoryCollectionFactory $categoryCollectionFactory,
        QuestionCollectionFactory $questionCollectionFactory
    ) {
        $this->questionRepository = $questionRepository;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
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
            $question = $this->questionRepository->getById($questionId);
            $question->setUseless($question->getUseless() + $delta);
            $this->questionRepository->save($question);

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
            $question = $this->questionRepository->getById($questionId);
            $question->setUseful($question->getUseful() + $delta);
            $this->questionRepository->save($question);

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
        return $this->_getQuestionCollection()->getDataByStoreId($storeId)->getData();
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function getCategories(int $storeId): array
    {
        return $this->_getCategoryCollection()->getDataByStoreId($storeId)->getData();
    }

    /**
     * @return CategoryCollection
     */
    private function _getCategoryCollection(): CategoryCollection
    {
        return $this->categoryCollectionFactory->create();
    }

    /**
     * @return QuestionCollection
     */
    private function _getQuestionCollection(): QuestionCollection
    {
        return $this->questionCollectionFactory->create();
    }
}