<?php

namespace Nans\Faq\Controller\Adminhtml;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
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
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        /** @var AbstractCollection $collection */
        $collection = $this->_filter->getCollection($this->_objectManager->create($this->_getCollectionClass()));
        $collectionSize = $collection->getSize();
        if ($collectionSize > 0) {
            foreach ($collection as $item) {
                $this->_updateItem($item);
            }
        }
        $this->messageManager->addSuccessMessage($this->_getSuccessMessage($collectionSize));

        /** @var Redirect $resultRedirect */
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
    abstract protected function _getSuccessMessage(int $collectionSize): Phrase ;

    /**
     * @param Object $item
     * @return bool
     */
    abstract protected function _updateItem(&$item):bool ;

    /**
     * @return string
     */
    abstract protected function _getRepositoryClass():string ;
}