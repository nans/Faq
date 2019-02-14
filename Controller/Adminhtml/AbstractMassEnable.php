<?php

namespace Nans\Faq\Controller\Adminhtml;

use Exception;
use Magento\Framework\Phrase;
use Nans\Faq\Api\Data\StatusInterface;

abstract class AbstractMassEnable extends AbstractMassAction
{
    /**
     * @param int $collectionSize
     * @return Phrase
     */
    protected function _getSuccessMessage(int $collectionSize): Phrase
    {
        return __('A total of %1 record(s) have been enabled.', $collectionSize);
    }

    /**
     * @param StatusInterface $item
     * @return bool
     */
    protected function _updateItem(&$item): bool
    {
        try {
            $item->activate();
            $this->_getRepository()->save($item);

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}