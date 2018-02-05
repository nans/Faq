<?php
namespace Nans\Faq\Controller\Adminhtml;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Nans\Faq\Helper\Constants;

abstract class AbstractDeleteAction extends AbstractBaseAction
{
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(Constants::FRONTEND_ID);
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
               $this->_deleteRecordById($id);
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', [Constants::FRONTEND_ID => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a record to delete.'));
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param int $id
     *
     * @return void
     */
    protected function _deleteRecordById(int $id){
        $repositoryInterface = $this->_objectManager->get($this->_getRepositoryClass());
        $repositoryInterface->deleteById($id);
    }

    /**
     * @return string
     */
    abstract protected function _getRepositoryClass():string ;
}