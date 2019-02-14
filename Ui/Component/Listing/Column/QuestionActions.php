<?php

namespace Nans\Faq\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Helper\Constants;

class QuestionActions extends Column
{
    /** Url path */
    const PATH_EDIT = 'faq/question/edit';
    const PATH_DELETE = 'faq/question/delete';

    /** @var UrlInterface */
    protected $_urlBuilder;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item[QuestionInterface::KEY_ID])) {
                    $item[$name]['edit'] = [
                        'href'  => $this->_urlBuilder->getUrl(
                            self::PATH_EDIT, [Constants::FRONTEND_ID => $item[QuestionInterface::KEY_ID]]
                        ),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href'    => $this->_urlBuilder->getUrl(
                            self::PATH_DELETE,
                            [Constants::FRONTEND_ID => $item[QuestionInterface::KEY_ID]]
                        ),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __('Delete') . ' ' . $item[QuestionInterface::KEY_TITLE],
                            'message' => __(
                                'Are you sure you wan\'t to delete a record?'
                            )
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
