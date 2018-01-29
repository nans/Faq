<?php

namespace Nans\Faq\Controller\Adminhtml\Question;

use Magento\Backend\Model\View\Result\Page;
use Nans\Faq\Helper\Constants;
use Nans\Faq\Controller\Adminhtml\AbstractIndexAction;

class Index extends AbstractIndexAction
{

    protected function _setResultPageParams(Page &$resultPage)
    {
        $resultPage->setActiveMenu('Nans_Faq::question');
        $resultPage->addBreadcrumb(__('FAQ Questions'), __('FAQ Questions'));
        $resultPage->addBreadcrumb(__('Manage'), __('Manage'));
        $resultPage->getConfig()->getTitle()->prepend(__('FAQ Questions'));
    }

    /**
     * @return string
     */
    protected function _getACLName(): string
    {
        return Constants::ACL_QUESTION_VIEW;
    }
}