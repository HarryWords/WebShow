<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

class Raz_Admin {

    public $section_names           = array();
    public $metabox_section_names   = array();

    public $sections                = array();
    public $metabox_sections        = array();

    public function __construct(){

        $this->section_names = array(
            'general',
            'fonts',
            'header',
            'page_title_bar',
            'sidebar',
            'footer',
            'blog',
            'woocommerce',
            'portfolio',
            '404'
        );
        $this->metabox_section_names = array(
            'post',
            'member',
            'layout',
            'header',
            'page_title_bar',
            'footer',
            'product'
        );

        add_action( 'init', array( $this, 'init_actions' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts') );
        add_action( 'customize_register', array( $this, 'override_customize_control') );

        add_action( 'wp_ajax_raz_core_action', array( $this, 'ajax_action' ) );
        add_action( 'widgets_init', array( $this, 'init_dynamic_sidebar' ) );

        add_action( 'lastudio/filter/allow_revision_meta_keys', array( $this, 'register_revision_meta_keys' ) );

        new Raz_MegaMenu_Init();
    }

    /**
     * Include required files.
     *
     * @access public
     */
    public function include_files() {

        foreach ( $this->section_names as $section ) {
            include_once Raz::$template_dir_path . '/framework/configs/options/' . $section . '.php';
        }

        foreach ( $this->metabox_section_names as $section ) {
            include_once Raz::$template_dir_path . '/framework/configs/metaboxes/' . $section . '.php';
        }
    }


    /**
     * Sets the fields.
     *
     * @access public
     */
    public function set_sections() {

        $sections = array();
        foreach ( $this->section_names as $section ) {
            $sections = call_user_func( 'raz_options_section_' . $section, $sections );
        }
        $this->sections = apply_filters( 'raz_options_sections', $sections );

        $metabox_sections = array();
        foreach ( $this->metabox_section_names as $metabox ) {
            $metabox_sections = call_user_func( 'raz_metaboxes_section_' . $metabox, $metabox_sections );
        }
        $this->metabox_sections = apply_filters( 'raz_metaboxes_sections', $metabox_sections );
    }

    public function init_actions(){

        $this->include_files();
        $this->set_sections();

        $this->init_page_options();
        $this->init_meta_box();
    }

    public function ajax_action(){

        check_ajax_referer( 'admin_load_nonce', 'admin_load_nonce' );

        $router = isset($_REQUEST['router']) ? sanitize_text_field($_REQUEST['router']) : '';

        switch ($router){

            case 'add_sidebar':
                $this->ajax_add_sidebar();
                break;

            case 'remove_sidebar':
                $this->ajax_remove_sidebar();
                break;

            default:
                // does not allow to do anything on here !!!!!
        }

        wp_die();

    }

    private function ajax_add_sidebar(){
        if ( current_user_can( 'manage_options' ) ) {
            $raz_widgets = get_theme_mod( 'raz_widgets' );
            $number = $raz_widgets ? intval( $raz_widgets['number'] ) + 1 : 1;
            $widget_area_name = sanitize_text_field( $_POST['widget_area_name'] );
            $raz_widgets['areas']['raz_widget_area_' . $number] = $widget_area_name;
            $raz_widgets['number'] = $number;

            set_theme_mod( 'raz_widgets', $raz_widgets );

            wp_send_json_success( array(
                'message' => sprintf(__( '<strong>%1$s</strong> widget area has been created. You can create more areas, once you finish update the page to see all the areas.', 'raz' ), esc_html( $widget_area_name ))
            ) );
        }
    }

    private function ajax_remove_sidebar(){
        if ( current_user_can( 'manage_options' ) ) {
            $raz_widgets = get_theme_mod( 'raz_widgets' );

            $widget_area_name = sanitize_text_field( $_POST['widget_area_name'] );

            unset( $raz_widgets['areas'][ $widget_area_name ] );

            set_theme_mod( 'raz_widgets', $raz_widgets );

            wp_send_json_success( array(
                'message' => sprintf(__( '<strong>%1$s</strong> widget area has been deleted.', 'raz' ), esc_html( $widget_area_name )),
                'sidebar_id' => esc_html($widget_area_name)
            ) );
        }
    }

    public function init_dynamic_sidebar(){

        $raz_widgets = get_theme_mod( 'raz_widgets' );
        if ( !empty($raz_widgets['areas']) ) {
            foreach ( $raz_widgets['areas'] as $id => $name ) {
                register_sidebar(array(
                    'name'          => sanitize_text_field( $name ),
                    'id'            => sanitize_text_field( $id ),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="widget-title"><span>',
                    'after_title'   => '</span></h3>'
                ));
            }
        }
    }

    public function admin_scripts( $hook ){

        wp_enqueue_style('raz-admin-css', Raz::$template_dir_url. '/assets/admin/css/admin.css');
        wp_enqueue_script('raz-admin-theme', Raz::$template_dir_url . '/assets/admin/js/admin.js', array( 'jquery'), false, true );


        if ( $hook === 'widgets.php' ) {
            wp_localize_script( 'raz-admin-theme', 'raz_sidebar_options', array(
                'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                'admin_load_nonce' => wp_create_nonce( 'admin_load_nonce' ),
                'widget_info'   => sprintf( '<div id="la_pb_widget_area_create"><p>%1$s.</p><p><label>%2$s <input id="la_pb_new_widget_area_name" value="" /></label><button class="button button-primary la_pb_create_widget_area">%3$s</button></p><p class="la_pb_widget_area_result"></p></div>',
                    esc_html__( 'Here you can create new widget areas for use in the Sidebar module', 'raz' ),
                    esc_html__( 'Widget Name', 'raz' ),
                    esc_html__( 'Create', 'raz' )
                ),
                'confirm_delete_string' => esc_html__( 'Are you sure ?', 'raz' ),
                'delete_string' => esc_html__( 'Delete', 'raz' )
            ) );
        }
    }

    private function init_page_options(){

        if(class_exists('LaStudio_Theme_Options') && !empty($this->sections)) {
            $settings = array(
                'menu_title' => esc_html_x('Theme Options', 'admin-view', 'raz'),
                'menu_type' => 'theme',
                'menu_slug' => 'theme_options',
                'ajax_save' => false,
                'show_reset_all' => true,
                'disable_header' => false,
                'framework_title' => esc_html_x('Raz', 'admin-view', 'raz')
            );
            LaStudio_Theme_Options::instance( $settings, $this->sections, Raz::get_option_name());
        }
        if(class_exists('LaStudio_Theme_Customize') && function_exists('la_convert_option_to_customize')){
            if(!empty($this->sections)){
                $customize_options = la_convert_option_to_customize($this->sections);
                LaStudio_Theme_Customize::instance( $customize_options, Raz::get_option_name());
            }
        }
    }

    private function get_metabox_by_sections( $section_name = array() ){
        $sections = array();
        if(!empty($this->metabox_sections) && !empty($section_name)){
            foreach( $section_name as $item ){
                if(!empty($this->metabox_sections[$item])){
                    $sections[$item] = $this->metabox_sections[$item];
                }
            }
        }
        return $sections;
    }
    
    private function init_meta_box(){

        if(!class_exists('LaStudio_Metabox') || empty($this->metabox_sections)){
            return;
        }

        $metaboxes = array();
        $taxonomy_metaboxes = array();

        /**
         * Pages
         */
        $metaboxes[] = array(
            'id'        => Raz::get_original_option_name(),
            'title'     => esc_html_x('Page Options', 'admin-view', 'raz'),
            'post_type' => 'page',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => $this->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer'
            ))
        );

        /**
         * Post
         */
        $metaboxes[] = array(
            'id'        => Raz::get_original_option_name(),
            'title'     => esc_html_x('Post Options', 'admin-view', 'raz'),
            'post_type' => 'post',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => $this->get_metabox_by_sections(array(
                'post',
                'layout',
                'header',
                'page_title_bar',
                'footer'
            ))
        );

        /**
         * Product
         */
        $metaboxes[] = array(
            'id'        => Raz::get_original_option_name(),
            'title'     => esc_html_x('Product View Options', 'admin-view', 'raz'),
            'post_type' => 'product',
            'context'   => 'normal',
            'priority'  => 'default',
            'sections'  => $this->get_metabox_by_sections(array(
                'product',
                'layout',
                'header',
                'page_title_bar',
                'footer'
            ))
        );
        /**
         * Member
         */
        $metaboxes[] = array(
            'id'        => Raz::get_original_option_name(),
            'title'     => esc_html_x('Page Options', 'admin-view', 'raz'),
            'post_type' => 'la_team_member',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => $this->get_metabox_by_sections(array(
                'member',
                'layout',
                'header',
                'page_title_bar',
                'footer'
            ))
        );

        /**
         * Product Category
         */
        $taxonomy_metaboxes[] = array(
            'id'        => Raz::get_original_option_name(),
            'title'     => esc_html_x('Product Category Options', 'admin-view', 'raz'),
            'taxonomy' => 'product_cat',
            'sections'  => $this->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer'
            ))
        );

        /**
         * Category
         */
        $taxonomy_metaboxes[] = array(
            'id'        => Raz::get_original_option_name(),
            'title'     => esc_html_x('Category Options', 'admin-view', 'raz'),
            'taxonomy' => 'category',
            'sections'  => $this->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer'
            ))
        );

        /**
         * Playlist
         */
        $metaboxes[] = array(
            'id'        => Raz::get_original_option_name(),
            'title'     => esc_html_x('Page Options', 'admin-view', 'raz'),
            'post_type' => 'lpm_playlist',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => $this->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer'
            ))
        );

        LaStudio_Metabox::instance($metaboxes);
        LaStudio_Taxonomy::instance($taxonomy_metaboxes);
    }

    public function override_customize_control( $wp_customize ) {
        $wp_customize->remove_section('colors');
        $wp_customize->remove_section('header_image');
        $wp_customize->remove_section('background_image');
    }

    public function register_revision_meta_keys( $key ) {
        $key[] = Raz::get_original_option_name();
        return $key;
    }

}