<?php

namespace Nans\Faq\Api\Data;

interface FeedbackInterface
{
    /**
     * @param int $questionId
     * @param int $delta
     *
     * @return boolean
     */
    public function changeUseless(int $questionId, int $delta):bool ;

    /**
     * @param int $questionId
     * @param int $delta
     *
     * @return boolean
     */
    public function changeUseful(int $questionId, int $delta):bool ;
}