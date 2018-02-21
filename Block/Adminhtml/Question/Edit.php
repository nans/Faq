<?php

namespace Nans\Faq\Block\Adminhtml\Question;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;
use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Helper\AclNames;

class Edit extends Container
{
    /**
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = QuestionInterface::KEY_ID;
        $this->_blockGroup = 'Nans_Faq';
        $this->_controller = 'adminhtml_question';

        parent::_construct();

        if ($this->_isAllowedAction(AclNames::ACL_QUESTION_SAVE)) {
            $this->buttonList->update('save', 'label', __('Save'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => [
                                'event' => 'saveAndContinueEdit',
                                'target' => '#edit_form'
                            ],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction(AclNames::ACL_QUESTION_DELETE)) {
            $this->buttonList->update('delete', 'label', __('Delete'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * @return Phrase
     */
    public function getHeaderText(): Phrase
    {
        /** @var QuestionInterface $model */
        $model = $this->_coreRegistry->registry('faq_question');
        if ($model->getId()) {
            return __("Edit '%1'", $this->escapeHtml($model->getTitle()));
        } else {
            return __('New question');
        }
    }

    /**
     * @param string $resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction(string $resourceId):bool
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * @return string
     */
    protected function _getSaveAndContinueUrl():string
    {
        return $this->getUrl(
            'faq/*/save',
            ['_current' => true, 'back' => 'edit', 'active_tab' => '']
        );
    }
}