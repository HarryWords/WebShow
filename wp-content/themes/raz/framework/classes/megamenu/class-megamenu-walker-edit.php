<?php if ( ! defined( 'ABSPATH' ) ) { die; }

if(!class_exists('Raz_MegaMenu_Walker_Edit')){

	class Raz_MegaMenu_Walker_Edit extends Walker_Nav_Menu_Edit {

		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$item_output = '';
			parent::start_el( $item_output, $item, $depth, $args, $id );
			$output .= preg_replace(
			// NOTE: Check this regex from time to time!
				'/(?=<[p|fieldset][^>]+class="[^"]*field-move)/',
				$this->get_fields( $item, $depth, $args ),
				$item_output,
				1
			);
		}

		protected function get_fields( $item, $depth, $args = array(), $id = 0 ) {
			ob_start();
			do_action( 'wp_nav_menu_item_custom_fields', $id, $item, $depth, $args );
			return ob_get_clean();
		}

	}

}