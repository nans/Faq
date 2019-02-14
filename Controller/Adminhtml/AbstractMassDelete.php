<?php

namespace Nans\Faq\Controller\Adminhtml;

use Exception;
use Magento\Framework\Phrase;

abstract class AbstractMassDelete extends AbstractMassAction
{
    /**
     * @param Object $item
     * @return bool
     */
    protected function _updateItem(&$item): bool
    {
        try {
            $this->_getRepository()->delete($item);

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $collectionSize
     * @return Phrase
     */
    protected function _getSuccessMessage(int $collectionSize): Phrase
    {
        return __('A total of %1 record(s) have been deleted.', $collectionSize);
    }
}