<?php //
/**
 * Banner manager installation script
 *
 * @author Xigen
 */

/**
 *  @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;

$sliderPrefix = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
$bannerPrefix = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();

/**
 * @var $model Xigen_Bannermanager_Model_Slider
 */
$slider = Mage::getModel('xigen_bannermanager/slider');

// Set up data rows
$sliderRows = array(
    array(
        $sliderPrefix . 'title'         => 'Slider One',
        $sliderPrefix . 'sort'          => 'orderly',
        $sliderPrefix . 'style'         => 'static',
    ),
    array(
        $sliderPrefix . 'title'         => 'Slider Two',
        $sliderPrefix . 'sort'          => 'random',
        $sliderPrefix . 'style'         => 'single-static',
        $sliderPrefix . 'position'      => 'sidebar-right-top',
    ),
    array(
        $sliderPrefix . 'title'         => 'Slider Three',
        $sliderPrefix . 'sort'          => 'orderly',
        $sliderPrefix . 'style'         => 'static',
    ),
);

// Generate slider items
foreach ($sliderRows as $sliderData) {
    $slider->setData($sliderData)->setOrigData()->save();
}

/**
 * @var $model Xigen_Bannermanager_Model_Banner
 */
$banner = Mage::getModel('xigen_bannermanager/banner');

// Set up data rows
$bannerRows = array(
    array(
        $bannerPrefix . 'title'         => 'Banner One',
        $bannerPrefix . 'link'          => '/banner-one/',
        $bannerPrefix . 'image'         => 'banner-1.jpg',
        $bannerPrefix . 'caption'       => 'Pellentesque habitant morbi tristique. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.',
        $bannerPrefix . 'slider_id'     => '1',
        $bannerPrefix . 'sort_order'    => '1',
        $bannerPrefix . 'is_trash'      => '0',
    ),
    array(
        $bannerPrefix . 'title'         => 'Banner Two',
        $bannerPrefix . 'link'          => '/banner-two/',
        $bannerPrefix . 'image'         => 'banner-2.jpg',
        $bannerPrefix . 'caption'       => 'Pellentesque habitant morbi tristique. Ultricies eget, tempor sit amet, ante.',
        $bannerPrefix . 'slider_id'     => '1',
        $bannerPrefix . 'sort_order'    => '2',
        $bannerPrefix . 'is_trash'      => '1',
    ),
    array(
        $bannerPrefix . 'title'         => 'Banner Three',
        $bannerPrefix . 'link'          => '/banner-three/',
        $bannerPrefix . 'image'         => 'banner-3.jpg',
        $bannerPrefix . 'caption'       => 'Pellentesque habitant morbi tristique. Vestibulum tortor ante.',
        $bannerPrefix . 'slider_id'     => '1',
        $bannerPrefix . 'sort_order'    => '1',
        $bannerPrefix . 'is_trash'      => '0',
    ),
    array(
        $bannerPrefix . 'title'         => 'Banner Four',
        $bannerPrefix . 'link'          => '/banner-four/',
        $bannerPrefix . 'youtube'       => 'BI4YbU1PxPw',
        $bannerPrefix . 'caption'       => 'Pellentesque habitant morbi tristique. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.',
        $bannerPrefix . 'slider_id'     => '2',
        $bannerPrefix . 'sort_order'    => '1',
        $bannerPrefix . 'is_trash'      => '0',
    ),
    array(
        $bannerPrefix . 'title'         => 'Banner Five',
        $bannerPrefix . 'link'          => '/banner-five/',
        $bannerPrefix . 'image'         => 'banner-5.jpg',
        $bannerPrefix . 'caption'       => 'Pellentesque habitant morbi tristique. Ultricies eget, tempor sit amet, ante.',
        $bannerPrefix . 'slider_id'     => '2',
        $bannerPrefix . 'sort_order'    => '2',
        $bannerPrefix . 'is_trash'      => '1',
    ),
    array(
        $bannerPrefix . 'title'         => 'Banner Six',
        $bannerPrefix . 'link'          => '/banner-six/',
        $bannerPrefix . 'image'         => 'banner-6.jpg',
        $bannerPrefix . 'caption'       => 'Pellentesque habitant morbi tristique. Vestibulum tortor ante.',
        $bannerPrefix . 'slider_id'     => '2',
        $bannerPrefix . 'sort_order'    => '1',
        $bannerPrefix . 'is_trash'      => '0',
    ),    
);

// Generate banner items
foreach ($bannerRows as $bannerData) {
   $banner->setData($bannerData)->setOrigData()->save();
}