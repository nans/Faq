<?php

namespace Nans\Faq\Controller\Adminhtml\Question;

use Nans\Faq\Helper\Constants;
use Nans\Faq\Controller\Adminhtml\AbstractNewAction;

class NewAction extends AbstractNewAction
{
    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return Constants::ACL_QUESTION_SAVE;
    }
}
