<?php

namespace Nans\Faq\Model;

use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Model\ResourceModel\Question as ResourceModel;

class Question extends AbstractBaseModel implements QuestionInterface
{
    const ID = 'question_id';
    const CATEGORY_ID = 'category_id';
    const CONTENT = 'content';
    const USEFUL = 'useful';
    const USELESS = 'useless';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * @param int $categoryId
     *
     * @return void
     */
    public function setCategoryId(int $categoryId)
    {
        $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content)
    {
        $this->setData(self::CONTENT, $content);
    }

    /**
     * @return int
     */
    public function getUseful(): int
    {
        return $this->getData(self::USEFUL);
    }

    /**
     * @param int $usefulCount
     *
     * @return void
     */
    public function setUseful(int $usefulCount)
    {
        $this->getData(self::USEFUL, $usefulCount);
    }

    /**
     * @return int
     */
    public function getUseless(): int
    {
        return $this->getData(self::USELESS);
    }

    /**
     * @param int $uselessCount
     *
     * @return void
     */
    public function setUseless(int $uselessCount)
    {
        $this->setData(self::USELESS, $uselessCount);
    }
}