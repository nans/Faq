<?php

namespace Nans\Faq\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Model\AbstractModel;
use Nans\Faq\Api\Data\BaseInterface;
use Nans\Faq\Helper\Constants;

abstract class AbstractSaveAction extends AbstractBaseAction
{
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $this->_prepareData($data);

            $repository = $this->_objectManager->get($this->_getRepositoryClass());

            /** @var BaseInterface|AbstractModel $model  */
            $model = $repository->create();

            $id = $this->getRequest()->getParam($this->_getIdFieldName());
            if ($id) {
                $model = $repository->getById($id);
            }

            $model->setData($data);

            try {
                $repository->save($model);
                $this->messageManager->addSuccessMessage(__('Changes was saved.'));
                $this->_objectManager->get(Session::class)->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [Constants::FRONTEND_ID => $this->_getIdFromModel($model),
                         '_current'             => true]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e, __('Something went wrong while saving.')
                );
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath(
                '*/*/edit',
                [Constants::FRONTEND_ID => $this->getRequest()->getParam($this->_getIdFieldName())]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param BaseInterface $model
     *
     * @return int
     */
    protected function _getIdFromModel(BaseInterface $model): int
    {
        /** @var BaseInterface $model */
        return $model->getId();
    }

    /**
     * @param array $data
     * @return void
     */
    protected function _prepareData(array &$data)
    {

    }

    /**
     * @return string
     */
    abstract protected function _getRepositoryClass(): string;

    /**
     * @return string
     */
    abstract protected function _getIdFieldName(): string;
}