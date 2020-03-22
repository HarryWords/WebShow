<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_get_demo_array($dir_url, $dir_path){

    $demo_items = array(
        array(
            'image'     => 'images/demo-01.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-01/',
            'title'     => 'Demo 01',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-02.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-02/',
            'title'     => 'Demo 02',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-03.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-03/',
            'title'     => 'Demo 03',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-04.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-04/',
            'title'     => 'Demo 04',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-05.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-05/',
            'title'     => 'Demo 05',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-06.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-06/',
            'title'     => 'Demo 06',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-07.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-07/',
            'title'     => 'Demo 07',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-08.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-08/',
            'title'     => 'Demo 08',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-09.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-09/',
            'title'     => 'Demo 09',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-10.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-10/',
            'title'     => 'Demo 10',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-11.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-11/',
            'title'     => 'Demo 11',
            'category'  => 'Shop Fashion'
        ),
        array(
            'image'     => 'images/demo-12.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-12/',
            'title'     => 'Demo 12',
            'category'  => 'Shop Watch'
        ),
        array(
            'image'     => 'images/demo-13.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-13/',
            'title'     => 'Demo 13',
            'category'  => 'Shop Watch'
        ),
        array(
            'image'     => 'images/demo-14.jpg',
            'link'      => 'https://raz.la-studioweb.com/home-14/',
            'title'     => 'Demo 14',
            'category'  => 'Shop Flower'
        )
    );

    $default_image_setting = array(
        'woocommerce_single_image_width' => 1200,
        'woocommerce_thumbnail_image_width' => 600,
        'woocommerce_thumbnail_cropping' => 'custom',
        'woocommerce_thumbnail_cropping_custom_width' => 4,
        'woocommerce_thumbnail_cropping_custom_height' => 5,
        'thumbnail_size_w' => 0,
        'thumbnail_size_h' => 0,
        'medium_size_w' => 0,
        'medium_size_h' => 0,
        'medium_large_size_w' => 0,
        'medium_large_size_h' => 0,
        'large_size_w' => 0,
        'large_size_h' => 0
    );

    $default_menu = array(
        'main-nav'              => 'Primary Menu'
    );

    $default_page = array(
        'page_for_posts' 	            => 'Blog',
        'woocommerce_shop_page_id'      => 'Shop Page',
        'woocommerce_cart_page_id'      => 'Cart',
        'woocommerce_checkout_page_id'  => 'Checkout',
        'woocommerce_myaccount_page_id' => 'My Account'
    );

    $slider = $dir_path . 'Slider/';
    $content = $dir_path . 'Content/';
    $widget = $dir_path . 'Widget/';
    $setting = $dir_path . 'Setting/';
    $preview = $dir_url;


    $demo_data = array();

    for( $i = 1; $i <= 14; $i ++ ){
        $id = $i;
        if( $i < 10 ) {
            $id = '0'. $i;
        }
        $demo_item_name = !empty($demo_items[$i - 1]['title']) ? $demo_items[$i - 1]['title'] : 'Demo ' . $id;

        $value = array();
        $value['title']             = $demo_item_name;
        $value['category']          = 'demo';
        $value['demo_preset']       = 'home-' . $id;
        $value['demo_url']          = 'https://raz.la-studioweb.com/home-' . $id . '/';
        $value['preview']           = $preview  .   'home-' . $id . '.jpg';
        $value['option']            = $setting  .   'home-' . $id . '.json';
        $value['content']           = $content  .   'data-sample.xml';
        $value['widget']            = $widget   .   'widget.json';

        $value['pages']             = array_merge(
            $default_page,
            array(
                'page_on_front' => 'Home ' . $id
            )
        );

        $value['menu-locations']    = array_merge(
            $default_menu,
            array(

            )
        );
        $value['other_setting']    = array_merge(
            $default_image_setting,
            array(

            )
        );

        if( $i != 4 && $i != 6 && $i != 7 && $i != 9 && $i != 13 && $i != 14 ){
            $value['slider']  = $slider   .   'home-'. $id .'.zip';
        }
        if( $i == 11 ) {
            $value['slider']  = $slider   .   'slider-11.zip';
        }

        $demo_data['home-'. $id] = $value;
    }

//    if(class_exists('LAHB_Helper')){
//        $header_presets = LAHB_Helper::getHeaderDefaultData();
//
//        $header_01 = json_decode($header_presets['pre-header-01']['data'], true);
//        $header_02 = json_decode($header_presets['pre-header-02']['data'], true);
//        $header_03 = json_decode($header_presets['pre-header-03']['data'], true);
//        $header_04 = json_decode($header_presets['pre-header-04']['data'], true);
//        $header_05 = json_decode($header_presets['pre-header-05']['data'], true);
//        $header_06 = json_decode($header_presets['pre-header-06']['data'], true);
//        $header_07 = json_decode($header_presets['pre-header-07']['data'], true);
//        $header_08 = json_decode($header_presets['pre-header-08']['data'], true);
//        $header_09 = json_decode($header_presets['pre-header-09']['data'], true);
//        $header_10 = json_decode($header_presets['pre-header-toggle-01']['data'], true);
//        $header_11 = json_decode($header_presets['pre-header-vertical-simple-01']['data'], true);
//        $header_12 = json_decode($header_presets['pre-header-vertical-simple-02']['data'], true);
//        $header_13 = json_decode($header_presets['pre-header-vertical-simple-03']['data'], true);
//        $header_14 = json_decode($header_presets['pre-header-vertical-simple-04']['data'], true);
//
//
//
//        $demo_data['home-01']['other_setting'] = $header_14;
//        $demo_data['home-02']['other_setting'] = $header_02;
//        $demo_data['home-03']['other_setting'] = $header_01;
//        $demo_data['home-04']['other_setting'] = $header_03;
//        $demo_data['home-05']['other_setting'] = $header_04;
//        $demo_data['home-06']['other_setting'] = $header_05;
//        $demo_data['home-07']['other_setting'] = $header_11;
//        $demo_data['home-08']['other_setting'] = $header_10;
//        $demo_data['home-09']['other_setting'] = $header_01;
//        $demo_data['home-10']['other_setting'] = $header_01;
//        $demo_data['home-11']['other_setting'] = $header_12;
//        $demo_data['home-12']['other_setting'] = $header_13;
//        $demo_data['home-13']['other_setting'] = $header_06;
//        $demo_data['home-14']['other_setting'] = $header_07;
//    }

    return $demo_data;
}