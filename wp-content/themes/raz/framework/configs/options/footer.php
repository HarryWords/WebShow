<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Footer settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function raz_options_section_footer( $sections )
{
    $footer_link = sprintf('<a href="%s">%s</a>', add_query_arg(array('post_type' => 'elementor_library', 'elementor_library_type' => 'footer'), admin_url('edit.php')), esc_html__('here', 'raz'));
    $sections['footer'] = array(
        'name'          => 'footer_panel',
        'title'         => esc_html_x('Footer', 'admin-view', 'raz'),
        'icon'          => 'fa fa-arrow-down',
        'sections' => array(
            array(
                'name'      => 'footer_layout_sections',
                'title'     => esc_html_x('Layout', 'admin-view', 'raz'),
                'icon'      => 'fa fa-cog fa-spin',
                'fields'    => array(
                    array(
                        'id'        => 'footer_layout',
                        'type'      => 'select',
                        'class'         => 'chosen',
                        'default'   => '',
                        'title'     => esc_html_x('Footer Layout', 'admin-view', 'raz'),
                        'default_option' => esc_html_x('Select a layout', 'admin-view', 'raz'),
                        'options'   => Raz_Options::get_config_footer_layout_opts(),
                        'desc'          => sprintf(__('You can manage footer layout on %s', 'raz'), $footer_link ),
                    )
                )
            )
        )
    );
    return $sections;
}