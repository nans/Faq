<?php

namespace Nans\Faq\Api\Data;

interface ChangeDateInterface
{
    const KEY_CREATION_TIME = 'creation_time';
    const KEY_UPDATE_TIME = 'update_time';

    /**
     * @return string
     */
    public function getCreationTime(): string;

    /**
     * @return string
     */
    public function getUpdateTime(): string;
}