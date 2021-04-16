<?php

namespace Aht\Product\Setup;

use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class UpgradeData
 *
 * @package Modulevip\Pro\Setup
 */
class UpgradeData implements UpgradeDataInterface
{

    /**
     * Creates sample blog posts
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($context->getVersion()
            && version_compare($context->getVersion(), '1.0.3') < 0
        ) {
            $tableName = $setup->getTable('aht_product_items');

            $data = [
                [
                    'name' => 'Yasuo',
                    'image' => 'pepee.png',
                    'price' => '10000',
                    'description' => 'Múa lướt ảo diệu , tốc độ pick 0.5s',
                    'featured' => 1,
                    'category_id' => null
                ],
                [
                    'name' => 'Yone',
                    'image' => 'pepee.png',
                    'price' => '10000',
                    'description' => 'Múa lướt ảo diệu , Nhưng feed vẫn feed',
                    'featured' => 1,
                    'category_id' => null
                ],
            ];

            $setup
                ->getConnection()
                ->insertMultiple($tableName, $data);
        }

        $setup->endSetup();
    }
}