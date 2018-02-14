<?php

namespace Nans\Faq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Nans\Faq\Helper\Constants;
use Nans\Faq\Model\Question as Model;

class Question extends AbstractDb
{
    const MAIN_TABLE = Constants::DB_PREFIX . 'faq_question';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, Model::KEY_ID);
    }
}