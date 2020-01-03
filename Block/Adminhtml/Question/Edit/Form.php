<?php

namespace Nans\Faq\Block\Adminhtml\Question\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Api\Data\StatusInterface;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;

class Form extends Generic
{
    /**
     * @var Yesno
     */
    protected $_booleanOptions;

    /**
     * @var Store
     */
    protected $_systemStore;

    /**
     * @var Config
     */
    protected $_wysiwygConfig;

    /**
     * @var CategoryCollection
     */
    protected $_categoryCollection;

    /**
     * @var Registry
     */
    private $_registry;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Yesno $booleanOptions
     * @param Store $systemStore
     * @param Config $wysiwygConfig
     * @param CategoryCollection $collection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Yesno $booleanOptions,
        Store $systemStore,
        Config $wysiwygConfig,
        CategoryCollection $collection,
        array $data = []
    ) {
        $this->_booleanOptions = $booleanOptions;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_categoryCollection = $collection;
        $this->_registry = $registry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('question_form');
        $this->setTitle(__('Question'));
    }

    /**
     * @return Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        /** @var QuestionInterface|AbstractModel $model */
        $model = $this->_registry->registry('faq_question');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'     => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                ],
            ]
        );

        $form->setHtmlIdPrefix('question_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField(QuestionInterface::KEY_ID, 'hidden', ['name' => QuestionInterface::KEY_ID]);
        }

        $fieldset->addField(
            QuestionInterface::KEY_TITLE,
            'text',
            [
                'name'     => QuestionInterface::KEY_TITLE,
                'label'    => __('Question'),
                'title'    => __('Question'),
                'required' => true,
                'class'    => 'validate-no-empty',
            ]
        );

        $fieldset->addField(
            QuestionInterface::KEY_CONTENT,
            'editor',
            [
                'name'     => QuestionInterface::KEY_CONTENT,
                'label'    => __('Answer'),
                'title'    => __('Answer'),
                'required' => true,
                'rows'     => '5',
                'cols'     => '30',
                'wysiwyg'  => true,
                'config'   => $this->_wysiwygConfig->getConfig(),
            ]
        );

        $fieldset->addField(
            QuestionInterface::KEY_CATEGORY_ID,
            'select',
            [
                'label'    => __('Category'),
                'title'    => __('Category'),
                'name'     => QuestionInterface::KEY_CATEGORY_ID,
                'required' => true,
                'value'    => ($model->getId()) ? $model->getCategoryId() : null,
                'values'   => $this->_getCategories(),
            ]
        );

        $fieldset->addField(
            QuestionInterface::KEY_SORT_ORDER,
            'text',
            [
                'name'     => QuestionInterface::KEY_SORT_ORDER,
                'label'    => __('Sort'),
                'title'    => __('Sort'),
                'required' => true,
                'class'    => 'validate-greater-than-zero',
            ]
        );

        $fieldset->addField(
            StatusInterface::KEY_STATUS,
            'select',
            [
                'name'     => StatusInterface::KEY_STATUS,
                'label'    => __('Enabled'),
                'title'    => __('Enabled'),
                'required' => true,
                'values'   => $this->_booleanOptions->toOptionArray(),
            ]
        );

        $fieldset->addField(
            QuestionInterface::KEY_STORE_IDS,
            'multiselect',
            [
                'name'     => QuestionInterface::KEY_STORE_IDS,
                'label'    => __('Store Views'),
                'title'    => __('Store Views'),
                'note'     => __('Select Store Views'),
                'required' => true,
                'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );

        $fieldset->addField(
            QuestionInterface::KEY_USEFUL,
            'text',
            [
                'name'        => QuestionInterface::KEY_USEFUL,
                'label'       => __('Useful'),
                'title'       => __('Useful'),
                'placeholder' => 0,
                'class'       => 'validate-zero-or-greater',
            ]
        );

        $fieldset->addField(
            QuestionInterface::KEY_USELESS,
            'text',
            [
                'name'        => QuestionInterface::KEY_USELESS,
                'label'       => __('Useless'),
                'title'       => __('Useless'),
                'placeholder' => 0,
                'class'       => 'validate-zero-or-greater',
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return array
     */
    protected function _getCategories(): array
    {
        $items = $this->_categoryCollection->getItems();
        $categories = [];
        /** @var CategoryInterface $item */
        foreach ($items as $item) {
            $categories[count($categories)] = ['label' => $item->getTitle(), 'value' => $item->getId()];
        }

        return $categories;
    }
}