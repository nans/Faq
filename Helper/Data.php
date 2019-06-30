<?php

namespace Nans\Faq\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * FAQ page title
     *
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->scopeConfig->getValue('nans_faq/settings/page_title');
    }

    /**
     * FAQ page description
     *
     * @return string
     */
    public function getPageDescription(): string
    {
        return $this->scopeConfig->getValue('nans_faq/settings/page_description');
    }

    /**
     * FAQ page keywords
     *
     * @return string
     */
    public function getPageKeywords(): string
    {
        return $this->scopeConfig->getValue('nans_faq/settings/page_keywords');
    }
}