<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * WooCommerce settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function raz_options_section_woocommerce( $sections )
{

    if(!function_exists('WC')) return $sections;


    $fields_default = raz_get_wc_attribute_for_compare();
    $attributes = raz_get_wc_attribute_taxonomies();

    $fields = array_merge( $fields_default, $attributes );

    $sections['woocommerce'] = array(
        'name' => 'woocommerce_panel',
        'title' => esc_html_x('Shop', 'admin-view', 'raz'),
        'icon' => 'fa fa-shopping-cart',
        'sections' => array(
            array(
                'name'      => 'woocommerce_general_section',
                'title'     => esc_html_x('General Shop', 'admin-view', 'raz'),
                'icon'      => 'fa fa-check',
                'fields'    => array(
                    array(
                        'id'        => 'layout_archive_product',
                        'type'      => 'image_select',
                        'title'     => esc_html_x('WooCommerce Layout', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the layout of shop page, product category, product tags and search page', 'admin-view', 'raz'),
                        'default'   => 'col-1c',
                        'radio'     => true,
                        'options'   => Raz_Options::get_config_main_layout_opts(true, false)
                    ),
                    array(
                        'id'        => 'main_full_width_archive_product',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'inherit',
                        'title'     => esc_html_x('100% Main Width', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to have the main area display at 100% width according to the window size. Turn off to follow site width.', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts()
                    ),
                    array(
                        'id'            => 'main_space_archive_product',
                        'type'          => 'spacing',
                        'title'         => esc_html_x('Custom Main Space', 'admin-view', 'raz'),
                        'desc'          => esc_html_x('Leave empty if you not need to override', 'admin-view', 'raz'),
                        'unit' 	        => 'px'
                    ),
                    array(
                        'id'        => 'catalog_mode',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('Catalog Mode', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to disable the shopping functionality of WooCommerce.', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'catalog_mode_price',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('Catalog Mode Price', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to do not show product price', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false),
                        'dependency' => array('catalog_mode_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'active_shop_filter',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('Advanced WooCommerce Filter', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn off/on advance shop filter', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'hide_shop_toolbar',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('Hide WooCommerce Toolbar', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn off/on WooCommerce Toolbar', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'woocommerce_toggle_grid_list',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('WooCommerce Product Grid / List View', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to display the grid/list toggle on the main shop page and archive shop pages.', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'shop_catalog_display_type',
                        'default'   => 'grid',
                        'title'     => esc_html_x('Shop display as type', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the type display of product for the shop page', 'admin-view', 'raz'),
                        'type'      => 'select',
                        'options'   => array(
                            'grid'        => esc_html_x('Grid', 'admin-view', 'raz'),
                            'list'        => esc_html_x('List', 'admin-view', 'raz')
                        )
                    ),
                    array(
                        'id'        => 'shop_catalog_grid_style',
                        'default'   => '1',
                        'title'     => esc_html_x('Grid Style', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the type display of product for the shop page', 'admin-view', 'raz'),
                        'type'      => 'select',
                        'options'   => array(
                            '1'        => esc_html_x('Style 01', 'admin-view', 'raz'),
                            '2'        => esc_html_x('Style 02', 'admin-view', 'raz'),
                            '3'        => esc_html_x('Style 03', 'admin-view', 'raz'),
                            '4'        => esc_html_x('Style 04', 'admin-view', 'raz'),
                            '5'        => esc_html_x('Style 05', 'admin-view', 'raz'),
                            '6'        => esc_html_x('Style 06', 'admin-view', 'raz'),
                            '7'        => esc_html_x('Style 07', 'admin-view', 'raz')

                        )
                    ),
                    array(
                        'id'        => 'active_shop_masonry',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('Enable Shop Masonry', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn off/on Shop Masonry Mode', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),

                    array(
                        'id'        => 'shop_masonry_column_type',
                        'default'   => '1',
                        'title'     => esc_html_x('Masonry Column Type', 'admin-view', 'raz'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'        => esc_html_x('Default', 'admin-view', 'raz'),
                            'custom'         => esc_html_x('Custom', 'admin-view', 'raz')
                        ),
                        'dependency' => array('active_shop_masonry_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'product_masonry_container_width',
                        'default'   => '1170',
                        'title'     => esc_html_x('Container Width', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('This value will determine the number of items per row', 'admin-view', 'raz'),
                        'info'      => esc_html_x('Enter numeric only', 'admin-view', 'raz'),
                        'type'      => 'text',
                        'dependency' => array('shop_masonry_column_type', '==', 'custom')
                    ),
                    array(
                        'id'        => 'product_masonry_image_size',
                        'default'   => 'shop_catalog',
                        'title'     => esc_html_x('Masonry Product Image Size', 'admin-view', 'raz'),
                        'info'      => esc_html_x('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'admin-view', 'raz'),
                        'type'      => 'text',
                        'dependency' => array('shop_masonry_column_type', '==', 'custom')
                    ),
                    array(
                        'id'        => 'product_masonry_item_width',
                        'default'   => '270',
                        'title'     => esc_html_x('Item Width', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Set your product item default width', 'admin-view', 'raz'),
                        'info'      => esc_html_x('Enter numeric only', 'admin-view', 'raz'),
                        'type'      => 'text',
                        'dependency' => array('shop_masonry_column_type', '==', 'custom')
                    ),
                    array(
                        'id'        => 'product_masonry_item_height',
                        'default'   => '450',
                        'title'     => esc_html_x('Item Height', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Set your product item default height', 'admin-view', 'raz'),
                        'info'      => esc_html_x('Enter numeric only', 'admin-view', 'raz'),
                        'type'      => 'text',
                        'dependency' => array('shop_masonry_column_type', '==', 'custom')
                    ),

                    array(
                        'id'        => 'woocommerce_shop_page_columns',
                        'default'   => array(
                            'xlg' => 4,
                            'lg' => 4,
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                            'mb' => 1
                        ),
                        'title'     => esc_html_x('WooCommerce Number of Product Columns', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the number of columns for the main shop page', 'admin-view', 'raz'),
                        'type'      => 'column_responsive',
                        'dependency' => array('active_shop_masonry_off', '==', 'true')
                    ),

                    array(
                        'id'        => 'woocommerce_shop_masonry_columns',
                        'default'   => array(
                            'xlg' => 4,
                            'lg' => 4,
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                            'mb' => 1
                        ),
                        'title'     => esc_html_x('WooCommerce Number of Product Columns', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the number of columns for the main shop page', 'admin-view', 'raz'),
                        'type'      => 'column_responsive',
                        'dependency' => array('active_shop_masonry_on|shop_masonry_column_type', '==|==', 'true|default')
                    ),

                    array(
                        'id'        => 'woocommerce_shop_masonry_custom_columns',
                        'default'   => array(
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                            'mb' => 1
                        ),
                        'options'   => array(
                            'xlg' => false,
                            'lg' => false
                        ),
                        'title'     => esc_html_x('WooCommerce Number of Product Columns', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the number of columns for the main shop page', 'admin-view', 'raz'),
                        'type'      => 'column_responsive',
                        'dependency' => array('active_shop_masonry_on|shop_masonry_column_type', '==|==', 'true|custom')
                    ),

                    array(
                        'id'        => 'enable_shop_masonry_custom_setting',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('Enable Custom Item Settings', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false),
                        'dependency' => array('active_shop_masonry_on|shop_masonry_column_type', '==|==', 'true|custom')
                    ),
                    array(
                        'id'        => 'shop_masonry_item_setting',
                        'type'      => 'group',
                        'title'     => esc_html_x('Add Item Sizes', 'admin-view', 'raz'),
                        'button_title'    => esc_html_x('Add','admin-view', 'raz'),
                        'accordion_title' => 'size_name',
                        'default'   => array(
                            array(
                                'size_name' => esc_html_x('1x Width + 1x Height', 'admin-view', 'raz'),
                                'width' => 1,
                                'height' => 1
                            )
                        ),
                        'fields'    => array(
                            array(
                                'id'        => 'size_name',
                                'type'      => 'text',
                                'default'   => esc_html_x('1x Width + 1x Height', 'admin-view', 'raz'),
                                'title'     => esc_html_x('Size Name', 'admin-view', 'raz')
                            ),
                            array(
                                'id'        => 'w',
                                'default'   => '1',
                                'title'     => esc_html_x('Width', 'admin-view', 'raz'),
                                'info'      => esc_html_x('it will occupy x width of base item width ( example: this item will be occupy 2x width of base width you need entered "2")', 'admin-view', 'raz'),
                                'type'      => 'select',
                                'options'   => array(
                                    '0.5'      => esc_html_x('0.5x width', 'admin-view', 'raz'),
                                    '1'        => esc_html_x('1x width', 'admin-view', 'raz'),
                                    '1.5'      => esc_html_x('1.5x width', 'admin-view', 'raz'),
                                    '2'        => esc_html_x('2x width', 'admin-view', 'raz'),
                                    '2.5'      => esc_html_x('2.5x width', 'admin-view', 'raz'),
                                    '3'        => esc_html_x('3x width', 'admin-view', 'raz'),
                                    '3.5'      => esc_html_x('3.5x width', 'admin-view', 'raz'),
                                    '4'        => esc_html_x('4x width', 'admin-view', 'raz')
                                )
                            ),
                            array(
                                'id'        => 'h',
                                'default'   => '1',
                                'title'     => esc_html_x('Height', 'admin-view', 'raz'),
                                'info'      => esc_html_x('it will occupy x height of base item height ( example: this item will be occupy 2x height of base height you need entered "2")', 'admin-view', 'raz'),
                                'type'      => 'select',
                                'options'   => array(
                                    '0.5'      => esc_html_x('0.5x height', 'admin-view', 'raz'),
                                    '1'        => esc_html_x('1x height', 'admin-view', 'raz'),
                                    '1.5'      => esc_html_x('1.5x height', 'admin-view', 'raz'),
                                    '2'        => esc_html_x('2x height', 'admin-view', 'raz'),
                                    '2.5'      => esc_html_x('2.5x height', 'admin-view', 'raz'),
                                    '3'        => esc_html_x('3x height', 'admin-view', 'raz'),
                                    '3.5'      => esc_html_x('3.5x height', 'admin-view', 'raz'),
                                    '4'        => esc_html_x('4x height', 'admin-view', 'raz')
                                )
                            )
                        ),
                        'dependency' => array('active_shop_masonry_on|shop_masonry_column_type|enable_shop_masonry_custom_setting_on', '==|==|==', 'true|custom|true')
                    ),

                    array(
                        'id'        => 'shop_item_space',
                        'default'   => 'default',
                        'title'     => esc_html_x('Shop Item Space', 'admin-view', 'raz'),
                        'type'      => 'select',
                        'options'   => array(
                            'default'    => esc_html_x('Default', 'admin-view', 'raz'),
                            'zero'       => esc_html_x('0px', 'admin-view', 'raz'),
                            '5'          => esc_html_x('5px', 'admin-view', 'raz'),
                            '10'         => esc_html_x('10px', 'admin-view', 'raz'),
                            '15'         => esc_html_x('15px', 'admin-view', 'raz'),
                            '20'         => esc_html_x('20px', 'admin-view', 'raz'),
                            '25'         => esc_html_x('25px', 'admin-view', 'raz'),
                            '30'         => esc_html_x('30px', 'admin-view', 'raz'),
                            '35'         => esc_html_x('35px', 'admin-view', 'raz'),
                            '40'         => esc_html_x('40px', 'admin-view', 'raz'),
                            '45'         => esc_html_x('45px', 'admin-view', 'raz'),
                            '50'         => esc_html_x('50px', 'admin-view', 'raz'),
                            '55'         => esc_html_x('55px', 'admin-view', 'raz'),
                            '60'         => esc_html_x('60px', 'admin-view', 'raz'),
                            '65'         => esc_html_x('65px', 'admin-view', 'raz'),
                            '70'         => esc_html_x('70px', 'admin-view', 'raz'),
                            '75'         => esc_html_x('75px', 'admin-view', 'raz'),
                            '80'         => esc_html_x('80px', 'admin-view', 'raz'),
                        )
                    ),

                    array(
                        'id'        => 'product_per_page_allow',
                        'default'   => '12,15,30',
                        'title'     => esc_html_x('WooCommerce Number of Products per Page Allow', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the number of products that display per page.', 'admin-view', 'raz'),
                        'info'      => esc_html_x('Comma-separated. ( i.e: 3,6,9)', 'admin-view', 'raz'),
                        'type'      => 'text'
                    ),
                    array(
                        'id'        => 'product_per_page_default',
                        'default'   => 12,
                        'title'     => esc_html_x('WooCommerce Number of Products per Page', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('The value of field must be as one value of setting above', 'admin-view', 'raz'),
                        'type'      => 'number',
                        'attributes'=> array(
                            'min' => 1,
                            'max' => 100
                        )
                    ),

                    array(
                        'id'        => 'woocommerce_pagination_type',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'pagination',
                        'title'     => esc_html_x('WooCommerce Pagination Type', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the pagination type for the assigned shop pages', 'admin-view', 'raz'),
                        'options'   => array(
                            'pagination' => esc_html_x('Pagination', 'admin-view', 'raz'),
                            'infinite_scroll' => esc_html_x('Infinite Scroll', 'admin-view', 'raz'),
                            'load_more' => esc_html_x('Load More Button', 'admin-view', 'raz')
                        )
                    ),

                    array(
                        'id'        => 'woocommerce_load_more_text',
                        'type'      => 'text',
                        'default'   => 'Load More Products',
                        'title'     => esc_html_x('Load More Button Text', 'admin-view', 'raz'),
                        'dependency'=> array('woocommerce_pagination_type_load_more', '==', true)
                    ),

                    array(
                        'id'        => 'woocommerce_enable_crossfade_effect',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('WooCommerce Crossfade Image Effect', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to display the product crossfade image effect on the product.', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),

                    array(
                        'id'        => 'woocommerce_show_rating_on_catalog',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('WooCommerce Show Ratings', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to display the ratings on the main shop page and archive shop pages.', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'woocommerce_show_addcart_btn',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('WooCommerce Show Add Cart Button', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'woocommerce_show_quickview_btn',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('WooCommerce Show Quick View Button', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'woocommerce_show_wishlist_btn',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('WooCommerce Show Wishlist Button', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'woocommerce_show_compare_btn',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('WooCommerce Show Compare Button', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    )
                )
            ),
            array(
                'name'      => 'woocommerce_single_section',
                'title'     => esc_html_x('Product Page Settings', 'admin-view', 'raz'),
                'icon'      => 'fa fa-check',
                'fields'    => array(
                    array(
                        'id'        => 'layout_single_product',
                        'type'      => 'image_select',
                        'radio'     => true,
                        'title'     => esc_html_x('Product Page Layout', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the layout for detail product page', 'admin-view', 'raz'),
                        'default'   => 'col-1c',
                        'options'   => Raz_Options::get_config_main_layout_opts(true, false)
                    ),
                    array(
                        'id'        => 'main_full_width_single_product',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'inherit',
                        'title'     => esc_html_x('100% Main Width', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to have the main area display at 100% width according to the window size. Turn off to follow site width.', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts()
                    ),

                    array(
                        'id'            => 'main_space_single_product',
                        'type'          => 'spacing',
                        'title'         => esc_html_x('Custom Main Space', 'admin-view', 'raz'),
                        'desc'          => esc_html_x('Leave empty if you not need to override', 'admin-view', 'raz'),
                        'unit' 	        => 'px'
                    ),

                    array(
                        'id'        => 'woocommerce_product_page_design',
                        'title'     => esc_html_x('Product Page Design', 'admin-view', 'raz'),
                        'type'      => 'image_select',
                        'radio'     => true,
                        'wrap_class'=> 'specificity_image_select',
                        'default'   => '1',
                        'options'   => array(
                            '1'     => esc_url( Raz::$template_dir_url . '/assets/images/theme_options/single-product-layout-1.jpg'),
                            '2'     => esc_url( Raz::$template_dir_url . '/assets/images/theme_options/single-product-layout-2.jpg'),
                            '3'     => esc_url( Raz::$template_dir_url . '/assets/images/theme_options/single-product-layout-3.jpg'),
                            '4'     => esc_url( Raz::$template_dir_url . '/assets/images/theme_options/single-product-layout-4.jpg')
                        )
                    ),

                    array(
                        'id'        => 'single_ajax_add_cart',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html_x('Ajax Add to Cart', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Support Ajax Add to cart for all types of products', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'move_woo_tabs_to_bottom',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html_x('Move WooCommerce Tabs To Bottom', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'woocommerce_gallery_zoom',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html_x('Enable WooCommerce Zoom', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'woocommerce_gallery_lightbox',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html_x('Enable WooCommerce LightBox', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'product_single_hide_breadcrumb',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html__('Hide Breadcrumbs', 'raz'),
                        'desc'      => esc_html__('In Page Title Bar', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'product_single_hide_page_title',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html__('Hide Page Title', 'raz'),
                        'desc'      => esc_html__('In Page Title Bar', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'product_single_hide_product_title',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html__('Hide Product Title', 'raz'),
                        'options'   => Raz_Options::get_config_radio_opts(false)
                    ),

                    array(
                        'id'        => 'product_gallery_column',
                        'title'     => esc_html_x('Product gallery columns', 'admin-view', 'raz'),
                        'default'   => array(
                            'xlg' => 3,
                            'lg' => 3,
                            'md' => 3,
                            'sm' => 5,
                            'xs' => 4,
                            'mb' => 3
                        ),
                        'type'      => 'column_responsive',
                    ),

                    array(
                        'id'        => 'product_sharing',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('Product Sharing Option', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to show social sharing on the product page', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'related_products',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('WooCommerce Related Products', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to show related products on the product page', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'related_product_title',
                        'type'      => 'text',
                        'title'     => esc_html_x('WooCommerce Related Title','admin-view', 'raz'),
                        'dependency'=> array('related_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'related_product_subtitle',
                        'type'      => 'text',
                        'title'     => esc_html_x('WooCommerce Related Sub Title','admin-view', 'raz'),
                        'dependency'=> array('related_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'related_products_columns',
                        'default'   => array(
                            'xlg' => 4,
                            'lg' => 4,
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                            'mb' => 1
                        ),
                        'title'     => esc_html_x('WooCommerce Related Product Number of Columns', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the number of columns for the related', 'admin-view', 'raz'),
                        'type'      => 'column_responsive',
                        'dependency' => array('related_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'upsell_products',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('WooCommerce Up-sells Products', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to show Up-sells products on the product page', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'upsell_product_title',
                        'type'      => 'text',
                        'title'     => esc_html_x('WooCommerce Up-sells Title','admin-view', 'raz'),
                        'dependency'=> array('upsell_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'upsell_product_subtitle',
                        'type'      => 'text',
                        'title'     => esc_html_x('WooCommerce Up-sells Sub Title','admin-view', 'raz'),
                        'dependency'=> array('upsell_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'upsell_products_columns',
                        'default'   => array(
                            'xlg' => 4,
                            'lg' => 4,
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                            'mb' => 1
                        ),
                        'title'     => esc_html_x('WooCommerce Up-sells Product Number of Columns', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the number of columns for the Up-sells', 'admin-view', 'raz'),
                        'type'      => 'column_responsive',
                        'dependency' => array('upsell_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'woo_enable_custom_tab',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('Custom Tabs Detail Page', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to show custom tabs on the product page', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'woo_custom_tab_title',
                        'type'      => 'text',
                        'title'     => esc_html_x('Custom Tab Title','admin-view', 'raz'),
                        'dependency'=> array('woo_enable_custom_tab_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'woo_custom_tab_content',
                        'type'      => 'wp_editor',
                        'title'     => esc_html_x('Custom Tab Content', 'admin-view', 'raz'),
                        'dependency'=> array('woo_enable_custom_tab_on', '==', 'true'),
                    ),
                    array(
                        'id'        => 'woo_custom_tab_title_2',
                        'type'      => 'text',
                        'title'     => esc_html_x('Custom Tab Title 02','admin-view', 'raz'),
                        'dependency'=> array('woo_enable_custom_tab_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'woo_custom_tab_content_2',
                        'type'      => 'wp_editor',
                        'title'     => esc_html_x('Custom Tab Content 02', 'admin-view', 'raz'),
                        'dependency'=> array('woo_enable_custom_tab_on', '==', 'true'),
                    ),
                    array(
                        'id'        => 'woo_custom_tab_title_3',
                        'type'      => 'text',
                        'title'     => esc_html_x('Custom Tab Title 03','admin-view', 'raz'),
                        'dependency'=> array('woo_enable_custom_tab_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'woo_custom_tab_content_3',
                        'type'      => 'wp_editor',
                        'title'     => esc_html_x('Custom Tab Content 03', 'admin-view', 'raz'),
                        'dependency'=> array('woo_enable_custom_tab_on', '==', 'true'),
                    )
                )
            ),
            array(
                'name'      => 'woocommerce_cart_section',
                'title'     => esc_html_x('Cart Page Settings', 'admin-view', 'raz'),
                'icon'      => 'fa fa-shopping-cart',
                'fields'    => array(
                    array(
                        'id'        => 'crosssell_products',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('WooCommerce Cross-sells Products', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Turn on to show Cross-sells products on the product page', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'        => 'crosssell_product_title',
                        'type'      => 'text',
                        'title'     => esc_html_x('WooCommerce Cross-sells Title','admin-view', 'raz'),
                        'dependency'=> array('crosssell_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'crosssell_product_subtitle',
                        'type'      => 'text',
                        'title'     => esc_html_x('WooCommerce Cross-sells Sub Title','admin-view', 'raz'),
                        'dependency'=> array('crosssell_products_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'crosssell_products_columns',
                        'default'   => array(
                            'xlg' => 4,
                            'lg' => 4,
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                            'mb' => 1
                        ),
                        'title'     => esc_html_x('WooCommerce Cross-sells Product Number of Columns', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Controls the number of columns for the Cross-sells', 'admin-view', 'raz'),
                        'type'      => 'column_responsive',
                        'dependency' => array('crosssell_products_on', '==', 'true')
                    )
                )
            ),
            array(
                'name'      => 'woocommerce_wishlist_section',
                'title'     => esc_html_x('Wishlist', 'admin-view', 'raz'),
                'icon'      => 'fa fa-heart',
                'fields'    => array(
                    array(
                        'id'        => 'wishlist_page',
                        'type'      => 'select',
                        'title'     => esc_html_x('Wishlist Page', 'admin-view', 'raz'),
                        'options'   => 'pages',
                        'desc'      => esc_html_x('The content of page must be contain [la_wishlist] shortcode', 'admin-view', 'raz'),
                        'query_args'    => array(
                            'posts_per_page'  => -1
                        ),
                        'default_option' => esc_html_x('Select a page', 'admin-view', 'raz')
                    )
                )
            ),
            array(
                'name'      => 'woocommerce_compare_section',
                'title'     => esc_html_x('Compare', 'admin-view', 'raz'),
                'icon'      => 'fa fa-exchange',
                'fields'    => array(
                    array(
                        'id'        => 'compare_page',
                        'type'      => 'select',
                        'title'     => esc_html_x('Compare Page', 'admin-view', 'raz'),
                        'options'   => 'pages',
                        'desc'      => esc_html_x('The content of page must be contain [la_compare] shortcode', 'admin-view', 'raz'),
                        'query_args'    => array(
                            'posts_per_page'  => -1
                        ),
                        'default_option' => esc_html_x('Select a page', 'admin-view', 'raz')
                    ),
                    array(
                        'id'       => 'compare_attribute',
                        'type'     => 'checkbox',
                        'title'    => esc_html_x('Fields to show', 'admin-view', 'raz'),
                        'desc'      => esc_html_x('Select the fields to show in the comparison table', 'admin-view', 'raz'),
                        'options'  => $fields,
                        'default'  => array_keys($fields_default)
                    ),
                )
            ),
        )
    );
    return $sections;
}