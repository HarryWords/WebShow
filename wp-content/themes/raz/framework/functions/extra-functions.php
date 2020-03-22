<?php if ( ! defined( 'ABSPATH' ) ) { die; }

add_filter('LaStudio_Builder/option_builder_name', 'raz_set_option_builder_name');
if(!function_exists('raz_set_option_builder_name')){
    function raz_set_option_builder_name( $var = ''){
        return 'raz';
    }
}

add_filter('LaStudio_Builder/option_builder_key', 'raz_set_option_builder_key');
if(!function_exists('raz_set_option_builder_key')){
    function raz_set_option_builder_key( $var = ''){
        return 'labuider_for_toro';
    }
}

add_filter('LaStudio_Builder/logo_id', 'raz_set_logo_for_builder');
if(!function_exists('raz_set_logo_for_builder')){
    function raz_set_logo_for_builder( $logo_id ) {
        return Raz()->settings()->get('logo', $logo_id);
    }
}

add_filter('LaStudio_Builder/logo_transparency_id', 'raz_set_logo_transparency_for_builder');
if(!function_exists('raz_set_logo_transparency_for_builder')){
    function raz_set_logo_transparency_for_builder( $logo_id ) {
        return Raz()->settings()->get('logo_transparency', $logo_id);
    }
}

add_action('LaStudio_Builder/display_socials', 'raz_set_social_for_builder');
if(!function_exists('raz_set_social_for_builder')){
    function raz_set_social_for_builder(){
        $social_links = Raz()->settings()->get('social_links', array());
        if(!empty($social_links)){
            echo '<div class="social-media-link style-default">';
            foreach($social_links as $item){
                if(!empty($item['link']) && !empty($item['icon'])){
                    $title = isset($item['title']) ? $item['title'] : '';
                    printf(
                        '<a href="%1$s" class="%2$s" title="%3$s" target="_blank" rel="nofollow"><i class="%4$s"></i></a>',
                        esc_url($item['link']),
                        esc_attr(sanitize_title($title)),
                        esc_attr($title),
                        esc_attr($item['icon'])
                    );
                }
            }
            echo '</div>';
        }
    }
}

add_filter('LaStudio/global_loop_variable', 'raz_set_loop_variable');
if(!function_exists('raz_set_loop_variable')){
    function raz_set_loop_variable( $var = ''){
        return 'raz_loop';
    }
}


add_filter('lastudio-elements/advanced-map/api', 'raz_add_googlemap_api');
if(!function_exists('raz_add_googlemap_api')){
    function raz_add_googlemap_api( $key = '' ){
        return Raz()->settings()->get('google_key', $key);
    }
}

add_filter('raz/filter/page_title', 'raz_override_page_title_bar_title', 10, 2);
if(!function_exists('raz_override_page_title_bar_title')){
    function raz_override_page_title_bar_title( $title, $args ){

        $context = (array) Raz()->get_current_context();

        if(in_array('is_singular', $context)){
            $custom_title = Raz()->settings()->get_post_meta( get_queried_object_id(), 'page_title_custom');
            if(!empty( $custom_title) ){
                return sprintf($args['page_title_format'], $custom_title);
            }
        }

        if(in_array('is_tax', $context) || in_array('is_category', $context) || in_array('is_tag', $context)){
            $custom_title = Raz()->settings()->get_term_meta( get_queried_object_id(), 'page_title_custom');
            if(!empty( $custom_title) ){
                return sprintf($args['page_title_format'], $custom_title);
            }
        }

        if(in_array('is_shop', $context) && function_exists('wc_get_page_id') && ($shop_page_id = wc_get_page_id('shop')) && $shop_page_id){
            $custom_title = Raz()->settings()->get_post_meta( $shop_page_id, 'page_title_custom');
            if(!empty( $custom_title) ){
                return sprintf($args['page_title_format'], $custom_title);
            }
        }

        return $title;
    }
}

