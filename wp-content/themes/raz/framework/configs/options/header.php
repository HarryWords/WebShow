<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}


/**
 * Header settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function raz_options_section_header($sections)
{
    $header_opts = array();

    if(class_exists('LAHB')){
        $header_opts[] = array(
            'type'    => 'content',
            'class'   => 'info',
            'content' => sprintf(
                '<a class="button button-primary" href="%s"><i class="dashicons dashicons-external"></i>%s</a>',
                add_query_arg('page', 'lastudio_header_builder_setting', admin_url('themes.php')),
                esc_html__('Open Header Builder', 'raz')
            )
        );
    }

    $header_opts[] = array(
        'id' => 'header_transparency',
        'type' => 'radio',
        'default' => 'no',
        'class' => 'la-radio-style',
        'title' => esc_html_x('Header Transparency', 'admin-view', 'raz'),
        'options' => Raz_Options::get_config_radio_opts(false)
    );

    $header_opts[] = array(
        'id' => 'header_sticky',
        'type' => 'radio',
        'default' => 'no',
        'class' => 'la-radio-style',
        'title' => esc_html_x('Enable Header Sticky', 'admin-view', 'raz'),
        'options' => array(
            'no' => esc_html_x('Disable', 'admin-view', 'raz'),
            'auto' => esc_html_x('Activate when scroll up', 'admin-view', 'raz'),
            'yes' => esc_html_x('Activate when scroll up & down', 'admin-view', 'raz')
        )
    );

    $sections['header'] = array(
        'name' => 'header_panel',
        'title' => esc_html_x('Header', 'admin-view', 'raz'),
        'icon' => 'fa fa-arrow-up',
        'sections' => array(
            array(
                'name' => 'header_layout_sections',
                'title' => esc_html_x('General', 'admin-view', 'raz'),
                'icon' => 'fa fa-cog',
                'fields' => $header_opts
            ),

            array(
                'name' => 'header_mobile_styling_sections',
                'title' => esc_html_x('Mobile Footer Bar', 'admin-view', 'raz'),
                'icon' => 'fa fa-paint-brush',
                'fields' => array(
                    array(
                        'id' => 'enable_header_mb_footer_bar',
                        'type' => 'radio',
                        'default' => 'no',
                        'class' => 'la-radio-style',
                        'title' => esc_html_x('Enable Mobile Footer Bar?', 'admin-view', 'raz'),
                        'options' => array(
                            'no' => esc_html_x('Hide', 'admin-view', 'raz'),
                            'yes' => esc_html_x('Yes', 'admin-view', 'raz')
                        )
                    ),

                    array(
                        'id' => 'header_mb_footer_bar_component',
                        'type' => 'group',
                        'wrap_class' => 'group-disable-clone',
                        'title' => esc_html_x('Header Mobile Footer Bar Component', 'admin-view', 'raz'),
                        'button_title' => esc_html_x('Add Icon Component ', 'admin-view', 'raz'),
                        'dependency' => array('enable_header_mb_footer_bar_yes', '==', true),
                        'accordion_title' => 'type',
                        'max_item' => 4,
                        'fields' => array(
                            array(
                                'id' => 'type',
                                'type' => 'select',
                                'title' => esc_html_x('Type', 'admin-view', 'raz'),
                                'options' => array(
                                    'dropdown_menu' => esc_html_x('Dropdown Menu', 'admin-view', 'raz'),
                                    'text' => esc_html_x('Custom Text', 'admin-view', 'raz'),
                                    'link_icon' => esc_html_x('Icon with link', 'admin-view', 'raz'),
                                    'search_1' => esc_html_x('Search box style 01', 'admin-view', 'raz'),
                                    'cart' => esc_html_x('Cart Icon', 'admin-view', 'raz'),
                                    'wishlist' => esc_html_x('Wishlist Icon', 'admin-view', 'raz'),
                                    'compare' => esc_html_x('Compare Icon', 'admin-view', 'raz')
                                )
                            ),
                            array(
                                'id' => 'icon',
                                'type' => 'icon',
                                'default' => 'fa fa-share',
                                'title' => esc_html_x('Custom Icon', 'admin-view', 'raz'),
                                'dependency' => array('type', '!=', 'search_1|primary_menu')
                            ),
                            array(
                                'id' => 'text',
                                'type' => 'text',
                                'title' => esc_html_x('Custom Text', 'admin-view', 'raz'),
                                'dependency' => array('type', 'any', 'text,link_text')
                            ),
                            array(
                                'id' => 'link',
                                'type' => 'text',
                                'default' => '#',
                                'title' => esc_html_x('Link (URL)', 'admin-view', 'raz'),
                                'dependency' => array('type', '!=', 'search_1|primary_menu')
                            ),
                            array(
                                'id' => 'menu_id',
                                'type' => 'select',
                                'title' => esc_html_x('Select the menu', 'admin-view', 'raz'),
                                'class' => 'chosen',
                                'options' => 'tags',
                                'query_args' => array(
                                    'orderby' => 'name',
                                    'order' => 'ASC',
                                    'taxonomies' => 'nav_menu',
                                    'hide_empty' => false
                                ),
                                'dependency' => array('type', '==', 'dropdown_menu')
                            ),
                            array(
                                'id' => 'el_class',
                                'type' => 'text',
                                'default' => '',
                                'title' => esc_html_x('Extra CSS class for item', 'admin-view', 'raz')
                            )
                        )
                    ),
                    array(
                        'id' => 'enable_header_mb_footer_bar_sticky',
                        'type' => 'radio',
                        'default' => 'always',
                        'class' => 'la-radio-style',
                        'title' => esc_html_x('Header Mobile Footer Bar Sticky', 'admin-view', 'raz'),
                        'dependency' => array('enable_header_mb_footer_bar_yes', '==', true),
                        'options' => array(
                            'always' => esc_html_x('Always Display', 'admin-view', 'raz'),
                            'up' => esc_html_x('Display when scroll up', 'admin-view', 'raz'),
                            'down' => esc_html_x('Display when scroll down', 'admin-view', 'raz')
                        )
                    )
                )
            )
        )
    );
    return $sections;
}