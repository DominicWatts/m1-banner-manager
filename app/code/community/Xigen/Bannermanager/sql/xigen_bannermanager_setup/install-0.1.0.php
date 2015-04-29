<?php
/**
 * Post installation script
 *
 * @author Xigen
 */

/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;

$installer->startSetup();

$sliderPrefix       = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
$bannerPrefix       = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();

$sliderTableName    = $installer->getTable('xigen_bannermanager/slider');
$bannerTableName    = $installer->getTable('xigen_bannermanager/banner');

$installer->run("DROP TABLE IF EXISTS {$sliderTableName};");
$installer->run("DROP TABLE IF EXISTS {$bannerTableName};");


/**
 * Creating table xigen_bannermanager_slider
 */
// Check if the table already exists
if ($installer->getConnection()->isTableExists($sliderTableName) != true) {
    $table = $installer->getConnection()
        ->newTable($sliderTableName)
        ->addColumn($sliderPrefix . 'id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Slider id')
        ->addColumn($sliderPrefix . 'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'Slider name')
        ->addColumn($sliderPrefix . 'style', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'Slider Style')
        ->addColumn($sliderPrefix . 'show_title', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'nullable' => true,
            'default'  => 1,
        ), 'Show Title') 
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'default'  => 0,
            'nullable' => false,
        ), 'Sort order')
        ->addColumn($sliderPrefix . 'sort', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'Sort order')
        ->addColumn($sliderPrefix . 'created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => true,
            'default'  => 'CURRENT_TIMESTAMP',
        ), 'Creation time')  
        ->addColumn($sliderPrefix . 'is_trash', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'nullable' => true,
            'default'  => 0,
        ), 'Is Trash')               
        ->addColumn($sliderPrefix . 'is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'nullable' => false,
            'default'  => '1',
        ), 'Is active')
        ->setComment('Xigen Slider');

    $installer->getConnection()->createTable($table);
}
/**
 * Creating table xigen_bannermanager_banner
 */

// Check if the table already exists
if ($installer->getConnection()->isTableExists($bannerTableName) != true) {
    $table = $installer->getConnection()
        ->newTable($bannerTableName)
        ->addColumn($bannerPrefix . 'id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Banner id')
        ->addColumn($bannerPrefix . 'title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable' => true,
        ), 'Title')
        ->addColumn($bannerPrefix . 'show_title', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'nullable' => true,
            'default'  => '1',
        ), 'Show Title')
        ->addColumn($bannerPrefix . 'image', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => true,
            'default'  => null,
        ), 'Banner image media path')          
        ->addColumn($bannerPrefix . 'link', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
            'default'   => true,
        ), 'Link')
        ->addColumn($bannerPrefix . 'caption', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
            'nullable' => true,
            'default'  => null,
        ), 'Caption')
        ->addColumn($bannerPrefix . 'created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => true,
            'default'  => 'CURRENT_TIMESTAMP',
        ), 'Creation time')
        ->addColumn($bannerPrefix . 'slider_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'nullable' => false,
        ), 'Slider id')
        ->addColumn($bannerPrefix . 'sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => true,
            'default'  => null,
        ), 'Sort Order') 
        ->addColumn($bannerPrefix . 'is_trash', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'nullable' => true,
            'default'  => '0',
        ), 'Is trash')
        ->addColumn($bannerPrefix . 'is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned' => true,
            'nullable' => false,
            'default'  => '1',
        ), 'Is active')   
        ->addIndex($installer->getIdxName('xigen_bannermanager/banner', array($bannerPrefix . 'slider_id')),
            array($bannerPrefix . 'slider_id'))
        ->addForeignKey(
            $installer->getFkName(
                'xigen_bannermanager/banner',
                $bannerPrefix . 'slider_id',
                'xigen_bannermanager/slider',
                $sliderPrefix . 'id'
            ),
            $bannerPrefix . 'slider_id', $sliderTableName, $sliderPrefix . 'id',
            Varien_Db_Ddl_Table::ACTION_NO_ACTION, Varien_Db_Ddl_Table::ACTION_NO_ACTION)        
    ->setComment('Xigen Banner');

    $installer->getConnection()->createTable($table);
}

$installer->endSetup();