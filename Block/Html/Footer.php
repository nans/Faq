<?php

namespace Nans\Faq\Block\Html;

use Magento\Framework\View\Element\Html\Link;

class Footer extends Link
{
    /**
     * @return string
     */
    public function getHref()
    {
        return $this->getUrl('faq');
    }
}