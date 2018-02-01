<?php

namespace Nans\Faq\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Phrase;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;

abstract class AbstractMassAction extends AbstractBaseAction
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @param Context $context
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        Filter $filter
    ) {
        $this->_filter = $filter;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        /** @var \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $collection */
        $collection = $this->_filter->getCollection($this->_objectManager->create($this->_getCollectionClass()));
        $collectionSize = $collection->getSize();
        if ($collectionSize > 0) {
            foreach ($collection as $item) {
                $this->_updateItem($item);
            }
        }
        $this->messageManager->addSuccessMessage($this->_getSuccessMessage($collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    protected function _getRepository()
    {
        return $this->_objectManager->get($this->_getRepositoryClass());
    }

    /**
     * @return string
     */
    abstract protected function _getCollectionClass():string ;

    /**
     * @param int $collectionSize
     * @return Phrase
     */
    abstract protected function _getSuccessMessage($collectionSize): Phrase ;

    /**
     * @param Object $item
     * @return void
     */
    abstract protected function _updateItem(&$item);

    /**
     * @return string
     */
    abstract protected function _getRepositoryClass():string ;
}