add_action( 'pre_get_posts', 'raz_set_posts_per_page_for_portfolio_cpt' );
if(!function_exists('raz_set_posts_per_page_for_portfolio_cpt')){
    function raz_set_posts_per_page_for_portfolio_cpt( $query ) {
        if ( !is_admin() && $query->is_main_query() ) {
            if( is_post_type_archive( 'la_portfolio' ) || is_tax(get_object_taxonomies( 'la_portfolio' ))){
                $pf_per_page = (int) Raz()->settings()->get('portfolio_per_page', 9);
                $query->set( 'posts_per_page', $pf_per_page );
            }
        }
    }
}

add_filter('yith_wc_social_login_icon', 'raz_override_yith_wc_social_login_icon', 10, 3);
if(!function_exists('raz_override_yith_wc_social_login_icon')){
    function raz_override_yith_wc_social_login_icon($social, $key, $args){
        if(!is_admin()){
            $social = sprintf(
                '<a class="%s" href="%s">%s</a>',
                'social_login ywsl-' . esc_attr($key) . ' social_login-' . esc_attr($key),
                $args['url'],
                isset( $args['value']['label'] ) ? $args['value']['label'] : $args['value']
            );
        }
        return $social;
    }
}

add_filter('widget_archives_args', 'raz_modify_widget_archives_args');
if(!function_exists('raz_modify_widget_archives_args')){
    function raz_modify_widget_archives_args( $args ){
        if(isset($args['show_post_count'])){
            unset($args['show_post_count']);
        }
        return $args;
    }
}
if(isset($_GET['la_doing_ajax'])){
    remove_action('template_redirect', 'redirect_canonical');
}
add_filter('woocommerce_redirect_single_search_result', '__return_false');


add_filter('raz/filter/breadcrumbs/items', 'raz_theme_setup_breadcrumbs_for_dokan', 10, 2);
if(!function_exists('raz_theme_setup_breadcrumbs_for_dokan')){
    function raz_theme_setup_breadcrumbs_for_dokan( $items, $args ){
        if (  function_exists('dokan_is_store_page') && dokan_is_store_page() ) {
            $store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
            if( count($items) > 1 ){
                unset($items[(count($items) - 1)]);
            }
            $items[] = sprintf(
                '<div class="la-breadcrumb-item"><span class="%2$s">%1$s</span></div>',
                esc_attr($store_user->get_shop_name()),
                'la-breadcrumb-item-link'
            );
        }

        return $items;
    }
}


add_filter('raz/filter/show_page_title', 'raz_filter_show_page_title', 10, 1 );
add_filter('raz/filter/show_breadcrumbs', 'raz_filter_show_breadcrumbs', 10, 1 );

if(!function_exists('raz_filter_show_page_title')){
    function raz_filter_show_page_title( $show ){
        $context = Raz()->get_current_context();
        if( in_array( 'is_product', $context ) && Raz()->settings()->get('product_single_hide_page_title', 'no') == 'yes' ){
            return false;
        }
        return $show;
    }
}

if(!function_exists('raz_filter_show_breadcrumbs')){
    function raz_filter_show_breadcrumbs( $show ){
        $context = Raz()->get_current_context();
        if( in_array( 'is_product', $context ) && Raz()->settings()->get('product_single_hide_breadcrumb', 'no') == 'yes'){
            return false;
        }
        return $show;
    }
}


add_filter('LaStudio/swatches/args/show_option_none', 'raz_allow_translate_woo_text_in_swatches', 10, 1);
if(!function_exists('raz_allow_translate_woo_text_in_swatches')){
    function raz_allow_translate_woo_text_in_swatches( $text ){
        return esc_html_x( 'Choose an option', 'front-view', 'raz' );
    }
}

if(!function_exists('raz_get_relative_url')){
    function raz_get_relative_url( $url ) {
        return raz_is_external_resource( $url ) ? $url : str_replace( array( 'http://', 'https://' ), '//', $url );
    }
}
if(!function_exists('raz_is_external_resource')){
    function raz_is_external_resource( $url ) {
        $wp_base = str_replace( array( 'http://', 'https://' ), '//', get_home_url( null, '/', 'http' ) );
        return strstr( $url, '://' ) && strstr( $wp_base, $url );
    }
}

