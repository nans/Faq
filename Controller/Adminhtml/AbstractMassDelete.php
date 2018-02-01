<?php

namespace Nans\Faq\Controller\Adminhtml;

use Magento\Framework\Phrase;

abstract class AbstractMassDelete extends AbstractMassAction
{
    /**
     * @param Object $item
     * @return void
     */
    protected function _updateItem(&$item)
    {
        $this->_getRepository()->delete($item);
    }

    /**
     * @param int $collectionSize
     * @return Phrase
     */
    protected function _getSuccessMessage($collectionSize): Phrase
    {
        return __('A total of %1 record(s) have been deleted.', $collectionSize);
    }
}