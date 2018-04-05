<?php

namespace Nans\Faq\Block\Html;

use Magento\Framework\View\Element\Html\Link;

class Footer extends Link
{
    public function getHref()
    {
        return 'faq';
    }
}