if (!function_exists('raz_wpml_object_id')) {
    function raz_wpml_object_id( $element_id, $element_type = 'post', $return_original_if_missing = false, $ulanguage_code = null ) {
        if ( function_exists( 'wpml_object_id_filter' ) ) {
            return wpml_object_id_filter( $element_id, $element_type, $return_original_if_missing, $ulanguage_code );
        } elseif ( function_exists( 'icl_object_id' ) ) {
            return icl_object_id( $element_id, $element_type, $return_original_if_missing, $ulanguage_code );
        } else {
            return $element_id;
        }
    }
}

/**
 * Override page title bar from global settings
 * What we need to do now is
 * 1. checking in single content types
 *  1.1) post
 *  1.2) product
 *  1.3) portfolio
 * 2. checking in archives
 *  2.1) shop
 *  2.2) portfolio
 *
 * TIPS: List functions will be use to check
 * `is_product`, `is_single_la_portfolio`, `is_shop`, `is_woocommerce`, `is_product_taxonomy`, `is_archive_la_portfolio`, `is_tax_la_portfolio`
 */

if(!function_exists('raz_override_page_title_bar_from_context')){
    function raz_override_page_title_bar_from_context( $value, $key, $context ){

        $array_key_allow = array(
            'page_title_bar_style',
            'page_title_bar_layout',
            'page_title_font_size',
            'page_title_bar_background',
            'page_title_bar_heading_color',
            'page_title_bar_text_color',
            'page_title_bar_link_color',
            'page_title_bar_link_hover_color',
            'page_title_bar_spacing',
            'page_title_bar_spacing_desktop_small',
            'page_title_bar_spacing_tablet',
            'page_title_bar_spacing_mobile'
        );

        $array_key_alternative = array(
            'page_title_font_size',
            'page_title_bar_background',
            'page_title_bar_heading_color',
            'page_title_bar_text_color',
            'page_title_bar_link_color',
            'page_title_bar_link_hover_color',
            'page_title_bar_spacing',
            'page_title_bar_spacing_desktop_small',
            'page_title_bar_spacing_tablet',
            'page_title_bar_spacing_mobile'
        );

        /**
         * Firstly, we need to check the `$key` input
         */
        if( !in_array($key, $array_key_allow) ){
            return $value;
        }

        /**
         * Secondary, we need to check the `$context` input
         */
        if( !in_array('is_singular', $context) && !in_array('is_woocommerce', $context) && !in_array('is_archive_la_portfolio', $context) && !in_array('is_tax_la_portfolio', $context)){
            return $value;
        }

        if( !is_singular(array('product', 'post', 'la_portfolio')) && !in_array('is_product_taxonomy', $context) && !in_array('is_shop', $context) ) {
            return $value;
        }


        $func_name = 'get_post_meta';
        $queried_object_id = get_queried_object_id();

        if( in_array('is_product_taxonomy', $context) || in_array('is_tax_la_portfolio', $context) ){
            $func_name = 'get_term_meta';
        }

        if(in_array('is_shop', $context)){
            $queried_object_id = Raz_WooCommerce::$shop_page_id;
        }

        if ( 'page_title_bar_layout' == $key ) {
            $page_title_bar_layout = Raz()->settings()->$func_name($queried_object_id, $key);
            if($page_title_bar_layout && $page_title_bar_layout != 'inherit'){
                return $page_title_bar_layout;
            }
        }

        if( 'yes' == Raz()->settings()->$func_name($queried_object_id, 'page_title_bar_style') && in_array($key, $array_key_alternative) ){
            return $value;
        }

        $key_override = $new_key = false;

        if( in_array('is_product', $context) ){
            $key_override = 'single_product_override_page_title_bar';
            $new_key = 'single_product_' . $key;
        }
        elseif( in_array('is_single_la_portfolio', $context) ) {
            $key_override = 'single_portfolio_override_page_title_bar';
            $new_key = 'single_portfolio_' . $key;
        }
        elseif( is_singular('post') ) {
            $key_override = 'single_post_override_page_title_bar';
            $new_key = 'single_post_' . $key;
        }
        elseif( in_array('is_single_la_portfolio', $context) ) {
            $key_override = 'single_portfolio_override_page_title_bar';
            $new_key = 'single_portfolio_' . $key;
        }
        elseif ( in_array('is_shop', $context) || in_array('is_product_taxonomy', $context) ) {
            $key_override = 'woo_override_page_title_bar';
            $new_key = 'woo_' . $key;
        }
        elseif ( in_array('is_archive_la_portfolio', $context) || in_array('is_tax_la_portfolio', $context) ) {
            $key_override = 'archive_portfolio_override_page_title_bar';
            $new_key = 'archive_portfolio_' . $key;
        }

        if(false != $key_override){
            if( 'on' == Raz()->settings()->get($key_override, 'off') ){
                return Raz()->settings()->get($new_key, $value);
            }
        }

        return $value;
    }

    add_filter('raz/setting/get_setting_by_context', 'raz_override_page_title_bar_from_context', 10, 3);
}

