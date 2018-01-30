<?php

namespace Nans\Faq\Ui\Component\Listing\Column\Question;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Nans\Faq\Model\Category;
use Nans\Faq\Model\Question;
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
                if (!empty($item[Question::CATEGORY_ID]) && in_array($item[Question::CATEGORY_ID], $allIds)) {
                    /** @var Category $category */
                    $category = $this->_collection->getItemByColumnValue(Category::ID, $item[Question::CATEGORY_ID]);
                    $item[$this->getName()] = $category->getTitle();
                }
            }
        }
        return $dataSource;
    }
}