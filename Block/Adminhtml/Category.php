<?php

namespace Nans\Faq\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;
use Nans\Faq\Helper\AclNames;

class Category extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'Faq';
        $this->_headerText = __('Manage');

        parent::_construct();

        if ($this->_authorization->isAllowed(AclNames::ACL_CATEGORY_SAVE)) {
            $this->buttonList->update('add', 'label', __('Add New'));
        } else {
            $this->buttonList->remove('add');
        }
    }
}