/**
 * This function allow get property of `woocommerce_loop` inside the loop
 * @since 1.0.0
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */

if(!function_exists('raz_get_wc_loop_prop')){
    function raz_get_wc_loop_prop( $prop, $default = ''){
        return isset( $GLOBALS['woocommerce_loop'], $GLOBALS['woocommerce_loop'][ $prop ] ) ? $GLOBALS['woocommerce_loop'][ $prop ] : $default;
    }
}

/**
 * This function allow set property of `woocommerce_loop`
 * @since 1.0.0
 * @param string $prop Prop to set.
 * @param string $value Value to set.
 */

if(!function_exists('raz_set_wc_loop_prop')){
    function raz_set_wc_loop_prop( $prop, $value = ''){
        if(isset($GLOBALS['woocommerce_loop'])){
            $GLOBALS['woocommerce_loop'][ $prop ] = $value;
        }
    }
}

/**
 * This function allow get property of `raz_loop` inside the loop
 * @since 1.0.0
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */

if(!function_exists('raz_get_theme_loop_prop')){
    function raz_get_theme_loop_prop( $prop, $default = ''){
        return isset( $GLOBALS['raz_loop'], $GLOBALS['raz_loop'][ $prop ] ) ? $GLOBALS['raz_loop'][ $prop ] : $default;
    }
}

if(!function_exists('raz_set_theme_loop_prop')){
    function raz_set_theme_loop_prop( $prop, $value = '', $force = false){
        if($force && !isset($GLOBALS['raz_loop'])){
            $GLOBALS['raz_loop'] = array();
        }
        if(isset($GLOBALS['raz_loop'])){
            $GLOBALS['raz_loop'][ $prop ] = $value;
        }
    }
}

if(!function_exists('raz_convert_legacy_responsive_column')){
    function raz_convert_legacy_responsive_column( $columns = array() ) {
        $legacy = array(
            'xlg'	=> '',
            'lg' 	=> '',
            'md' 	=> '',
            'sm' 	=> '',
            'xs' 	=> '',
            'mb' 	=> 1
        );
        $new_key = array(
            'mb'    =>  'xs',
            'xs'    =>  'sm',
            'sm'    =>  'md',
            'md'    =>  'lg',
            'lg'    =>  'xl',
            'xlg'   =>  'xxl'
        );
        if(empty($columns)){
            $columns = $legacy;
        }
        $new_columns = array();
        foreach($columns as $k => $v){
            if(isset($new_key[$k])){
                $new_columns[$new_key[$k]] = $v;
            }
        }
        if(empty($new_columns['xs'])){
            $new_columns['xs'] = 1;
        }
        return $new_columns;
    }
}

if(!function_exists('raz_render_grid_css_class_from_columns')){
    function raz_render_grid_css_class_from_columns( $columns, $merge = true ) {
        if($merge){
            $columns = raz_convert_legacy_responsive_column( $columns );
        }
        $classes = array();
        foreach($columns as $k => $v){
            if(empty($v)){
                continue;
            }
            if($k == 'xs'){
                $classes[] = 'block-grid-' . $v;
            }
            else{
                $classes[] = $k . '-block-grid-' . $v;
            }
        }
        return join(' ', $classes);
    }
}

