<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    LaStudio
 * @subpackage LaStudio/includes
 * @author     Duy Pham <dpv.0990@gmail.com>
 */
class LaStudio {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      LaStudio_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	protected $extensions = array();

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'LASTUDIO_VERSION' ) ) {
			$this->version = LASTUDIO_VERSION;
		}
		else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'lastudio';

		$this->extensions = get_option('la_extension_available', array(
			'swatches' => true,
			'360' => false,
			'content_type' => true
		));

		// register autoloader
		spl_autoload_register( array( $this, 'autoload' ) );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_extension_hooks();

	}

	public function autoload( $class ) {
		// check if class is in same namespace, if not return
		if ( strpos( $class, 'LaStudio_Theme_Options_Field' ) !== 0 ) {
			return;
		}

		$class = str_replace('LaStudio_Theme_Options_Field_', '', $class);

		// make the class name lowercase and replace underscores with dashes
		$class = strtolower( str_replace( '_', '-', $class ) );
		// build path to class file
		$path = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/theme-options/';

		if($class == 'base'){
			$path = $path .'base.php';
		}
		else{
			$path = $path . 'fields/' . $class . '.php';
		}

		// include file if it exists
		if ( file_exists( $path ) ) {
			include_once ( $path );
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - LaStudio_Loader. Orchestrates the hooks of the plugin.
	 * - LaStudio_i18n. Defines internationalization functionality.
	 * - LaStudio_Admin. Defines all hooks for the admin area.
	 * - LaStudio_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$plugin_dir_path = plugin_dir_path( dirname( __FILE__ ) );

		/**
		 * Load public functions
		 */

		require_once $plugin_dir_path . 'public/lastudio-functions.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once $plugin_dir_path . 'includes/class-lastudio-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once $plugin_dir_path . 'includes/class-lastudio-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once $plugin_dir_path . 'admin/class-lastudio-admin.php';

		require_once $plugin_dir_path . 'admin/class-lastudio-theme-options.php';

		//require_once $plugin_dir_path . 'admin/class-lastudio-postmeta-revisions.php';

		require_once $plugin_dir_path . 'admin/class-lastudio-metabox.php';

		require_once $plugin_dir_path . 'admin/class-lastudio-content-type.php';

		require_once $plugin_dir_path . 'admin/class-lastudio-taxonomy.php';

		require_once $plugin_dir_path . 'admin/class-lastudio-theme-customize.php';

		require_once $plugin_dir_path . 'public/class-lastudio-cache-helper.php';

		/**
		 * Load Extensions
		 */

		require_once $plugin_dir_path . 'admin/class-lastudio-woocommerce-import-export.php';

		/**
		 * Shortcodes
		 */

		/**
		 * Load WooCommerce ThreeSixty
		 */
		if(!empty($this->extensions['360'])) {
			require_once $plugin_dir_path . 'includes/extensions/threesixty/class-lastudio-woocommerce-threesixty.php';
		}

		/**
		 * Swatches
		 */

		if(!empty($this->extensions['swatches'])){
			require_once $plugin_dir_path . 'includes/extensions/swatch/class-lastudio-swatch-attribute-configuration-object.php';
			require_once $plugin_dir_path . 'includes/extensions/swatch/class-lastudio-swatch-term.php';
			require_once $plugin_dir_path . 'includes/extensions/swatch/class-lastudio-swatch-product-term.php';
			require_once $plugin_dir_path . 'includes/extensions/swatch/class-lastudio-swatch.php';
		}

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once $plugin_dir_path . 'public/class-lastudio-public.php';

		$this->loader = new LaStudio_Loader();

		LaStudio_Cache_Helper::init();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the LaStudio_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new LaStudio_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new LaStudio_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 999 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 999 );
		$this->loader->add_action( 'customize_controls_enqueue_scripts', $plugin_admin, 'admin_customize_enqueue' );

		/** Load Sanitize & Validate For Theme Options **/

		$this->loader->add_action( 'la_sanitize_text', $plugin_admin, 'sanitize_text' );
		$this->loader->add_action( 'la_sanitize_textarea', $plugin_admin, 'sanitize_textarea' );
		$this->loader->add_action( 'la_sanitize_checkbox', $plugin_admin, 'sanitize_checkbox' );
		$this->loader->add_action( 'la_sanitize_switcher', $plugin_admin, 'sanitize_checkbox' );
		$this->loader->add_action( 'la_sanitize_image_select', $plugin_admin, 'sanitize_image_select' );
		$this->loader->add_action( 'la_sanitize_group', $plugin_admin, 'sanitize_group' );
		$this->loader->add_action( 'la_sanitize_title', $plugin_admin, 'sanitize_title' );
		$this->loader->add_action( 'la_sanitize_clean', $plugin_admin, 'sanitize_clean' );


		$this->loader->add_action( 'la_validate_email', $plugin_admin, 'validate_email' );
		$this->loader->add_action( 'la_validate_numeric', $plugin_admin, 'validate_numeric' );
		$this->loader->add_action( 'la_validate_required', $plugin_admin, 'validate_required' );


		$this->loader->add_action( 'admin_footer', $plugin_admin, 'render_admin_footer' );
		$this->loader->add_action( 'customize_controls_print_footer_scripts', $plugin_admin, 'render_admin_footer' );


		/** Register Ajax Action **/

		$this->loader->add_action( 'wp_ajax_la-fw-get-icons', $plugin_admin, 'ajax_get_icons' );
		$this->loader->add_action( 'wp_ajax_la-fw-autocomplete', $plugin_admin, 'ajax_autocomplete' );
		$this->loader->add_action( 'wp_ajax_la-export-options', $plugin_admin, 'ajax_export_options' );


		/*
		$PostMeta_Revisions = new LaStudio_PostMeta_Revisions();
        // When restoring a revision, also restore that revisions's revisioned meta.
        $this->loader->add_action( 'wp_restore_post_revision', $PostMeta_Revisions, '_wp_restore_post_revision_meta' , 10, 2 );
        // When creating or updating an autosave, save any revisioned meta fields.
        $this->loader->add_action( 'wp_creating_autosave', $PostMeta_Revisions , '_wp_autosave_post_revisioned_meta_fields' );
        $this->loader->add_action( 'wp_before_creating_autosave', $PostMeta_Revisions, '_wp_autosave_post_revisioned_meta_fields' );
        // When creating a revision, also save any revisioned meta.
        $this->loader->add_action( '_wp_put_post_revision', $PostMeta_Revisions, '_wp_save_revisioned_meta_fields'  );
        //Filters
        // When revisioned post meta has changed, trigger a revision save.
        $this->loader->add_filter( 'wp_save_post_revision_post_has_changed', $PostMeta_Revisions, '_wp_check_revisioned_meta_fields_have_changed', 10, 3 );

        // Add the revisioned meta to get_post_metadata for preview meta data.
        $this->loader->add_filter( 'get_post_metadata', $PostMeta_Revisions, '_wp_preview_meta_filter' , 10, 4 );
		*/
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new LaStudio_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'allowed_http_origins', $plugin_public, 'allowed_http_origins', 20, 1 );

		if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
			$this->loader->add_action('script_loader_tag', $plugin_public, 'add_async', 20, 3);
			$this->loader->add_action('style_loader_tag', $plugin_public, 'remove_style_attr', 20, 2);
		}

		$this->loader->add_action('woocommerce_loaded', $plugin_public, 'remove_woocommerce_hook');

		$this->loader->add_action( 'widgets_init', $plugin_public, 'widgets_init', 15 );
	}

	/**
	 * Register all of the hook related to the extenstion
	 * @since 1.0.0
	 * @access private
	 */
	private function define_extension_hooks() {
		/**
		 * Register content types
		 */

        if(!empty($this->extensions['content_type'])) {

            $post_types = array(
                'la_team_member' => array(
                    'label' => __('Team Member', 'lastudio'),
                    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
                    'menu_icon' => 'dashicons-groups',
                    'public' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'menu_position' => 8,
                    'show_in_admin_bar' => false,
                    'show_in_nav_menus' => false,
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => true,
                    'publicly_queryable' => true,
                    'rewrite' => array('slug' => 'team-member')
                ),
                'la_portfolio'      => array(
                    'label'                 => __( 'Portfolio', 'lastudio' ),
                    'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'menu_icon'             => 'dashicons-portfolio',
                    'public'                => true,
                    'menu_position'         => 8,
                    'can_export'            => true,
                    'has_archive'           => true,
                    'exclude_from_search'   => false,
                    'rewrite'               => array( 'slug' => 'portfolio' )
                )
            );
            $taxonomies = array(
                'la_portfolio_category' => array(
                    'post_type' => 'la_portfolio',
                    'args'  => array(
                        'hierarchical'      => true,
                        'show_in_nav_menus' => true,
                        'labels'            => array(
                            'name'          => __( 'Portfolio Categories', 'lastudio' ),
                            'singular_name' => __( 'Portfolio Category', 'lastudio' )
                        ),
                        'query_var'         => true,
                        'show_admin_column' => true,
                        'rewrite'           => array('slug' => 'portfolio-category')
                    )
                ),
            );
            $content_types = new LaStudio_Content_Type($post_types, $taxonomies);

            $this->loader->add_action('init', $content_types, 'setup_filters', 8);
            $this->loader->add_action('init', $content_types, 'register_content_type');
            $this->loader->add_filter('single_template', $content_types, 'single_template');
            $this->loader->add_filter('archive_template', $content_types, 'archive_template', 10);
            $this->loader->add_filter('taxonomy_template', $content_types, 'taxonomy_template', 10);
        }

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if(is_plugin_active('woocommerce/woocommerce.php')){
			/**
			 * Load WooCommerce ThreeSixty
			 */
			if(!empty($this->extensions['360'])) {
				$threesixty_extension = new LaStudio_WooCommerce_Threesixty();
				$this->loader->add_action('woocommerce_product_write_panel_tabs', $threesixty_extension, 'threesixty_product_write_panel_tabs', 99);
				$this->loader->add_action('woocommerce_product_data_panels', $threesixty_extension, 'threesixty_product_data_panel_wrap', 99);
				$this->loader->add_action('woocommerce_process_product_meta', $threesixty_extension, 'threesixty_save_product_meta', 1, 2);
				$this->loader->add_action('edit_attachment', $threesixty_extension, 'threesixty_save_embed_video');
				$this->loader->add_action('wp', $threesixty_extension, 'threesixty_replace_product_image');
			}
			/**
			 * Load WooCommerce Swatches
			 */
			if(!empty($this->extensions['swatches'])) {
				$swatches = new LaStudio_Swatch();
				$this->loader->add_action( 'created_term', $swatches, 'saveTermMeta', 10, 3 );
				$this->loader->add_action( 'edit_term', $swatches, 'saveTermMeta', 10, 3 );
				$this->loader->add_action( 'wp_ajax_la_swatch_admin_load_thumbnails', $swatches, 'admin_load_variation_gallery' );
				$this->loader->add_action( 'woocommerce_save_product_variation', $swatches, 'save_gallery_for_product_variation', 10, 2 );
				$this->loader->add_action( 'admin_menu', $swatches, 'admin_menu' );
				$this->loader->add_action( 'admin_init', $swatches, 'admin_init', 99 );
				$this->loader->add_action( 'woocommerce_product_write_panel_tabs', $swatches, 'product_write_panel_tabs', 99 );
				$this->loader->add_action( 'woocommerce_product_data_panels', $swatches, 'product_data_panel_wrap', 99 );
				$this->loader->add_action( 'woocommerce_process_product_meta', $swatches, 'process_meta_box', 1, 2 );
				$this->loader->add_action( 'wp_ajax_la_swatch_get_product_variations', $swatches, 'get_product_variations' );
				$this->loader->add_action( 'wp_ajax_nopriv_la_swatch_get_product_variations', $swatches, 'get_product_variations' );
				$this->loader->add_action( 'woocommerce_delete_product_transients', $swatches, 'on_deleted_transient', 10, 1 );
				$this->loader->add_action( 'wp_ajax_la_render_swatches_panel', $swatches, 'ajax_render_swatches_panel' );
				$this->loader->add_filter( 'woocommerce_available_variation', $swatches, 'add_additional_into_variation_json', 10, 3 );
				$this->loader->add_action( 'widgets_init', $swatches, 'init_swatches_widget', 15 );

				$this->loader->add_filter( 'woocommerce_dropdown_variation_attribute_options_html', $swatches, 'override_output_dropdown_variation_attribute_options', 101, 3 );

			}

			$wc_import_export = new LaStudio_WooCommerce_Import_Export();
			$this->loader->add_filter( 'woocommerce_product_export_skip_meta_keys', $wc_import_export, 'export_skip_meta_keys', 10, 1 );
			$this->loader->add_filter( 'woocommerce_product_export_product_default_columns', $wc_import_export, 'export_product_default_columns', 10, 1 );
			$this->loader->add_filter( 'woocommerce_product_export_product_column_lastudio_enable_360', $wc_import_export, 'export_product_column_threesixty', 10, 3 );
			$this->loader->add_filter( 'woocommerce_product_export_product_column_lastudio_swatch_type', $wc_import_export, 'export_product_column_swatch_type', 10, 3 );
			$this->loader->add_filter( 'woocommerce_product_export_product_column_lastudio_swatch_data', $wc_import_export, 'export_product_column_swatch_data', 10, 3 );
			$this->loader->add_filter( 'woocommerce_csv_product_import_mapping_default_columns', $wc_import_export, 'import_mapping_default_columns', 10, 1 );
			$this->loader->add_filter( 'woocommerce_csv_product_import_mapping_options', $wc_import_export, 'import_mapping_options', 10, 1 );
			$this->loader->add_filter( 'woocommerce_product_import_pre_insert_product_object', $wc_import_export, 'import_pre_insert_product_object', 10, 2 );
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    LaStudio_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}