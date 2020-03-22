<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_blog_02()
{
    return array(

        array(
            'key' => 'header_transparency',
            'value' => 'no'
        ),
        array(
            'key' => 'layout_blog',
            'value' => 'col-1c'
        ),

        array(
            'key' => 'blog_thumbnail_height_mode',
            'value' => 'custom'
        ),
        array(
            'key' => 'blog_thumbnail_height_custom',
            'value' => '56%'
        ),
        array(
            'key' => 'blog_design',
            'value' => 'grid_3'
        ),


        array(
            'key' => 'blog_post_column',
            'value' => array(
                'xlg' => '2',
                'lg' => '2',
                'md' => '2',
                'sm' => '2',
                'xs' => '1',
                'mb' => '1'
            )
        ),

        array(
            'filter_name' => 'raz/filter/page_title',
            'value' => '<header><h1 class="page-title"> Blog 02 Columns</h1></header>'
        ),
        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                    .la-pagination {
                        text-align: center;
                    }
                    .post_format-post-format-quote .loop__item__thumbnail--bkg {
                      padding-bottom: 56% !important;
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