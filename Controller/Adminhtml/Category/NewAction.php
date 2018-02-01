<?php

namespace Nans\Faq\Controller\Adminhtml\Category;

use Nans\Faq\Helper\AclNames;
use Nans\Faq\Controller\Adminhtml\AbstractNewAction;

class NewAction extends AbstractNewAction
{
    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return AclNames::ACL_CATEGORY_SAVE;
    }
}
