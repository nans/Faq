<?php

namespace Nans\Faq\Model;

use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Model\ResourceModel\Question as ResourceModel;

class Question extends AbstractBaseModel implements QuestionInterface
{
    const KEY_ID = 'question_id';
    const KEY_CATEGORY_ID = 'category_id';
    const KEY_CONTENT = 'content';
    const KEY_USEFUL = 'useful';
    const KEY_USELESS = 'useless';

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'faq_question';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

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
        return $this->getData(self::KEY_CATEGORY_ID);
    }

    /**
     * @param int $categoryId
     *
     * @return void
     */
    public function setCategoryId(int $categoryId)
    {
        $this->setData(self::KEY_CATEGORY_ID, $categoryId);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->getData(self::KEY_CONTENT);
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content)
    {
        $this->setData(self::KEY_CONTENT, $content);
    }

    /**
     * @return int
     */
    public function getUseful(): int
    {
        return $this->getData(self::KEY_USEFUL);
    }

    /**
     * @param int $usefulCount
     *
     * @return void
     */
    public function setUseful(int $usefulCount)
    {
        $this->setData(self::KEY_USEFUL, $usefulCount);
    }

    /**
     * @return int
     */
    public function getUseless(): int
    {
        return $this->getData(self::KEY_USELESS);
    }

    /**
     * @param int $uselessCount
     *
     * @return void
     */
    public function setUseless(int $uselessCount)
    {
        $this->setData(self::KEY_USELESS, $uselessCount);
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