<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * MetaBox
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function raz_metaboxes_section_footer( $sections )
{

    $footer_link = sprintf('<a href="%s">%s</a>', add_query_arg(array('post_type' => 'elementor_library', 'elementor_library_type' => 'footer'), admin_url('edit.php')), esc_html__('here', 'raz'));

    $sections['footer'] = array(
        'name'      => 'footer',
        'title'     => esc_html_x('Footer', 'admin-view', 'raz'),
        'icon'      => 'laicon-footer',
        'fields'    => array(
            array(
                'id'            => 'hide_footer',
                'type'          => 'radio',
                'default'       => 'no',
                'class'         => 'la-radio-style',
                'title'         => esc_html_x('Hide Footer', 'admin-view', 'raz'),
                'options'       => Raz_Options::get_config_radio_opts(false)
            ),
            array(
                'id'            => 'footer_layout',
                'type'          => 'select',
                'class'         => 'chosen',
                'default'       => '',
                'title'         => esc_html_x('Footer Layout', 'admin-view', 'raz'),
                'default_option' => esc_html_x('Select a layout', 'admin-view', 'raz'),
                'options'       => Raz_Options::get_config_footer_layout_opts(),
                'desc'          => sprintf(__('You can manage footer layout on %s', 'raz'), $footer_link ),
            )
        )
    );
    return $sections;
}