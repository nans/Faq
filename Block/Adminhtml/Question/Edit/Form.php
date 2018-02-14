<?php

namespace Nans\Faq\Block\Adminhtml\Question\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Nans\Faq\Model\ResourceModel\Category\Collection as CategoryCollection;
use Nans\Faq\Model\Category;
use Nans\Faq\Model\Question;

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
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('question_form');
        $this->setTitle(__('Question'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var Question $model */
        $model = $this->_coreRegistry->registry('faq_question');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $form->setHtmlIdPrefix('question_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField(Question::KEY_ID, 'hidden', ['name' => Question::KEY_ID]);
        }

        $fieldset->addField(
            Question::KEY_TITLE,
            'text',
            [
                'name' => Question::KEY_TITLE,
                'label' => __('Question'),
                'title' => __('Question'),
                'required' => true,
                'class' => 'validate-no-empty'
            ]
        );

        $fieldset->addField(
            Question::KEY_CONTENT,
            'editor',
            [
                'name' => Question::KEY_CONTENT,
                'label' => __('Answer'),
                'title' => __('Answer'),
                'required' => true,
                'rows' => '5',
                'cols' => '30',
                'wysiwyg' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            Question::KEY_CATEGORY_ID,
            'select',
            [
                'label' => __('Category'),
                'title' => __('Category'),
                'name' => Question::KEY_CATEGORY_ID,
                'required' => true,
                'value' => ($model->getId()) ? $model->getCategoryId() : null,
                'values' => $this->_getCategories(),
            ]
        );

        $fieldset->addField(
            Question::KEY_SORT_ORDER,
            'text',
            [
                'name' => Question::KEY_SORT_ORDER,
                'label' => __('Sort'),
                'title' => __('Sort'),
                'required' => true,
                'class' => 'validate-greater-than-zero'
            ]
        );

        $fieldset->addField(
            Question::KEY_STATUS,
            'select',
            [
                'name' => Question::KEY_STATUS,
                'label' => __('Enabled'),
                'title' => __('Enabled'),
                'required' => true,
                'values' => $this->_booleanOptions->toOptionArray(),
            ]
        );

        $fieldset->addField(
            Question::KEY_STORE_IDS,
            'multiselect',
            [
                'name' => Question::KEY_STORE_IDS,
                'label' => __('Store Views'),
                'title' => __('Store Views'),
                'note' => __('Select Store Views'),
                'required' => true,
                'values' => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );

        $fieldset->addField(
            Question::KEY_USEFUL,
            'text',
            [
                'name' => Question::KEY_USEFUL,
                'label' => __('Useful'),
                'title' => __('Useful'),
                'placeholder' => 0,
                'class' => 'validate-zero-or-greater'
            ]
        );

        $fieldset->addField(
            Question::KEY_USELESS,
            'text',
            [
                'name' => Question::KEY_USELESS,
                'label' => __('Useless'),
                'title' => __('Useless'),
                'placeholder' => 0,
                'class' => 'validate-zero-or-greater'
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
    protected function _getCategories():array
    {
        $items = $this->_categoryCollection->getItems();
        $categories = [];
        /** @var Category $item */
        foreach ($items as $item) {
            $categories[count($categories)] = ['label' => $item->getTitle(), 'value' => $item->getId()];
        }
        return $categories;
    }
}