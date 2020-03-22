<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Sidebar settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function raz_options_section_sidebar( $sections )
{

    $section_fields = array();

    $section_fields[] = array(
        'name'      => 'sidebar_page_panel',
        'title'     => esc_html_x('Pages', 'admin-view', 'raz'),
        'fields'    => array(
            array(
                'id'             => 'pages_sidebar',
                'type'           => 'select',
                'title'          => esc_html_x('Global Page Sidebar', 'admin-view', 'raz'),
                'desc'           => esc_html_x('Select sidebar that will display on all pages.', 'admin-view', 'raz'),
                'class'          => 'chosen',
                'options'        => 'sidebars',
                'default_option' => esc_html_x('None', 'admin-view', 'raz')
            ),
            array(
                'id'        => 'pages_global_sidebar',
                'type'      => 'switcher',
                'default'   => false,
                'title'     => esc_html_x('Activate Global Sidebar For Pages', 'admin-view', 'raz'),
                'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all pages. This option overrides the page options.', 'admin-view', 'raz')
            )
        )
    );

    $section_fields[] = array(
        'name'      => 'sidebar_posts_panel',
        'title'     => esc_html_x('Blog Posts', 'admin-view', 'raz'),
        'fields'    => array(
            array(
                'id'             => 'posts_sidebar',
                'type'           => 'select',
                'title'          => esc_html_x('Global Blog Post Sidebar', 'admin-view', 'raz'),
                'desc'           => esc_html_x('Select sidebar that will display on all blog posts.', 'admin-view', 'raz'),
                'class'          => 'chosen',
                'options'        => 'sidebars',
                'default_option' => esc_html_x('None', 'admin-view', 'raz')
            ),
            array(
                'id'        => 'posts_global_sidebar',
                'type'      => 'switcher',
                'default'   => false,
                'title'     => esc_html_x('Activate Global Sidebar For Blog Posts', 'admin-view', 'raz'),
                'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all blog posts. This option overrides the blog post options.', 'admin-view', 'raz')
            )
        )
    );

    $section_fields[] = array(
        'name'      => 'sidebar_blog_post_panel',
        'title'     => esc_html_x('Blog Archive', 'admin-view', 'raz'),
        'fields'    => array(

            array(
                'id'             => 'blog_archive_sidebar',
                'type'           => 'select',
                'title'          => esc_html_x('Global Blog Archive Sidebar', 'admin-view', 'raz'),
                'desc'           => esc_html_x('Select sidebar that will display on all post category & tag.', 'admin-view', 'raz'),
                'class'          => 'chosen',
                'options'        => 'sidebars',
                'default_option' => esc_html_x('None', 'admin-view', 'raz')
            ),
            array(
                'id'        => 'blog_archive_global_sidebar',
                'type'      => 'switcher',
                'default'   => false,
                'title'     => esc_html_x('Activate Global Sidebar For Blog Archive', 'admin-view', 'raz'),
                'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all post category & tag. This option overrides the posts options.', 'admin-view', 'raz')
            )
        )
    );
    $section_fields[] = array(
        'name'      => 'sidebar_search_panel',
        'title'     => esc_html_x('Search Page', 'admin-view', 'raz'),
        'fields'    => array(
            array(
                'id'             => 'search_sidebar',
                'type'           => 'select',
                'title'          => esc_html_x('Search Page Sidebar', 'admin-view', 'raz'),
                'desc'           => esc_html_x('Select sidebar that will display on the search results page.', 'admin-view', 'raz'),
                'class'          => 'chosen',
                'options'        => 'sidebars',
                'default_option' => esc_html_x('None', 'admin-view', 'raz')
            )
        )
    );

    if(function_exists('WC')) {
        $section_fields[] = array(
            'name'      => 'sidebar_shop_panel',
            'title'     => esc_html_x('WooCommerce Archive', 'admin-view', 'raz'),
            'fields'    => array(
                array(
                    'id'             => 'shop_sidebar',
                    'type'           => 'select',
                    'title'          => esc_html_x('Global WooCommerce Archive Sidebar', 'admin-view', 'raz'),
                    'desc'           => esc_html_x('Select sidebar that will display on all WooCommerce taxonomy.', 'admin-view', 'raz'),
                    'class'          => 'chosen',
                    'options'        => 'sidebars',
                    'default_option' => esc_html_x('None', 'admin-view', 'raz')
                ),
                array(
                    'id'        => 'shop_global_sidebar',
                    'type'      => 'switcher',
                    'default'   => false,
                    'title'     => esc_html_x('Activate Global Sidebar For Woocommerce Archive', 'admin-view', 'raz'),
                    'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all WooCommerce archive( shop,category,tag,search ). This option overrides the WooCommerce taxonomy options.', 'admin-view', 'raz')
                )
            )
        );
        $section_fields[] = array(
            'name'      => 'sidebar_products_panel',
            'title'     => esc_html_x('WooCommerce Products', 'admin-view', 'raz'),
            'fields'    => array(
                array(
                    'id'             => 'products_sidebar',
                    'type'           => 'select',
                    'title'          => esc_html_x('Global WooCommerce Product Sidebar', 'admin-view', 'raz'),
                    'desc'           => esc_html_x('Select sidebar that will display on all WooCommerce products.', 'admin-view', 'raz'),
                    'class'          => 'chosen',
                    'options'        => 'sidebars',
                    'default_option' => esc_html_x('None', 'admin-view', 'raz')
                ),
                array(
                    'id'        => 'products_global_sidebar',
                    'type'      => 'switcher',
                    'default'   => false,
                    'title'     => esc_html_x('Activate Global Sidebar For WooCommerce Products', 'admin-view', 'raz'),
                    'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all WooCommerce products. This option overrides the WooCommerce post options.', 'admin-view', 'raz')
                )
            )
        );
    }

    $sections['sidebar'] = array(
        'name'          => 'sidebar_panel',
        'title'         => esc_html_x('Sidebars', 'admin-view', 'raz'),
        'icon'          => 'fa fa-exchange',
        'sections'      => $section_fields
    );
    return $sections;
}