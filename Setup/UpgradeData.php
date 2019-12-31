<?php

namespace Nans\Faq\Setup;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        $connection = $setup->getConnection();

        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $connection->delete($setup->getTable('core_config_data'), ['path = ?' => 'nans_faq/settings/page_title']);
            $connection->delete($setup->getTable('core_config_data'), ['path = ?' => 'nans_faq/settings/page_description']);
            $connection->delete($setup->getTable('core_config_data'), ['path = ?' => 'nans_faq/settings/page_keywords']);

            $page = $this->pageFactory->create();
            $page->setTitle('Frequently Asked Questions')
                ->setIdentifier('faq')
                ->setIsActive(true)
                ->setPageLayout('1column')
                ->setStores([0])
                ->setContent('{{widget type="Nans\Faq\Block\Widget\Faq"}}')
                ->save();
        }

        $setup->endSetup();
    }
}