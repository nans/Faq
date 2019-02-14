<?php

namespace Nans\Faq\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\Session;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Nans\Faq\Api\Data\BaseInterface;
use Nans\Faq\Helper\Constants;

abstract class AbstractEditAction extends AbstractBaseAction
{
    /**
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Edit record data
     *
     * @return Page|Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(Constants::FRONTEND_ID);
        $repository = $this->_objectManager->get($this->_getRepositoryClass());

        /** @var BaseInterface|AbstractModel $model */
        if ($id) {
            $model = $repository->getById($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $repository->create();
        }

        $data = $this->_objectManager->get(Session::class)->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register($this->_getRegisterName(), $model);

        /** @var Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();

        return $this->_initAction($resultPage, $model);
    }

    /**
     * @return string
     */
    abstract protected function _getRegisterName(): string;

    /**
     * @param Page $resultPage
     * @param BaseInterface $model
     * @return Page
     */
    abstract protected function _initAction(Page $resultPage, BaseInterface $model);

    /**
     * @return string
     */
    abstract protected function _getRepositoryClass(): string;
}