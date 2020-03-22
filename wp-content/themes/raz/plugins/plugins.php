<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'tgmpa_register', 'raz_register_required_plugins' );

if(!function_exists('raz_register_required_plugins')){

	function raz_register_required_plugins() {

		$plugins = array();

        $plugins[] = array(
            'name'					=> esc_html_x('LA-Studio Core', 'admin-view', 'raz'),
            'slug'					=> 'lastudio',
            'source'				=> get_template_directory() . '/plugins/lastudio.zip',
            'required'				=> true,
            'version'				=> '2.0.0'
        );

        $plugins[] = array(
            'name'					=> esc_html_x('LA-Studio Header Builder', 'admin-view', 'raz'),
            'slug'					=> 'lastudio-header-builders',
            'source'				=> get_template_directory() . '/plugins/lastudio-header-builders.zip',
            'required'				=> true,
            'version'				=> '1.1'
        );

		$plugins[] = array(
            'name' 					=> esc_html_x('Elementor Page Builder', 'admin-view', 'raz'),
            'slug' 					=> 'elementor',
            'required' 				=> true,
            'version'				=> '2.5.14'
        );

        $plugins[] = array(
            'name'					=> esc_html_x('LaStudio Elements For Elementor', 'admin-view', 'raz'),
            'slug'					=> 'lastudio-elements',
            'source'				=> get_template_directory() . '/plugins/lastudio-elements.zip',
            'required'				=> true,
            'version'				=> '1.0.2.4'
        );

		$plugins[] = array(
			'name'     				=> esc_html_x('WooCommerce', 'admin-view', 'raz'),
			'slug'     				=> 'woocommerce',
			'version'				=> '3.6.2',
			'required' 				=> false
		);

		$plugins[] = array(
			'name'     				=> esc_html_x('Envato Market', 'admin-view', 'raz'),
			'slug'     				=> 'envato-market',
            'source'				=> 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'required' 				=> false,
			'version' 				=> '2.0.1'
		);

        $plugins[] = array(
            'name'					=> esc_html_x('Raz Package Demo Data', 'admin-view', 'raz'),
            'slug'					=> 'raz-demo-data',
            'source'				=> 'https://github.com/la-studioweb/resource/raw/master/raz/raz-demo-data.zip',
            'required'				=> true,
            'version'				=> '1.0.0'
        );

		$plugins[] = array(
			'name' 					=> esc_html_x('Contact Form 7', 'admin-view', 'raz'),
			'slug' 					=> 'contact-form-7',
			'required' 				=> false
		);

		$plugins[] = array(
			'name'					=> esc_html_x('Slider Revolution', 'admin-view', 'raz'),
			'slug'					=> 'revslider',
			'source'				=> get_template_directory() . '/plugins/revslider.zip',
			'required'				=> false,
			'version'				=> '5.4.8.3'
		);

		$config = array(
			'id'           				=> 'raz',
			'default_path' 				=> '',
			'menu'         				=> 'tgmpa-install-plugins',
			'has_notices'  				=> true,
			'dismissable'  				=> true,
			'dismiss_msg'  				=> '',
			'is_automatic' 				=> false,
			'message'      				=> ''
		);

		tgmpa( $plugins, $config );

	}

}
