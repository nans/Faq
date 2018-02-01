<?php

namespace Nans\Faq\Controller\Adminhtml\Question;

use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Controller\Adminhtml\AbstractMassDelete;
use Nans\Faq\Helper\AclNames;
use Nans\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;

class MassDelete extends AbstractMassDelete
{
    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return AclNames::ACL_QUESTION_DELETE;
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