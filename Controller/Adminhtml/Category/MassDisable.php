<?php

namespace Nans\Faq\Controller\Adminhtml\Category;


use Nans\Faq\Api\Repository\CategoryRepositoryInterface;
use Nans\Faq\Controller\Adminhtml\AbstractMassDisable;
use Nans\Faq\Helper\AclNames;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;

class MassDisable extends AbstractMassDisable
{
    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return AclNames::ACL_CATEGORY_SAVE;
    }

    /**
     * @return string
     */
    protected function _getCollectionClass(): string
    {
        return CategoryCollection::class;
    }

    /**
     * @return string
     */
    protected function _getRepositoryClass(): string
    {
        return CategoryRepositoryInterface::class;
    }
}