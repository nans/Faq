<?php

namespace Nans\Faq\Api\Data;

interface BaseInterface
{
    const KEY_TITLE = 'title';
    const KEY_STORE_IDS = 'store_ids';
    const KEY_SORT_ORDER = 'sort_order';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title);

    /**
     * @return int
     */
    public function getSortOrder(): int;

    /**
     * @param int $sortOrder
     *
     * @return void
     */
    public function setSortOrder(int $sortOrder);

    /**
     * @return string
     */
    public function getStoreIds(): string;

    /**
     * @param string $storeIds
     *
     * @return void
     */
    public function setStoreIds(string $storeIds);
}