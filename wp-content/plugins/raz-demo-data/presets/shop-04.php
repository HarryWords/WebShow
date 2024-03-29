<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_shop_04()
{
    return array(

        array(
            'key' => 'layout_archive_product',
            'value' => 'col-1c'
        ),

        array(
            'key' => 'header_transparency',
            'value' => 'no'
        ),

        array(
            'key' => 'main_full_width_archive_product',
            'value' => 'yes'
        ),

        array(
            'key' => 'product_per_page_allow',
            'value' => ''
        ),

        array(
            'key' => 'product_per_page_default',
            'value' => 12
        ),

        array(
            'key' => 'shop_catalog_display_type',
            'value' => 'grid'
        ),
        array(
            'key' => 'shop_catalog_grid_style',
            'value' => '7'
        ),
        array(
            'key' => 'active_shop_masonry',
            'value' => 'on'
        ),
        array(
            'key' => 'product_masonry_container_width',
            'value' => 1435
        ),
        array(
            'key' => 'product_masonry_item_width',
            'value' => 425
        ),
        array(
            'key' => 'product_masonry_item_height',
            'value' => 430
        ),
        array(
            'key' => 'shop_item_space',
            'value' => 80
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
                            'size_name' => '1x Width + 0.85x Height',
                            'w' => '1',
                            'h' => '0.95',
                        ),
                    2 =>
                        array (
                            'size_name' => '1x Width + 1x Height',
                            'w' => '1',
                            'h' => '0.8',
                        ),
                    3 =>
                        array (
                            'size_name' => '1x Width + 0.85x Height',
                            'w' => '1',
                            'h' => '1',
                        ),
                    4 =>
                        array (
                            'size_name' => '1x Width + 0.85x Height',
                            'w' => '1',
                            'h' => '1.1',
                        ),
                    5 =>
                        array (
                            'size_name' => '1x Width + 1x Height',
                            'w' => '1',
                            'h' => '0.9',
                        ),
                    6 =>
                        array (
                            'size_name' => '1x Width + 1x Height',
                            'w' => '1',
                            'h' => '0.9',
                        ),
                    7 =>
                        array (
                            'size_name' => '1x Width + 0.85x Height',
                            'w' => '1',
                            'h' => '1',
                        ),
                    8 =>
                        array (
                            'size_name' => '1x Width + 1.5x Height',
                            'w' => '1',
                            'h' => '1.2',
                        ),
                    9 =>
                        array (
                            'size_name' => '2x Width + 2x Height',
                            'w' => '1',
                            'h' => '1.1',
                        ),
                    10 =>
                        array (
                            'size_name' => '1x Width + 2x Height',
                            'w' => '1',
                            'h' => '1',
                        ),
                    11 =>
                        array (
                            'size_name' => '1x Width + 1.5x Height',
                            'w' => '1',
                            'h' => '0.85',
                        ),
                    12 =>
                        array (
                            'size_name' => '1x Width + 1.5x Height',
                            'w' => '1',
                            'h' => '0.9',
                        ),
                    13 =>
                        array (
                            'size_name' => '1x Width + 1.5x Height',
                            'w' => '1',
                            'h' => '1.2',
                        ),
                    14 =>
                        array (
                            'size_name' => '1x Width + 1.5x Height',
                            'w' => '1',
                            'h' => '1.2',
                        ),
                    15 =>
                        array (
                            'size_name' => '1x Width + 1.5x Height',
                            'w' => '1',
                            'h' => '1.05',
                        ),
                )

        ),


        array(
            'key' => 'woocommerce_shop_masonry_custom_columns',
            'value' => array(
                'md' => 2,
                'sm' => 2,
                'xs' => 1,
                'mb' => 1
            )
        ),

        array(
            'filter_name' => 'raz/filter/page_title',
            'value' => '<header><h1 class="page-title">Shop Mansory</h1></header>'
        ),

        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                    .product_item.grid-item{
                        padding-bottom: 0 !important;
                        padding-top: 0 !important;
                    }
                    .la-shop-products .la-pagination{
                        margin-top: 80px;
                    }
                    @media(max-width: 1200px){
                        .grid-space-80 {
                            margin-left: -15px;
                            margin-right: -15px;
                        }
                        .product_item.grid-item {
                            padding-left: 15px !important;
                            padding-right: 15px !important;
                        }
                    }
                    @media(min-width: 1400px){
                        .site-main .container{
                            max-width: 1435px;
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