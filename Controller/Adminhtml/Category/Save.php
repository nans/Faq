<?php

namespace Nans\Faq\Controller\Adminhtml\Category;

use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Api\Repository\CategoryRepositoryInterface;
use Nans\Faq\Controller\Adminhtml\AbstractSaveAction;
use Nans\Faq\Helper\AclNames;

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
        return CategoryInterface::KEY_ID;
    }

    /**
     * @param array $data
     */
    protected function _prepareData(array &$data)
    {
        $data[CategoryInterface::KEY_STORE_IDS] = implode(',', $data[CategoryInterface::KEY_STORE_IDS]);
    }
}