if(!function_exists('raz_add_ajax_cart_btn_into_single_product')){
    function raz_add_ajax_cart_btn_into_single_product(){
        global $product;
        if($product->is_type('simple')){
            echo '<input type="hidden" name="add-to-cart" value="'.$product->get_id().'"/>';
        }
    }
    add_action('woocommerce_after_add_to_cart_button', 'raz_add_ajax_cart_btn_into_single_product');
}

if(!function_exists('raz_get_the_excerpt')){
    function raz_get_the_excerpt($length = null){
        ob_start();

        $length = absint($length);

        if(!empty($length)){
            add_filter('excerpt_length', function() use ($length) {
                return $length;
            }, 1012);
        }

        the_excerpt();

        if(!empty($length)) {
            remove_all_filters('excerpt_length', 1012);
        }
        $output = ob_get_clean();

        $output = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $output);

        $output = strip_tags( $output );

        $output = str_replace('&hellip;', '', $output);

        if(!empty(trim($output))){
            $output = sprintf('<p>%s</p>', $output);
        }

        return $output;
    }
}


if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
    function woocommerce_template_loop_product_title() {
        the_title( sprintf( '<h3 class="product_item--title"><a href="%s">', esc_url( get_the_permalink() ) ), '</a></h3>' );
    }
}

if(!function_exists('raz_override_woothumbnail_size_name')){
    function raz_override_woothumbnail_size_name( ) {
        return 'shop_thumbnail';
    }
    add_filter('woocommerce_gallery_thumbnail_size', 'raz_override_woothumbnail_size_name', 0);
}

if(!function_exists('raz_override_woothumbnail_size')){
    function raz_override_woothumbnail_size( $size ) {
        if(!function_exists('wc_get_theme_support')){
            return $size;
        }
        $size['width'] = absint( wc_get_theme_support( 'gallery_thumbnail_image_width', 180 ) );
        $cropping      = get_option( 'woocommerce_thumbnail_cropping', '1:1' );

        if ( 'uncropped' === $cropping ) {
            $size['height'] = '';
            $size['crop']   = 0;
        }
        elseif ( 'custom' === $cropping ) {
            $width          = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_width', '4' ) );
            $height         = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_height', '3' ) );
            $size['height'] = absint( round( ( $size['width'] / $width ) * $height ) );
            $size['crop']   = 1;
        }
        else {
            $cropping_split = explode( ':', $cropping );
            $width          = max( 1, current( $cropping_split ) );
            $height         = max( 1, end( $cropping_split ) );
            $size['height'] = absint( round( ( $size['width'] / $width ) * $height ) );
            $size['crop']   = 1;
        }

        return $size;
    }
    add_filter('woocommerce_get_image_size_gallery_thumbnail', 'raz_override_woothumbnail_size');
}

if(!function_exists('raz_override_woothumbnail_single')){
    function raz_override_woothumbnail_single( $size ) {
        if(!function_exists('wc_get_theme_support')){
            return $size;
        }
        $size['width'] = absint( wc_get_theme_support( 'single_image_width', get_option( 'woocommerce_single_image_width', 600 ) ) );
        $cropping      = get_option( 'woocommerce_thumbnail_cropping', '1:1' );

        if ( 'uncropped' === $cropping ) {
            $size['height'] = '';
            $size['crop']   = 0;
        }
        elseif ( 'custom' === $cropping ) {
            $width          = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_width', '4' ) );
            $height         = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_height', '3' ) );
            $size['height'] = absint( round( ( $size['width'] / $width ) * $height ) );
            $size['crop']   = 1;
        }
        else {
            $cropping_split = explode( ':', $cropping );
            $width          = max( 1, current( $cropping_split ) );
            $height         = max( 1, end( $cropping_split ) );
            $size['height'] = absint( round( ( $size['width'] / $width ) * $height ) );
            $size['crop']   = 1;
        }

        return $size;
    }
    add_filter('woocommerce_get_image_size_single', 'raz_override_woothumbnail_single', 0);
}

