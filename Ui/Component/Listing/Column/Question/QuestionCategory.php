<?php

namespace Nans\Faq\Ui\Component\Listing\Column\Question;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Model\ResourceModel\Category\Collection;

class QuestionCategory extends Column
{
    /**
     * @var Collection
     */
    protected $_collection;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Collection $collection
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Collection $collection,
        array $components = [],
        array $data = []
    ) {
        $this->_collection = $collection;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $allIds = $this->_collection->getAllIds();
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item[QuestionInterface::KEY_CATEGORY_ID]) && in_array($item[QuestionInterface::KEY_CATEGORY_ID], $allIds)) {
                    /** @var CategoryInterface $category */
                    $category = $this->_collection->getItemByColumnValue(
                        CategoryInterface::KEY_ID,
                        $item[QuestionInterface::KEY_CATEGORY_ID]
                    );
                    $item[$this->getName()] = $category->getTitle();
                }
            }
        }

        return $dataSource;
    }
}