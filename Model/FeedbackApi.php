<?php

namespace Nans\Faq\Model;

use Exception;
use Nans\Faq\Api\Data\FeedbackInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Api\Repository\QuestionRepositoryInterface;

class FeedbackApi implements FeedbackInterface
{
    /**
     * @var QuestionRepositoryInterface
     */
    protected $_questionRepository;

    protected function _construct(
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->_questionRepository = $questionRepository;
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
}