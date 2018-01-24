<?php

namespace Nans\Faq\Api\Data;

interface ChangeDateInterface
{
    /**
     * @return string
     */
    public function getCreationTime(): string;

    /**
     * @return string
     */
    public function getUpdateTime(): string;
}