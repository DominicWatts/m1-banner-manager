<?php

/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer      = $this;

$sliderPrefix       = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
$bannerPrefix       = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();

$sliderTableName    = $installer->getTable('xigen_bannermanager/slider');
$bannerTableName    = $installer->getTable('xigen_bannermanager/banner');

$installer->startSetup();

$installer->getConnection()
    ->addColumn($sliderTableName,
    'category_id',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'default' => null,
        'comment' => 'Category Id'
    )
);

$installer->endSetup();