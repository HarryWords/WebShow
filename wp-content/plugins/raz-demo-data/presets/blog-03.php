<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_raz_preset_blog_03()
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
            'key' => 'blog_design',
            'value' => 'grid_1'
        ),
        array(
            'key' => 'blog_thumbnail_height_mode',
            'value' => 'original'
        ),
        array(
            'key' => 'blog_thumbnail_size',
            'value' => 'full'
        ),
        array(
            'key' => 'blog_masonry',
            'value' => 'on'
        ),
        array(
            'key' => 'blog_excerpt_length',
            'value' => '18'
        ),
        array(
            'key' => 'blog_post_column',
            'value' => array(
                'xlg' => '3',
                'lg' => '3',
                'md' => '2',
                'sm' => '2',
                'xs' => '1',
                'mb' => '1'
            )
        ),
        array(
            'filter_name' => 'raz/filter/page_title',
            'value' => '<header><h1 class="page-title"> Blog Mansory</h1></header>'
        ),

        array(
            'filter_name' => 'raz/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
                            .gitem-zone-height-mode-auto img {
                                display: block !important;
                            }
                            .la-pagination ul{
                                text-align: center;
                                    margin-top: 60px;
                            }   
                            
                            .post_format-post-format-quote .loop__item__thumbnail--bkg {
                                  padding-bottom: 56% !important;
                                }
                                        
                            .blog__item.grid-item {
                                padding-top: 0;
                                padding-bottom: 0;
                            }
                            .grid-items .grid-item{
                                padding-left: 35px;
                                padding-right: 35px;
                            }
                            @media (min-width: 1400px){
                                .container {
                                    width: 100%;
                                    padding-left: 60px;
                                    padding-right: 60px;
                                }
                            }
                            @media (max-width: 991px){
                                .grid-items .grid-item {
                                     padding-left: 15px;
                                    padding-right: 15px;
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