<?php

/**
 * Header Builder - Hidden Field.
 *
 * @author	LaStudio
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

/**
 * Hidden field function.
 *
 * @since	1.0.0
 */
function lahb_hidden( $settings ) {

	$id			= isset( $settings['id'] ) ? $settings['id'] : '';
	$default	= isset( $settings['default'] ) ? $settings['default'] : '';

	$output = '
		<div class="lahb-field lahb-field-hidden-wrap w-col-sm-12">
			<input type="hidden" class="lahb-field-input lahb-field-hidden" data-field-name="' . esc_attr( $id ) . '" data-field-std="' . $default . '">
		</div>
	';

	if ( ! isset( $settings['get'] ) ) :
		echo '' . $output;
	else :
		return $output;
	endif;

}
