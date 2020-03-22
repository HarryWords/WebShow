<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_shop_05()
{
    return array(

        array(
            'key' => 'layout_archive_product',
            'value' => 'col-1c'
        ),

        array(
            'key' => 'main_full_width_archive_product',
            'value' => 'yes'
        ),
        array(
            'key' => 'shop_sidebar',
            'value' => 'raz_widget_area_2'
        ),

        array(
            'key' => 'product_per_page_allow',
            'value' => ''
        ),

        array(
            'key' => 'product_per_page_default',
            'value' => 10
        ),

        array(
            'key' => 'shop_catalog_display_type',
            'value' => 'grid'
        ),
        array(
            'key' => 'shop_catalog_grid_style',
            'value' => '5'
        ),
        array(
            'key' => 'active_shop_masonry',
            'value' => 'on'
        ),
        array(
            'key' => 'product_masonry_container_width',
            'value' => 1760
        ),
        array(
            'key' => 'product_masonry_item_width',
            'value' => 540
        ),
        array(
            'key' => 'product_masonry_item_height',
            'value' => 706
        ),
        array(
            'key' => 'shop_masonry_column_type',
            'value' => 'custom'
        ),
        array(
            'key' => 'enable_shop_masonry_custom_setting',
            'value' => 'on'
        ),
        array(
            'key' => 'shop_masonry_item_setting',
            'value' =>
                array (
                    1 =>
                        array (
                            'size_name' => '1x Width + 1x Height',
                            'w' => '1',
                            'h' => '1',
                        ),
                    2 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                    3 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                    4 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                    5 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                    6 =>
                        array (
                            'size_name' => '1x Width + 0.8x Height',
                            'w' => '2',
                            'h' => '0.8',
                        ),
                    7 =>
                        array (
                            'size_name' => '2x Width + 0.8x Height',
                            'w' => '1',
                            'h' => '0.8',
                        ),
                    8 =>
                        array (
                            'size_name' => '1x Width + 0.8x Height',
                            'w' => '1',
                            'h' => '0.8',
                        ),
                    9 =>
                        array (
                            'size_name' => '1x Width + 0.8x Height',
                            'w' => '1',
                            'h' => '0.8',
                        ),
                    10 =>
                        array (
                            'size_name' => '1x Width + 0.8x Height',
                            'w' => '1',
                            'h' => '0.8',
                        ),
                    11 =>
                        array (
                            'size_name' => '1x Width + 1x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                    12 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                    13 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '1',
                        ),
                    14 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                    15 =>
                        array (
                            'size_name' => '1x Width + 0.5x Height',
                            'w' => '1',
                            'h' => '0.5',
                        ),
                )

        ),


        array(
            'key' => 'woocommerce_shop_masonry_custom_columns',
            'value' => array(
                'lg' => 2,
                'md' => 1,
                'sm' => 1,
                'xs' => 1,
                'mb' => 1
            )
        ),

        array(
            'filter_name' => 'raz/filter/page_title',
            'value' => '<header><h1 class="page-title">Shop Metro</h1></header>'
        ),

        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                    .product_item .product_item--thumbnail-holder .pic-m-fallback {
                        background-position: center top;
                    }
                    .grid-space-default .grid-item{
                         padding: 15px;
                    }
                    .grid-space-default {
                        margin-left: -5px;
                        margin-right: -5px;
                    }
                    @media(min-width: 1367px){
                        .grid-space-default .grid-item{
                            padding: 35px;
                        }
                        .grid-space-default {
                            margin-left: -25px;
                            margin-right: -25px;
                        }
                    }
                    
                    .wc-toolbar-container {
                        padding-left: 25px;
                        padding-right: 25px;
                    }
                    .la-shop-products .la-pagination{
                        margin-top: 80px;
                    }
                    @media (max-width: 1200px){
                        .grid-items .grid-item{
                            padding-left: 10px;
                            padding-right: 10px;
                        }
                        .products-grid-5 .product_item--info{
                                padding: 20px 40px;
                        }
                        .products-grid .button .labtn-icon {
                            width: 40px;
                            height: 40px;
                            line-height: 40px;
                        }
                    }
                    @media (max-width: 767px){
                       
                        .site-main {
                            padding-top: 30px !important;
                        }
                    }
';
                }
                return $value;
            },
            'filter_priority'  => 10,
            'filter_args'  => 2
        )
    );
}