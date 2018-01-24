<?php

namespace Nans\Faq\Api\Data;

interface StatusInterface
{
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