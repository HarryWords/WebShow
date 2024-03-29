<?php
/**
 * Header Builder - Header Output Class.
 *
 * @author  LaStudio
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if ( ! class_exists( 'LAHB_Output' ) ) :

    class LAHB_Output {

		/**
		 * Instance of this class.
         *
		 * @since	1.0.0
		 * @access	private
		 * @var		LAHB_Output
		 */
		private static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since	1.0.0
		 * @return	object
		 */
		public static function get_instance() {

			if ( self::$instance === null ) {
				self::$instance = new self();
            }

			return self::$instance;

		}
		
		private static $dynamic_style = '';

		/**
		 * Constructor.
		 *
		 * @since	1.0.0
		 */
		public function __construct() {

		}
		
		public static function set_dynamic_styles( $styles, $preset_name = '' ){
		    self::$dynamic_style .= $styles;
        }

		/**
		 * Output header.
		 *
		 * @since	1.0.0
		 */
        public static function output($is_frontend_builder = false, $lahb_data = array(), $preset_name = '', $header_schema = '') {

            $is_frontend_builder = $is_frontend_builder ? $is_frontend_builder : LAHB_Helper::is_frontend_builder();

            $header_show = '';
            
            // header visibility
            if ( $header_show === '1') {
                $header_show = true;
            }
            elseif ( $header_show === '0' ) {
                $header_show = false;
            }
            elseif ( $header_show === false || empty( $header_show ) ) {
                $header_show = true;
            }

            if ( ! ( $is_frontend_builder || $header_show ) ) {
                return;
            }

            $lahb_data = $lahb_data ? $lahb_data :  LAHB_Helper::get_data_frontend_components();

            $prepare_data = LAHB_Helper::convertOldHeaderData( $lahb_data );

            $header_components = LAHB_Helper::get_only_components_from_settings($prepare_data);
            $panels_settings = LAHB_Helper::get_only_panels_from_settings($prepare_data);

            /**
             * What we need to do now is
             * 1) Render all the components - this will save more time
             * 2) Then we need render panel to match with screen view
             */
            $registered_components = LAHB_Helper::get_elements();
            $components_has_run = array();

            // Start render header output
            $class_frontend_builder = $is_frontend_builder ? ' lahb-frontend-builder' : '';
            $output = '<header id="lastudio-header-builder" class="lahb-wrap' . esc_attr( $class_frontend_builder ) . '"'.$header_schema.'>';
                $output .= '<div class="lahbhouter">';
                    $output .= '<div class="lahbhinner">';
                        $output .= '<div class="main-slide-toggle"></div>';

                        if(!empty($panels_settings)){

                            /**
                             * We need to check header type vertical first !!
                             * if this is vertical type ==> remove others areas on desktop-view except 'row1'
                             */
                            $__detect_header_type = '';
                            if(isset($panels_settings['desktop-view']['row1']['settings']['header_type'])){
                                $__detect_header_type = $panels_settings['desktop-view']['row1']['settings']['header_type'];
                            }

                            // Screen
                            foreach ( $panels_settings as $screen_view_index => $screen_view ) {
                                $output .= '<div class="lahb-screen-view lahb-' . esc_attr( $screen_view_index  ) . '">';

                                $vertical_header = '';

                                // Rows
                                foreach ( $screen_view as $row_index => $rows ) {
                                    if($screen_view_index == 'desktop-view' && $__detect_header_type == 'vertical'){
                                        if($row_index != 'row1'){
                                            continue;
                                        }
                                    }

                                    // check visibility
                                    $hidden_area = $rows['settings']['hidden_element'];
                                    if ( $hidden_area === 'false' ) {
                                        $hidden_area = false;
                                    }
                                    elseif ( $hidden_area === 'true' ) {
                                        $hidden_area = true;
                                    }

                                    // check vertical header
                                    if ( $screen_view_index == 'desktop-view' ) {
                                        $header_type = !empty($rows['settings']['header_type']) ? $rows['settings']['header_type'] : '';
                                        if ($row_index != 'row1') {
                                            if ($header_type == 'vertical'){
                                                continue;
                                            }
                                        }
                                        else {
                                            if ($header_type == 'vertical') {
                                                $vertical_header = ' lahb-vertical';
                                            }
                                        }
                                    }

                                    // start render area
                                    if ( ! $hidden_area ) {
                                        $area_settings      = isset( $rows['settings'] ) ? $rows['settings'] : '';
                                        $areas              = array();
                                        $areas['left']      = isset( $rows['left'] ) ? $rows['left'] : '';
                                        $areas['center']    = isset( $rows['center'] ) ? $rows['center'] : '';
                                        $areas['right']     = isset( $rows['right'] ) ? $rows['right'] : '';

                                        $full_container = $container_padd = $content_position = $extra_class = $extra_id = '';
                                        if(isset($area_settings['uniqueId']) && isset($header_components[$area_settings['uniqueId']])){
                                            $area_settings = LAHB_Helper::component_atts( $area_settings, $header_components[ $area_settings['uniqueId'] ] );
                                        }
                                        extract( LAHB_Helper::component_atts( array(
                                            'full_container'	=> 'false',
                                            'container_padd'	=> 'true',
                                            'content_position'	=> 'middle',
                                            'extra_class'   	=> '',
                                            'extra_id'      	=> ''
                                        ), $area_settings ));

                                        // once fire

                                        if ( $header_type == 'vertical' && $screen_view_index == 'desktop-view' ) {

                                            if ($header_type == 'vertical') {

                                                $vertical_toggle = $vertical_toggle_icon = $logo = '';

                                                extract(LAHB_Helper::component_atts(array(
                                                    'vertical_toggle' => 'false',
                                                    'vertical_toggle_icon' => 'fa fa-bars',
                                                    'logo' => ''
                                                ), $area_settings));

                                                // Render Custom Style
                                                $vertical_dynamic_style = lahb_styling_tab_output($area_settings, 'Logo', '#lastudio-header-builder .lahb-vertical-logo-wrap');
                                                $vertical_dynamic_style .= lahb_styling_tab_output($area_settings, 'Toggle Bar', '#lastudio-header-builder .lahb-vertical-toggle-wrap');
                                                $vertical_dynamic_style .= lahb_styling_tab_output($area_settings, 'Toggle Icon Box', '#lastudio-header-builder .vertical-toggle-icon', '#lastudio-header-builder .vertical-toggle-icon:hover');
                                                $vertical_dynamic_style .= lahb_styling_tab_output($area_settings, 'Box', '#lastudio-header-builder.lahb-wrap .lahb-vertical');

                                                if (!empty($vertical_dynamic_style)) {
                                                    self::set_dynamic_styles('@media only screen and (min-width: 1025px) { ' . $vertical_dynamic_style . ' } ', $preset_name);
                                                }
                                            }

                                            if ($vertical_toggle == 'true') {
                                                $logo = $logo ? lahb_wp_get_attachment_url($logo) : '';
                                                // Render Toggle Wrap
                                                $output .= '<div class="lahb-vertical-toggle-wrap"><a href="#" class="vertical-toggle-icon"><i class="' . lahb_rename_icon($vertical_toggle_icon) . '" ></i></a>';
                                                if (!empty($logo)) {
                                                    $output .= sprintf(
                                                        '<div class="lahb-vertical-logo-wrap"><a href="%s"><img class="lahb-vertical-logo" src="%s" alt="%s"></a></div>',
                                                        esc_url(home_url('/')),
                                                        esc_url($logo),
                                                        get_bloginfo('name')
                                                    );
                                                }
                                                $output .= '</div>';

                                            }

                                        }

                                        // height
                                        if ( ! empty( $area_height ) ) {
                                            $area_height = ! empty( $area_height ) ? $area_height : '';
                                            $area_height = 'height: ' . LAHB_Helper::css_sanatize( $area_height ) . ';';
                                            self::set_dynamic_styles( '#lastudio-header-builder .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area:not(.lahb-vertical) { ' . $area_height . ' }', $preset_name);
                                        }

                                        $dynamic_style = '';
                                        $dynamic_style .= lahb_styling_tab_output( $area_settings, 'Typography', '.lahb-wrap .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area' );
                                        $dynamic_style .= lahb_styling_tab_output( $area_settings, 'Background', '.lahb-wrap .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area' );
                                        $dynamic_style .= lahb_styling_tab_output( $area_settings, 'Box', '.lahb-wrap .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area:not(.lahb-vertical)' );

                                        $dynamic_style .= lahb_styling_tab_output( $area_settings, 'Transparency Background', '.enable-header-transparency .lahb-wrap:not(.is-sticky) .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area' );
                                        $dynamic_style .= lahb_styling_tab_output( $area_settings, 'Transparency Text Color', '.enable-header-transparency .lahb-wrap:not(.is-sticky) .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area .lahb-element' );
                                        $dynamic_style .= lahb_styling_tab_output( $area_settings, 'Transparency Link Color', '.enable-header-transparency .lahb-wrap:not(.is-sticky) .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area .lahb-element:not(.lahb-nav-wrap) a' );

                                        // width
                                        if ( ! empty( $area_width ) ) {
                                            $area_width = 'width: ' . LAHB_Helper::css_sanatize( $area_width ) . ';';
                                            self::set_dynamic_styles( '@media only screen and (min-width: 1025px) { .lahb-wrap .lahb-'.$screen_view_index.' .lahb-' . $row_index . '-area:not(.lahb-vertical) > .container { ' . $area_width . ' } }', $preset_name);
                                        }

                                        if ( !empty($dynamic_style) ) {
                                            self::set_dynamic_styles( $dynamic_style, $preset_name );
                                        }


                                        // Classes
                                        $area_classes   = '';
                                        $area_classes   .= ! empty($content_position) ? ' lahb-content-' . $content_position : '' ;
                                        $area_classes   .= ! empty($extra_class) ? ' ' . $extra_class : '' ;
                                        $container_padd = $container_padd == 'true' ? '' : ' la-no-padding';
                                        if( $full_container != 'false' ) {
                                            $container_padd .= ' la-container-full';
                                        }
                                        // Id
                                        $extra_id = ! empty( $extra_id ) ? ' id="' . esc_attr( $extra_id ) . '"' : '' ;

                                        // Toggle vertical
                                        if($screen_view_index == 'mobiles-view'){
                                            $row_layout = ' lahb-area__' . ( !empty($area_settings['row_layout_sme_row_layout']) ? $area_settings['row_layout_sme_row_layout'] : 'auto' );
                                        }
                                        elseif ($screen_view_index == 'tablets-view'){
                                            $row_layout = ' lahb-area__' . ( !empty($area_settings['row_layout_ste_row_layout']) ? $area_settings['row_layout_ste_row_layout'] : 'auto' );
                                        }
                                        else{
                                            $row_layout = ' lahb-area__' . ( !empty($area_settings['row_layout_sae_row_layout']) ? $area_settings['row_layout_sae_row_layout'] : 'auto' );
                                        }

                                        $output .= '<div class="lahb-area lahb-' . $row_index . '-area' . $vertical_header . $area_classes . $row_layout . '"' . $extra_id . '>';

                                        $output .= '<div class="container' . $container_padd . '">';
                                        $output .= '<div class="lahb-content-wrap'. esc_attr($row_layout) .'">';

                                        // Columns
                                        foreach ( $areas as $area_key => $components ) {
                                            $output .= '<div class="lahb-col lahb-col__' . esc_attr($area_key) . '">';
                                            if ($components) {
                                                foreach ($components as $component_index => $component) {
                                                    if ($component_index === 'settings') {
                                                        continue;
                                                    }
                                                    $hidden_el = $component['hidden_element'];
                                                    if (!$hidden_el) {
                                                        $uniqid = $component['uniqueId'];
                                                        $component_name = $component['name'];

                                                        $once_run_flag = false;
                                                        //make component as loaded
                                                        if(!in_array($uniqid, $components_has_run)){
                                                            $components_has_run[] = $uniqid;
                                                            $once_run_flag = true;
                                                        }

                                                        if(isset($registered_components[$component_name])){
                                                            $func_name_comp = $registered_components[$component_name];
                                                            $output .= call_user_func( $func_name_comp, $header_components[$uniqid], $uniqid, $once_run_flag);
                                                        }

                                                    }

                                                } // end components loop
                                            }
                                            $output .= '</div>';

                                        } // end areas loop

                                        $output .= '</div>';
                                        $output .= '</div>';

                                        $output .= '</div>';
                                    }
                                }
                                $output .= '</div>';
                            }
                        }

                    $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="lahb-wrap-sticky-height"></div>';
            $output .= '</header>';

            if(!LAHB_Helper::is_prebuild_header_exists($preset_name)){
                $preset_name = '';
            }

            self::set_dynamic_styles(LAHB_Helper::get_styles());

            self::save_dynamic_styles($preset_name);

            if( $is_frontend_builder || ( isset($_GET['lastudio_header_builder']) && $_GET['lastudio_header_builder'] == 'inline_mode' ) ) {
                $output .= sprintf('<style id="lahb-frontend-styles-inline-css">%s</style>', LAHB_Helper::get_dynamic_styles($preset_name));
            }

            $script_fix = '';

            if( !$is_frontend_builder && !isset($_GET['lastudio_header_builder'])){
                $script_fix = '<script>';
                $script_fix .= 'var LaStudioHeaderBuilderHTMLDivCSS = unescape("'. self::compress_css(rawurlencode(stripslashes(self::$dynamic_style))) .'");';
                $script_fix .= 'var LaStudioHeaderBuilderHTMLDiv = document.getElementById("lahb-frontend-styles-inline-css");';
                $script_fix .= 'if(LaStudioHeaderBuilderHTMLDiv) { LaStudioHeaderBuilderHTMLDiv.innerHTML = LaStudioHeaderBuilderHTMLDivCSS; } else{ var LaStudioHeaderBuilderHTMLDiv = document.createElement("div"); LaStudioHeaderBuilderHTMLDiv.innerHTML = "<style>" + LaStudioHeaderBuilderHTMLDivCSS + "</style>"; document.getElementsByTagName("head")[0].appendChild(LaStudioHeaderBuilderHTMLDiv.childNodes[0]);}';
                $script_fix .= '</script>';
            }

            return $script_fix . $output;
        }


        public static function compress_css($buffer){
            /* remove comments */
            $buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer) ;
            /* remove tabs, spaces, newlines, etc. */
            $arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ");
            $rep = array("", "", "", "", " ", " ", " ");
            $buffer = str_replace($arr, $rep, $buffer);
            /* remove whitespaces around {}:, */
            $buffer = preg_replace("/\s*([\{\}:,])\s*/", "$1", $buffer);
            /* remove last ; */
            $buffer = str_replace(';}', "}", $buffer);

            return $buffer;
        }


        public static function save_dynamic_styles( $preset_name = '' ){
            $session_key = 'lahb_dynamic_style';
            if(!empty($preset_name)){
                $session_key = 'lahb_dynamic_style_' . $preset_name;
            }
            $_SESSION[$session_key] = self::$dynamic_style;
        }

    }

endif;
