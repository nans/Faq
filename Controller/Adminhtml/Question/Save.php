<?php

namespace Nans\Faq\Controller\Adminhtml\Question;

use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Controller\Adminhtml\AbstractSaveAction;
use Nans\Faq\Helper\Constants;
use Nans\Faq\Model\Question;

class Save extends AbstractSaveAction
{
    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return Constants::ACL_QUESTION_SAVE;
    }

    /**
     * @return string
     */
    protected function _getRepositoryClass(): string
    {
        return QuestionRepositoryInterface::class;
    }

    /**
     * @return string
     */
    protected function _getIdFieldName(): string
    {
        return Question::ID;
    }

    /**
     * @param array $data
     */
    protected function _prepareData(array &$data)
    {
        $data[Question::STORE_IDS] = implode(',', $data[Question::STORE_IDS]);
    }
}