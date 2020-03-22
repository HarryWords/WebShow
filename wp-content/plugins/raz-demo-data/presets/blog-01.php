<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_blog_01()
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
            'key' => 'blog_small_layout',
            'value' => 'on'
        ),

        array(
            'key' => 'blog_design',
            'value' => 'grid_2'
        ),
        array(
            'key' => 'blog_thumbnail_height_custom',
            'value' => '43%'
        ),
        array(
            'key' => 'blog_post_column',
            'value' => array(
                'xlg' => '1',
                'lg' => '1',
                'md' => '1',
                'sm' => '1',
                'xs' => '1',
                'mb' => '1'
            )
        ),
        array(
            'filter_name' => 'raz/filter/page_title',
            'value' => '<header><h1 class="page-title">Blog No Sidebar</h1></header>'
        ),
        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                    .blog__item.grid-item {
                        padding-top: 0;
                        padding-bottom: 0;
                    }
                    .la-pagination{
                        width: 875px;
                        max-width: 100%;
                        margin: 0px auto;
                    }
                    @media (min-width: 1400px){
                         body.raz-body .site-main {
                             padding-top: 120px;
                             padding-bottom: 70px;
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