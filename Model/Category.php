<?php

namespace Nans\Faq\Model;

use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Model\ResourceModel\Category as ResourceModel;

class Category extends AbstractBaseModel implements CategoryInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'faq_category';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}