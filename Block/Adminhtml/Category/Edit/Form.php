<?php

namespace Nans\Faq\Block\Adminhtml\Category\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Api\Data\StatusInterface;

class Form extends Generic
{
    /**
     * Boolean options
     *
     * @var Yesno
     */
    protected $_booleanOptions;

    /**
     * @var Store
     */
    protected $_systemStore;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Yesno $booleanOptions
     * @param Store $systemStore
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Yesno $booleanOptions,
        Store $systemStore,
        array $data = []
    ) {
        $this->_booleanOptions = $booleanOptions;
        $this->_systemStore = $systemStore;
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
        $this->setId('category_form');
        $this->setTitle(__('Category'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var CategoryInterface|AbstractModel $model */
        $model = $this->_coreRegistry->registry('faq_category');

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

        $form->setHtmlIdPrefix('category_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField(CategoryInterface::KEY_ID, 'hidden', ['name' => CategoryInterface::KEY_ID]);
        }

        $fieldset->addField(
            CategoryInterface::KEY_TITLE,
            'text',
            [
                'name' => CategoryInterface::KEY_TITLE,
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
                'class' => 'validate-no-empty'
            ]
        );

        $fieldset->addField(
            CategoryInterface::KEY_SORT_ORDER,
            'text',
            [
                'name' => CategoryInterface::KEY_SORT_ORDER,
                'label' => __('Sort'),
                'title' => __('Sort'),
                'required' => true,
                'class' => 'validate-greater-than-zero'
            ]
        );

        $fieldset->addField(
            StatusInterface::KEY_STATUS,
            'select',
            [
                'name' => StatusInterface::KEY_STATUS,
                'label' => __('Enabled'),
                'title' => __('Enabled'),
                'required' => true,
                'values' => $this->_booleanOptions->toOptionArray(),
            ]
        );

        $fieldset->addField(
            CategoryInterface::KEY_STORE_IDS,
            'multiselect',
            [
                'name' => CategoryInterface::KEY_STORE_IDS,
                'label' => __('Store Views'),
                'title' => __('Store Views'),
                'note' => __('Select Store Views'),
                'required' => true,
                'values' => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}