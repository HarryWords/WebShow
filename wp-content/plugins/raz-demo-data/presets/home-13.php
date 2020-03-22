<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_home_13()
{
    return array(
        array(
            'key' => 'header_layout',
            'value' => 'pre-header-vertical-simple-01'
        ),

        array(
            'key' => 'header_transparency',
            'value' => 'no'
        ),

        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                                .site-footer {
                                    border-top: 1px solid #D8D8D8;
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