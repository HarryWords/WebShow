<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_home_10()
{
    return array(
        array(
            'key' => 'header_layout',
            'value' => 'pre-header-05'
        ),

        array(
            'key' => 'header_transparency',
            'value' => 'no'
        ),

        array(
            'key' => 'body_boxed',
            'value' => 'yes'
        ),

        array(
            'key' => 'body_background',
            'value' => array(
                'color' => '#F9F9F9'
            )
        ),
        array(
            'key' => 'body_boxed_background',
            'value' => array(
                'color' => '#ffffff'
            )
        ),
        array(
            'key' => 'body_max_width',
            'value' => '1370px'
        ),
    );
}