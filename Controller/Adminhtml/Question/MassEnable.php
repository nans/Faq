<?php

namespace Nans\Faq\Controller\Adminhtml\Question;

use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Controller\Adminhtml\AbstractMassEnable;
use Nans\Faq\Helper\AclNames;
use Nans\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;

class MassEnable extends AbstractMassEnable
{
    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return AclNames::ACL_QUESTION_SAVE;
    }

    /**
     * @return string
     */
    protected function _getCollectionClass(): string
    {
        return QuestionCollection::class;
    }

    /**
     * @return string
     */
    protected function _getRepositoryClass(): string
    {
        return QuestionRepositoryInterface::class;
    }
}