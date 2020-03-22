<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

/**
 * Handle enqueueing scrips.
 */
class Raz_Scripts
{

    /**
     * The class construction
     */
    public function __construct()
    {
        add_filter('lastudio/theme/defer_scripts', array( $this, 'override_defer_scripts' ) );
        if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 20);
        }

        if (class_exists('WooCommerce')) {
            add_filter('woocommerce_enqueue_styles', array($this, 'remove_woo_scripts'));
        }

        add_action('wp_head', array( $this, 'add_meta_into_head'), 100 );
        add_action('raz/action/head', array( $this, 'get_custom_css_from_setting'));
        add_action('raz/action/head', array( $this, 'add_custom_header_js' ), 100 );
        add_action('wp_footer', array( $this, 'add_custom_footer_js' ), 100 );

        add_action( 'enqueue_block_editor_assets', array( $this, 'editor_customizer_styles' ) );


    }

    /**
     * Takes care of enqueueing all our scripts.
     */
    public function enqueue_scripts()
    {

        if(function_exists('vc_is_inline') && function_exists('vc_is_frontend_ajax') && vc_is_inline() && vc_is_frontend_ajax()){
            return;
        }

		$theme_version = null;
        $script_min_path = apply_filters('raz/filter/js_load_min_file', 'min/');

        $styleNeedRemove = array(
            'yith-woocompare-widget',
            'jquery-selectBox',
            'yith-wcwl-font-awesome',
            'woocomposer-front-slick',
            'jquery-colorbox',
            'dokan-fontawesome'
        );
        $scriptNeedRemove = array(
            'woocomposer-slick',
            'jquery-slick'
        );

        foreach ($styleNeedRemove as $style) {
            if (wp_style_is($style, 'registered')) {
                wp_deregister_style($style);
            }
        }
        foreach ($scriptNeedRemove as $script) {
            if (wp_script_is($script, 'registered')) {
                wp_dequeue_script($script);
            }
        }

        wp_enqueue_style('font-awesome', Raz::$template_dir_url . '/assets/css/font-awesome.min.css', array(), $theme_version);
        wp_enqueue_style('raz-lastudioicon', Raz::$template_dir_url . '/assets/css/lastudioicon.css', array(), $theme_version);
        wp_enqueue_style('raz-theme', get_template_directory_uri() . '/style.css', array(), $theme_version);


        /*
         * Scripts
         */

        $font_source = Raz()->settings()->get('font_source', 1);
        switch ($font_source) {
            case '1':
                wp_enqueue_style('raz-google-fonts', raz_get_google_fonts_url(), array(), null);
                break;
            case '2':
                wp_enqueue_style('raz-font-google-code', $this->get_google_font_code_url(), array(), null);
                break;
            case '3':
                wp_enqueue_script('raz-font-typekit', $this->get_google_font_typekit_url(), array(), null);
                wp_add_inline_script( 'raz-font-typekit', 'try{ Typekit.load({ async: true }) }catch(e){}' );
                break;
        }

        wp_enqueue_script( 'respond', Raz::$template_dir_url . '/assets/js/enqueue/min/respond.js');
        wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

        wp_register_script( 'raz-modernizr-custom', Raz::$template_dir_url . '/assets/js/enqueue/min/modernizr-custom.js', array('jquery'), $theme_version, true);

        $fullpage_config = array();
        $js_require = array('jquery','raz-modernizr-custom');

        if(apply_filters('raz/filter/force_enqueue_js_external', true)){
            wp_register_script('raz-plugins', Raz::$template_dir_url . '/assets/js/plugins/min/plugins-full.js', array('jquery'), $theme_version, true);
            $js_require[] = 'raz-plugins';
        }

        wp_enqueue_script('raz-theme', Raz::$template_dir_url . '/assets/js/app.js', $js_require, $theme_version, true);

        wp_localize_script('raz-theme', 'la_theme_config', apply_filters('raz/filter/global_message_js', array(
            'security' => array(
                'favorite_posts' => wp_create_nonce('favorite_posts'),
                'wishlist_nonce' => wp_create_nonce('wishlist_nonce'),
                'compare_nonce' => wp_create_nonce('compare_nonce')
            ),
            'fullpage' => $fullpage_config,
            'product_single_design' => esc_attr(Raz()->settings()->get('woocommerce_product_page_design', 1)),
            'product_gallery_column' => esc_attr(json_encode(Raz()->settings()->get('product_gallery_column', array(
                'xlg'	=> 3,
                'lg' 	=> 3,
                'md' 	=> 3,
                'sm' 	=> 5,
                'xs' 	=> 4,
                'mb' 	=> 3
            )))),
            'single_ajax_add_cart' => esc_attr(Raz()->settings()->get('single_ajax_add_cart', 'off')),
            'i18n' => array(
                'backtext' => esc_attr_x('Back', 'front-view', 'raz'),
                'compare' => array(
                    'view' => esc_attr_x('View List Compare', 'front-view', 'raz'),
                    'success' => esc_attr_x('has been added to comparison list.', 'front-view', 'raz'),
                    'error' => esc_attr_x('An error occurred ,Please try again !', 'front-view', 'raz')
                ),
                'wishlist' => array(
                    'view' => esc_attr_x('View List Wishlist', 'front-view', 'raz'),
                    'success' => esc_attr_x('has been added to your wishlist.', 'front-view', 'raz'),
                    'error' => esc_attr_x('An error occurred, Please try again !', 'front-view', 'raz')
                ),
                'addcart' => array(
                    'view' => esc_attr_x('View Cart', 'front-view', 'raz'),
                    'success' => esc_attr_x('has been added to your cart', 'front-view', 'raz'),
                    'error' => esc_attr_x('An error occurred, Please try again !', 'front-view', 'raz')
                ),
                'global' => array(
                    'error' => esc_attr_x('An error occurred ,Please try again !', 'front-view', 'raz'),
                    'comment_author' => esc_attr_x('Please enter Name !', 'front-view', 'raz'),
                    'comment_email' => esc_attr_x('Please enter Email Address !', 'front-view', 'raz'),
                    'comment_rating' => esc_attr_x('Please select a rating !', 'front-view', 'raz'),
                    'comment_content' => esc_attr_x('Please enter Comment !', 'front-view', 'raz'),
                    'continue_shopping' => esc_attr_x('Continue Shopping', 'front-view', 'raz'),
                    'cookie_disabled' => esc_attr_x('We are sorry, but this feature is available only if cookies are enabled on your browser', 'front-view', 'raz')
                )
            ),
            'popup' => array(
                'max_width' => esc_attr(Raz()->settings()->get('popup_max_width', 790)),
                'max_height' => esc_attr(Raz()->settings()->get('popup_max_height', 430))
            ),
            'js_path'       => esc_attr(Raz::$template_dir_url . '/assets/js/plugins/' . $script_min_path),
            'theme_path'    => esc_attr(Raz::$template_dir_url . '/'),
            'ajax_url'      => esc_attr(admin_url('admin-ajax.php')),
            'mm_mb_effect' => esc_attr(Raz()->settings()->get('mm_mb_effect', 1)),
            'header_height' => array(
                'desktop' => array(
                    'normal' => esc_attr(str_replace('px', '', Raz()->settings()->get('header_height', 100))),
                    'sticky' => esc_attr(str_replace('px', '', Raz()->settings()->get('header_sticky_height', 80)))
                ),
                'tablet' => array(
                    'normal' => esc_attr(str_replace('px', '', Raz()->settings()->get('header_sm_height', 100))),
                    'sticky' => esc_attr(str_replace('px', '', Raz()->settings()->get('header_sm_sticky_height', 80)))
                ),
                'mobile' => array(
                    'normal' => esc_attr(str_replace('px', '', Raz()->settings()->get('header_mb_height', 100))),
                    'sticky' => esc_attr(str_replace('px', '', Raz()->settings()->get('header_mb_sticky_height', 80)))
                )
            ),
            'la_extension_available' => get_option('la_extension_available', array(
                'swatches' => true,
                '360' => false,
                'content_type' => true
            )),
            'mobile_bar' => esc_attr(Raz()->settings()->get('enable_header_mb_footer_bar_sticky', 'always'))
        )));

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        wp_add_inline_style('raz-theme', Raz_Helper::compress_text($this->dynamic_css(), true));

        $asset_font_without_domain = apply_filters('raz/filter/assets_font_url', raz_get_relative_url(untrailingslashit(get_template_directory_uri())));

        wp_add_inline_style(
            "font-awesome",
            "@font-face{
                font-family: 'FontAwesome';
                src: url('{$asset_font_without_domain}/assets/fonts/fontawesome-webfont.eot');
                src: url('{$asset_font_without_domain}/assets/fonts/fontawesome-webfont.eot') format('embedded-opentype'),
                     url('{$asset_font_without_domain}/assets/fonts/fontawesome-webfont.woff2') format('woff2'),
                     url('{$asset_font_without_domain}/assets/fonts/fontawesome-webfont.woff') format('woff'),
                     url('{$asset_font_without_domain}/assets/fonts/fontawesome-webfont.ttf') format('truetype'),
                     url('{$asset_font_without_domain}/assets/fonts/fontawesome-webfont.svg') format('svg');
                font-weight:normal;
                font-style:normal
            }"
        );

        wp_add_inline_style(
            "raz-lastudioicon",
            "@font-face{
                font-family: 'LaStudioIcons';
                src: url('{$asset_font_without_domain}/assets/fonts/LaStudioIcons.eot');
                src: url('{$asset_font_without_domain}/assets/fonts/LaStudioIcons.eot') format('embedded-opentype'),
                     url('{$asset_font_without_domain}/assets/fonts/LaStudioIcons.woff2') format('woff2'),
                     url('{$asset_font_without_domain}/assets/fonts/LaStudioIcons.woff') format('woff'),
                     url('{$asset_font_without_domain}/assets/fonts/LaStudioIcons.ttf') format('truetype'),
                     url('{$asset_font_without_domain}/assets/fonts/LaStudioIcons.svg') format('svg');
                font-weight:normal;
                font-style:normal
            }"
        );

    }

    /**
     * Removes WooCommerce scripts.
     *
     * @access public
     * @since 1.0
     * @param array $scripts The WooCommerce scripts.
     * @return array
     */
    public function remove_woo_scripts($scripts)
    {

        if (isset($scripts['woocommerce-layout'])) {
            unset($scripts['woocommerce-layout']);
        }
        if (isset($scripts['woocommerce-smallscreen'])) {
            unset($scripts['woocommerce-smallscreen']);
        }
        if (isset($scripts['woocommerce-general'])) {
            unset($scripts['woocommerce-general']);
        }
        return $scripts;

    }

    private function dynamic_css()
    {
        ob_start();
        include Raz::$template_dir_path . '/framework/functions/additional_css.php';
        include Raz::$template_dir_path . '/framework/functions/dynamic_css.php';
        return ob_get_clean();
    }

    public function get_custom_css_from_setting(){
        if( $la_custom_css = Raz()->settings()->get('la_custom_css') ){
            printf( '<%1$s id="raz-extra-custom-css">%2$s</%1$s>', 'style', $la_custom_css);
        }
    }

    /**
    * Add async to theme javascript file for performance
    * allow override on `lastudio/theme/defer_scripts` filter
    * @param string $handlers The script tag.
    */

    public function override_defer_scripts( $handlers )
    {
        $handlers[] = 'raz-modernizr-custom';
        $handlers[] = 'raz-plugins';
        $handlers[] = 'raz-theme';
        return $handlers;
    }


    public function get_gfont_from_setting(){
        $array = array();
        $main_font = Raz()->settings()->get('main_font');
        $secondary_font = Raz()->settings()->get('secondary_font');
        $highlight_font = Raz()->settings()->get('highlight_font');

        if(!empty($main_font['family'])){
            $array['body'] = $main_font['family'];
        }
        if(!empty($secondary_font['family'])){
            $array['heading'] = $secondary_font['family'];
        }
        if(!empty($highlight_font['family'])){
            $array['highlight'] = $highlight_font['family'];
        }
        return $array;
    }

    public function get_google_font_url(){

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
        return esc_url( add_query_arg('family', implode( '%7C', $_tmp_fonts2 ),'//fonts.googleapis.com/css') );
    }

    public function get_google_font_code_url() {
        $fonts_url = '';
        $_font_code = Raz()->settings()->get('font_google_code', '');
        if(!empty($_font_code)){
            $fonts_url = $_font_code;
        }
        return esc_url($fonts_url);
    }

    public function get_google_font_typekit_url(){
        $fonts_url = '';
        $_api_key = Raz()->settings()->get('font_typekit_kit_id', '');
        if(!empty($_api_key)){
            $fonts_url =  '//use.typekit.net/' . preg_replace('/\s+/', '', $_api_key) . '.js';
        }
        return esc_url($fonts_url);
    }

    public function add_custom_header_js(){
        printf( '<%1$s>try{ %2$s }catch (ex){}</%1$s>', 'script', Raz()->settings()->get('header_js') );
    }

    public function add_custom_footer_js(){
        printf( '<%1$s>try{ %2$s }catch (ex){}</%1$s>', 'script', Raz()->settings()->get('footer_js') );
    }

    public function add_meta_into_head(){
        do_action('raz/action/head');
    }

    public function editor_customizer_generated_values(){
        $font_source = Raz()->settings()->get('font_source', 1);
        $body_font_family = '';
        $heading_font_family = '';
        switch ($font_source) {
            case '1':
                $_s_main_font = (array) Raz()->settings()->get('main_font');
                $_s_secondary_font = (array) Raz()->settings()->get('secondary_font');

                if(!empty($_s_main_font['family'])){
                    $body_font_family = '"' . $_s_main_font['family'] . '", "Helvetica Neue", Arial, sans-serif';
                }
                if(!empty($_s_secondary_font['family'])){
                    $heading_font_family = '"' . $_s_secondary_font['family'] . '", "Helvetica Neue", Arial, sans-serif';
                }
                break;

            case '2':
                $body_font_family = Raz()->settings()->get('main_google_font_face');
                $heading_font_family = Raz()->settings()->get('secondary_google_font_face');
                break;

            case '3':
                $body_font_family = Raz()->settings()->get('main_typekit_font_face');
                $heading_font_family = Raz()->settings()->get('secondary_typekit_font_face');
                break;
        }

        $css = '';
        $css .= '.edit-post-visual-editor.editor-styles-wrapper { font-family:'. wp_kses_post($body_font_family) .'; }';
        $css .= '.editor-styles-wrapper .editor-post-title__input, .editor-styles-wrapper h1,.editor-styles-wrapper h2,.editor-styles-wrapper h3,.editor-styles-wrapper h4,.editor-styles-wrapper h5,.editor-styles-wrapper h6{ font-family:'. wp_kses_post($heading_font_family) .'; }';
        return wp_strip_all_tags( $css );
    }

    public function editor_customizer_styles(){
        // Register Customizer styles within the editor to use for inline additions.
        wp_register_style( 'raz-editor-customizer-styles', false);
        // Enqueue the Customizer style.
        wp_enqueue_style( 'raz-editor-customizer-styles' );
        // Add custom colors to the editor.
        wp_add_inline_style( 'raz-editor-customizer-styles', $this->editor_customizer_generated_values() );
    }
}