if(!function_exists('raz_override_filter_woocommerce_format_content')){
    function raz_override_filter_woocommerce_format_content( $format, $raw_string ){
        $format = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $raw_string);
        return apply_filters( 'woocommerce_short_description', $format );
    }
}

add_action('woocommerce_checkout_terms_and_conditions', 'raz_override_wc_format_content_in_terms', 1);
add_action('woocommerce_checkout_terms_and_conditions', 'raz_remove_override_wc_format_content_in_terms', 999);
if(!function_exists('raz_override_wc_format_content_in_terms')){
    function raz_override_wc_format_content_in_terms(){
        add_filter('woocommerce_format_content', 'raz_override_filter_woocommerce_format_content', 99, 2);
    }
}
if(!function_exists('raz_remove_override_wc_format_content_in_terms')){
    function raz_remove_override_wc_format_content_in_terms(){
        raz_deactive_filter('woocommerce_format_content', 'raz_override_filter_woocommerce_format_content', 99);
    }
}


if(!function_exists('raz_wc_product_loop')){
    function raz_wc_product_loop(){
        if(!function_exists('WC')){
            return false;
        }
        return have_posts() || 'products' !== woocommerce_get_loop_display_mode();
    }
}

add_filter('lastudio-elements/assets/css/default-theme-enabled', '__return_false');


if(!function_exists('raz_set_up_wc_product_grid_style')){
    function raz_set_up_wc_product_grid_style( $style ) {

        $style = array(
            '1' => esc_html__( 'Type-1', 'raz' ),
            '2' => esc_html__( 'Type-2', 'raz' ),
            '3' => esc_html__( 'Type-3', 'raz' ),
            '4' => esc_html__( 'Type-4', 'raz' ),
            '5' => esc_html__( 'Type-5', 'raz' ),
            '6' => esc_html__( 'Type-6', 'raz' ),
            '7' => esc_html__( 'Type-7', 'raz' )
        );

        return $style;
    }

    add_filter( 'lastudio-elements/products/control/grid_style', 'raz_set_up_wc_product_grid_style' );
}


if(!function_exists('raz_set_up_wc_product_masonry_style')){
    function raz_set_up_wc_product_masonry_style( $style ) {
        $style = array(
            '1' => esc_html__( 'Type-1', 'raz' ),
            '2' => esc_html__( 'Type-2', 'raz' ),
            '3' => esc_html__( 'Type-3', 'raz' ),
            '4' => esc_html__( 'Type-4', 'raz' ),
            '5' => esc_html__( 'Type-5', 'raz' ),
            '6' => esc_html__( 'Type-6', 'raz' ),
            '7' => esc_html__( 'Type-7', 'raz' )
        );
        return $style;
    }
    add_filter( 'lastudio-elements/products/control/masonry_style', 'raz_set_up_wc_product_masonry_style' );
}

if(!function_exists('raz_set_up_wc_product_list_style')){
    function raz_set_up_wc_product_list_style( $style ) {
        return $style;
    }
    add_filter( 'lastudio-elements/products/control/list_style', 'raz_set_up_wc_product_list_style' );
}


if(!function_exists('raz_setup_banner_hover_effects')){
    function raz_setup_banner_hover_effects( $style ) {
        
        $new_style = array(
            'custom-1'  => esc_html__( 'Custom 01', 'raz' ),
            'custom-2'  => esc_html__( 'Custom 02', 'raz' ),
            'custom-3'  => esc_html__( 'Custom 03', 'raz' ),
            'custom-4'  => esc_html__( 'Custom 04', 'raz' ),
            'custom-5'  => esc_html__( 'Custom 05', 'raz' ),
            'custom-6'  => esc_html__( 'Custom 06', 'raz' ),
            'custom-7'  => esc_html__( 'Custom 07', 'raz' ),
            'custom-8'  => esc_html__( 'Custom 08', 'raz' ),
            'custom-9'  => esc_html__( 'Custom 09', 'raz' ),
            'custom-10'  => esc_html__( 'Custom 10', 'raz' ),
            'custom-11'  => esc_html__( 'Custom 11', 'raz' ),
            'custom-12'  => esc_html__( 'Custom 12', 'raz' ),
        );
        
        return $style + $new_style;
    }

    add_filter( 'lastudio-elements/banner/hover_effect', 'raz_setup_banner_hover_effects' );
}

