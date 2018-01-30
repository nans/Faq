<?php

namespace Nans\Faq\Block\Frontend;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;
use Nans\Faq\Model\ResourceModel\Question\Collection as QuestionCollection;

class Question extends Template
{
    /**
     * @type \Magento\Store\Model\StoreManagerInterface
     */
    public $_storeManager;

    /**
     * @var CategoryCollection
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param ObjectManagerInterface $objectManager ,
     * @param array $data
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        array $data = []
    ) {
        $this->_storeManager = $context->getStoreManager();
        $this->_objectManager = $objectManager;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getQuestions():array
    {
        /** @var QuestionCollection $questionCollection */
        $questionCollection = $this->_objectManager->create(QuestionCollection::class);
        $questions = $questionCollection->getDataByStoreId($this->_storeManager->getStore()->getId())->getItems();
        return $questions;
    }

    /**
     * @return array
     */
    public function getCategories():array
    {
        /** @var CategoryCollection $categoryCollection */
        $categoryCollection = $this->_objectManager->create(CategoryCollection::class);
        $categories = $categoryCollection->getDataByStoreId($this->_storeManager->getStore()->getId())->getItems();
        return $categories;
    }

    /**
     * @return string
     */
    public function getApiUrl():string
    {
        return $this->getUrl('rest/V1/feedback/');
    }
}