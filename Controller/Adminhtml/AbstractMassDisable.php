<?php

namespace Nans\Faq\Controller\Adminhtml;

use Magento\Framework\Phrase;
use Nans\Faq\Api\Data\StatusInterface;

abstract class AbstractMassDisable extends AbstractMassAction
{
    /**
     * @param int $collectionSize
     * @return Phrase
     */
    protected function _getSuccessMessage($collectionSize):Phrase
    {
        return __('A total of %1 record(s) have been disabled.', $collectionSize);
    }

    /**
     * @param StatusInterface $item
     * @return void
     */
    protected function _updateItem(&$item)
    {
        $item->deactivate();
    }
}