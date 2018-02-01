<?php

namespace Nans\Faq\Controller\Adminhtml\Category;

use Nans\Faq\Api\Repository\CategoryRepositoryInterface;
use Nans\Faq\Controller\Adminhtml\AbstractSaveAction;
use Nans\Faq\Helper\AclNames;
use Nans\Faq\Model\Category;

class Save extends AbstractSaveAction
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
    protected function _getRepositoryClass(): string
    {
        return CategoryRepositoryInterface::class;
    }

    /**
     * @return string
     */
    protected function _getIdFieldName(): string
    {
        return Category::ID;
    }

    /**
     * @param array $data
     */
    protected function _prepareData(array &$data)
    {
        $data[Category::STORE_IDS] = implode(',', $data[Category::STORE_IDS]);
    }
}