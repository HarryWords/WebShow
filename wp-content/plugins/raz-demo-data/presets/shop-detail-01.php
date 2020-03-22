<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_shop_detail_01()
{
    return array(

        array(
            'key' => 'woocommerce_product_page_design',
            'value' => '1'
        ),
        
        array(
            'key' => 'main_full_width_single_product',
            'value' => 'yes'
        ),
        array(
        'filter_name' => 'raz/setting/option/get_single',
        'filter_func' => function( $value, $key ){
            if( $key == 'la_custom_css'){
                $value .= ' 
                                @media (min-width: 1400px){
                                  .body-col-1c.enable-main-fullwidth.has-single-custom-block-summary .la-custom-pright02{
                                    display: none;
                                  }
                                  .body-col-1c.enable-main-fullwidth.has-single-custom-block-summary .site-main .la-single-product-page .product-main-image{
                                    width: 56%;
                                  }
                                  .body-col-1c.enable-main-fullwidth.has-single-custom-block-summary .site-main .la-single-product-page .product--summary{
                                    width: 44%;
                                    display: flex;
                                  }
                                  .body-col-1c.enable-main-fullwidth.has-single-custom-block-summary .site-main .la-single-product-page .product--summary .la-custom-pright{
                                     padding-right: 0px;
                                  }
                              }
                        ';
            }
            return $value;
        },
        'filter_priority'  => 10,
        'filter_args'  => 2
    ),

    );
}