if(!function_exists('raz_add_portfolio_preset')){
    function raz_add_portfolio_preset( ){
        return array(
            'type-1' => esc_html__( 'Type-1', 'raz' ),
            'type-2' => esc_html__( 'Type-2', 'raz' ),
            'type-3' => esc_html__( 'Type-3', 'raz' ),
            'type-4' => esc_html__( 'Type-4', 'raz' )
        );
    }
    add_filter('lastudio-elements/portfolio/control/preset', 'raz_add_portfolio_preset');
}

if(!function_exists('raz_add_portfolio_list_preset')){
    function raz_add_portfolio_list_preset( ){
        return array(
            'list-type-1' => esc_html__( 'Type-1', 'raz' ),
            'list-type-2' => esc_html__( 'Type-2', 'raz' ),
            'list-type-3' => esc_html__( 'Type-3', 'raz' ),
            'list-type-4' => esc_html__( 'Type-4', 'raz' )
        );
    }
    add_filter('lastudio-elements/portfolio/control/preset_list', 'raz_add_portfolio_list_preset');
}

if(!function_exists('raz_get_google_fonts_url')){
    function raz_get_google_fonts_url(){
        $_tmp_fonts = array();

        $main_font = (array) Raz()->settings()->get('main_font');
        $secondary_font = (array) Raz()->settings()->get('secondary_font');
        $highlight_font = (array) Raz()->settings()->get('highlight_font');

        if(!empty($main_font['family']) && (!empty($main_font['font']) && $main_font['font'] == 'google') ){
            $variant = !empty($main_font['variant']) ? (array) $main_font['variant'] : array();
            $f_name = $main_font['family'];
            if(isset($_tmp_fonts[$f_name])){
                $old_variant = $_tmp_fonts[$f_name];
                $_tmp_fonts[$f_name] = array_unique(array_merge($old_variant, $variant));
            }
            else{
                $_tmp_fonts[$f_name] = $variant;
            }
        }

        if(!empty($secondary_font['family']) && (!empty($secondary_font['font']) && $secondary_font['font'] == 'google')){
            $variant = !empty($secondary_font['variant']) ? (array) $secondary_font['variant'] : array();
            $f_name = $secondary_font['family'];
            if(isset($_tmp_fonts[$f_name])){
                $old_variant = $_tmp_fonts[$f_name];
                $_tmp_fonts[$f_name] = array_unique(array_merge($old_variant, $variant));
            }
            else{
                $_tmp_fonts[$f_name] = $variant;
            }
        }

        if(!empty($highlight_font['family']) && (!empty($highlight_font['font']) && $highlight_font['font'] == 'google')){
            $variant = !empty($highlight_font['variant']) ? (array) $highlight_font['variant'] : array();
            $f_name = $highlight_font['family'];
            if(isset($_tmp_fonts[$f_name])){
                $old_variant = $_tmp_fonts[$f_name];
                $_tmp_fonts[$f_name] = array_unique(array_merge($old_variant, $variant));
            }
            else{
                $_tmp_fonts[$f_name] = $variant;
            }
        }

        if(empty($_tmp_fonts)){
            return '';
        }

        $_tmp_fonts2 = array();

        foreach ( $_tmp_fonts as $k => $v ) {
            if( !empty( $v ) ) {
                $_tmp_fonts2[] = preg_replace('/\s+/', '+', $k) . ':' . implode(',', $v);
            }
            else{
                $_tmp_fonts2[] = preg_replace('/\s+/', '+', $k);
            }
        }
        return esc_url( add_query_arg('family', implode( '%7C', $_tmp_fonts2 ),'https://fonts.googleapis.com/css') );
    }
}