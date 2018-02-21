<?php

namespace Nans\Faq\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Nans\Faq\Api\Data\BaseInterface;
use Nans\Faq\Api\Data\ChangeDateInterface;
use Nans\Faq\Api\Data\StatusInterface;

abstract class AbstractBaseModel extends AbstractModel
    implements BaseInterface, StatusInterface, ChangeDateInterface, IdentityInterface
{
    /**
     * @return string
     */
    public function getCreationTime(): string
    {
        return $this->getData(self::KEY_CREATION_TIME);
    }

    /**
     * @return string
     */
    public function getUpdateTime(): string
    {
        return $this->getData(self::KEY_UPDATE_TIME);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::KEY_STATUS);
    }

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status)
    {
        $this->setData(self::KEY_STATUS, $status);
    }

    /**
     * @return  void
     */
    public function activate()
    {
        $this->setStatus(self::STATUS_ACTIVE);
    }

    /**
     * @return  void
     */
    public function deactivate()
    {
        $this->setStatus(self::STATUS_INACTIVE);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData(self::KEY_TITLE);
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->setData(self::KEY_TITLE, $title);
    }

    /**
     * @return int
     */
    public function getSortOrder(): int
    {
        return $this->getData(self::KEY_SORT_ORDER);
    }

    /**
     * @param int $sortOrder
     *
     * @return void
     */
    public function setSortOrder(int $sortOrder)
    {
        $this->setData(self::KEY_SORT_ORDER, $sortOrder);
    }

    /**
     * @return string
     */
    public function getStoreIds(): string
    {
        return $this->getData(self::KEY_STORE_IDS);
    }

    /**
     * @param string $storeIds
     *
     * @return void
     */
    public function setStoreIds(string $storeIds)
    {
        $this->setData(self::KEY_STORE_IDS, $storeIds);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getStatus() == self::STATUS_ACTIVE;
    }
}