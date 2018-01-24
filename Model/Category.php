<?php

namespace Nans\Faq\Model;

use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Model\ResourceModel\Category as ResourceModel;

class Category extends AbstractBaseModel implements CategoryInterface
{
    const ID = 'category_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}