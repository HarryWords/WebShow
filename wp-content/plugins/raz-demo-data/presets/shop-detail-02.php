<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_shop_detail_02()
{
    return array(

        array(
            'key' => 'woocommerce_product_page_design',
            'value' => '2'
        ),

        array(
            'key' => 'main_full_width_single_product',
            'value' => 'yes'
        )

    );
}