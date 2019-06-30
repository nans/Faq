<?php

namespace Nans\Faq\Controller\Index;

use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Page\Config;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Nans\Faq\Helper\Data;

class Index extends Action
{
    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @param Context $context
     * @param Data $dataHelper
     */
    public function __construct(
        Context $context,
        Data $dataHelper
    ) {
        parent::__construct($context);
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var ResultInterface|Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        /** @var Config $config */
        $config = $resultPage->getConfig();
        $config->getTitle()->set($this->dataHelper->getPageTitle());
        $config->setDescription($this->dataHelper->getPageDescription());
        $config->setKeywords($this->dataHelper->getPageKeywords());

        return $resultPage;
    }
}
