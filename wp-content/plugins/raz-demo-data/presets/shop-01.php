<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_shop_01()
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
            'key' => 'shop_catalog_grid_style',
            'value' => '7'
        ),
        array(
            'key' => 'shop_item_space',
            'value' => '20'
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
                'lg' => 4,
                'md' => 2,
                'sm' => 2,
                'xs' => 2,
                'mb' => 1
            )
        ),

        array(
            'filter_name' => 'raz/filter/page_title',
            'value' => '<header><h1 class="page-title">Shop Fullwidth</h1></header>'
        ),

        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                    .section-page-header .page-title {
                        color: #262626;
                    }
                    .section-page-header,
                    .section-page-header a {
                        color: #262626;
                    }
                   
                    @media (max-width: 767px){
                        #section_page_header{
                            background-size: auto 70%;
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