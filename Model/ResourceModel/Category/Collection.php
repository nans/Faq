<?php

namespace Nans\Faq\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Nans\Faq\Model\Category as Model;
use Nans\Faq\Model\ResourceModel\Category as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = Model::KEY_ID;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

    /**
     * @param int $storeId
     *
     * @return Collection $this
     */
    public function getDataByStoreId(int $storeId):Collection
    {

        $this->getSelect()
            ->where(
                'FIND_IN_SET(' . $storeId
                . ',`main_table`.`' . Model::KEY_STORE_IDS . '`)'
            )
            ->orWhere('FIND_IN_SET(0,`main_table`.`' . Model::KEY_STORE_IDS . '`)');
        $this->addOrder(Model::KEY_SORT_ORDER, self::SORT_ORDER_ASC);
        $this->addFieldToFilter(Model::KEY_STATUS, Model::STATUS_ACTIVE);
        return $this;
    }
}