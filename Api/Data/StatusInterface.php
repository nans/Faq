<?php

namespace Nans\Faq\Api\Data;

interface StatusInterface
{
    const KEY_STATUS = 'status';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status);

    /**
     * @return void
     */
    public function activate();

    /**
     * @return void
     */
    public function deactivate();

    /**
     * @return bool
     */
    public function isActive(): bool;
}