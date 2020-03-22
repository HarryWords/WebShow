<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_home_05()
{
    return array(

        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),
        array(
            'key' => 'body_background',
            'value' => array(
                'color' => '#f9f9f9'
            )
        ),

        array(
            'key' => 'header_layout',
            'value' => 'pre-header-02'
        ),
    );
}