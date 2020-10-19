<?php

namespace AHT\CustomFormCheckout\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->addColumn(
            $setup->getTable('quote'),
            'order_byy',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'OrderBy',
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order'),
            'order_byy',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'OrderBy',
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_grid'),
            'order_byy',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'OrderBy',
            ]
        );

        $setup->endSetup();
    }
}
