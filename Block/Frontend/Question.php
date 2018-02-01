<?php

namespace Nans\Faq\Block\Frontend;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Nans\Faq\Helper\Constants;

class Question extends Template
{
    /**
     * @type StoreManagerInterface
     */
    public $_storeManager;

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        $this->_storeManager = $context->getStoreManager();

        parent::__construct($context, $data);
    }

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return Constants::API_URL;
    }
}