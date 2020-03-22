<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_shop_02()
{
    return array(

        array(
            'key' => 'layout_archive_product',
            'value' => 'col-2cl'
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
            'key' => 'shop_sidebar',
            'value' => 'raz_widget_area_1'
        ),
        array(
            'key' => 'product_per_page_default',
            'value' => '12'
        ),


        array(
            'key' => 'woocommerce_shop_page_columns',
            'value' => array(
                'xlg' => 4,
                'lg' => 3,
                'md' => 2,
                'sm' => 2,
                'xs' => 2,
                'mb' => 1
            )
        ),

        array(
            'filter_name' => 'raz/filter/page_title',
            'value' => '<header><h1 class="page-title">Shop Left Sidebar</h1></header>'
        ),

        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                            
                            .la-shop-products .la-pagination ul {
                                text-align: left;
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