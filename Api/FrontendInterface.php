<?php

namespace Nans\Faq\Api;

interface FrontendInterface
{
    /**
     * @param int $questionId
     * @param int $delta
     *
     * @return boolean
     */
    public function changeUseless(int $questionId, int $delta): bool;

    /**
     * @param int $questionId
     * @param int $delta
     *
     * @return boolean
     */
    public function changeUseful(int $questionId, int $delta): bool;

    /**
     * @param int $storeId
     * @return array
     */
    public function getQuestions(int $storeId): array;

    /**
     * @param int $storeId
     * @return array
     */
    public function getCategories(int $storeId): array;
}