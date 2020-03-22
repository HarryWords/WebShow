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
function raz_metaboxes_section_member( $sections )
{
    $sections['member'] = array(
        'name'      => 'member',
        'title'     => esc_html_x('Member Information', 'admin-view', 'raz'),
        'icon'      => 'laicon-file',
        'fields'    => array(
            array(
                'id'    => 'role',
                'type'  => 'text',
                'title' => esc_html_x('Role', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'facebook',
                'type'  => 'text',
                'title' => esc_html_x('Facebook URL', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'twitter',
                'type'  => 'text',
                'title' => esc_html_x('Twitter URL', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'pinterest',
                'type'  => 'text',
                'title' => esc_html_x('Pinterest URL', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'linkedin',
                'type'  => 'text',
                'title' => esc_html_x('LinkedIn URL', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'dribbble',
                'type'  => 'text',
                'title' => esc_html_x('Dribbble URL', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'google_plus',
                'type'  => 'text',
                'title' => esc_html_x('Google Plus URL', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'youtube',
                'type'  => 'text',
                'title' => esc_html_x('Youtube URL', 'admin-view', 'raz'),
            ),
            array(
                'id'    => 'email',
                'type'  => 'text',
                'title' => esc_html_x('Email Address', 'admin-view', 'raz'),
            )
        )
    );
    return $sections;
}