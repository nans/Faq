<?php

namespace Nans\Faq\Controller\Adminhtml\Category;

use Nans\Faq\Api\Repository\CategoryRepositoryInterface;
use Nans\Faq\Helper\Constants;
use Nans\Faq\Controller\Adminhtml\AbstractDeleteAction;

class Delete extends AbstractDeleteAction
{
    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return Constants::ACL_CATEGORY_DELETE;
    }

    /**
     * @return string
     */
    protected function _getRepositoryClass(): string
    {
        return CategoryRepositoryInterface::class;
    }
}