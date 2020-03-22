<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    LaStudio
 * @subpackage LaStudio/admin
 * @author     Duy Pham <dpv.0990@gmail.com>
 */
class LaStudio_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in LaStudio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The LaStudio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_deregister_style('jquery-chosen');

		if(wp_style_is('font-awesome', 'registered')) {
			wp_deregister_style('font-awesome');
		}

		// wp core styles
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lastudio-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'font-awesome', plugin_dir_url( dirname(__FILE__) ) . 'public/css/font-awesome.min.css', array(), null);

		if ( is_rtl() ) {
			wp_enqueue_style( $this->plugin_name . '-rtl', plugin_dir_url(__FILE__) . 'css/lastudio-admin-rtl.css', array(), $this->version, 'all');
		}

		$asset_font_without_domain = apply_filters('LaStudio/filter/assets_font_url', untrailingslashit(plugin_dir_url( dirname(__FILE__) )));

		wp_add_inline_style(
			$this->plugin_name,
			"@font-face {
				font-family: 'icomoon';
				src:url('{$asset_font_without_domain}/public/fonts/icomoon.ttf');
				font-weight: normal;
				font-style: normal;
			}"
		);

		wp_add_inline_style(
			'font-awesome',
			"@font-face{
				font-family: 'FontAwesome';
				src: url('{$asset_font_without_domain}/public/fonts/fontawesome-webfont.eot');
				src: url('{$asset_font_without_domain}/public/fonts/fontawesome-webfont.eot') format('embedded-opentype'),
					 url('{$asset_font_without_domain}/public/fonts/fontawesome-webfont.woff2') format('woff2'),
					 url('{$asset_font_without_domain}/public/fonts/fontawesome-webfont.woff') format('woff'),
					 url('{$asset_font_without_domain}/public/fonts/fontawesome-webfont.ttf') format('truetype'),
					 url('{$asset_font_without_domain}/public/fonts/fontawesome-webfont.svg') format('svg');
				font-weight:normal;
				font-style:normal
			}"
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in LaStudio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The LaStudio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_deregister_script('jquery-chosen');
		// admin utilities
		wp_enqueue_media();

		$script_dependencies = array(
			'jquery',
			'wp-color-picker',
			'jquery-ui-dialog',
			'jquery-ui-sortable',
			'jquery-ui-accordion'
		);

		wp_register_script( 'lastudio-plugins', plugin_dir_url( __FILE__ ) . 'js/lastudio-admin-plugin.js', $script_dependencies, $this->version, true );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lastudio-admin.js', array( 'lastudio-plugins' ), $this->version, true );

		$vars = array(
			'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ),
			'swatches_nonce' => wp_create_nonce( 'swatches_nonce' )
		);
		wp_localize_script( $this->plugin_name , 'la_swatches_vars', $vars );

	}

	public function admin_customize_enqueue(){
		wp_enqueue_script( 'lastudio-admin-customize', plugin_dir_url( __FILE__ ) .'/js/lastudio-admin-customize.js', array( 'jquery','customize-preview' ), $this->version, true );
	}

	/**
	 * Register Text Sanitize
	 *
	 * @since 1.0.0
	 */
	public static function sanitize_text( $value ) {
		return wp_filter_nohtml_kses( $value );
	}

	/**
	 * Register Textarea Sanitize
	 *
	 * @since 1.0.0
	 */
	public static function sanitize_textarea( $value ) {
		global $allowedposttags;
		return wp_kses( $value, $allowedposttags );
	}

	/**
	 * Register Checkbox Sanitize
	 * Do not touch, or think twice
	 *
	 * @since 1.0.0
	 */
	public static function sanitize_checkbox( $value ) {
		if( ! empty( $value ) && $value == 1 ) {
			$value = true;
		}
		if( empty( $value ) ) {
			$value = false;
		}
		return $value;
	}

	/**
	 * Register Image Select Sanitize
	 * Do not touch, or think twice
	 *
	 * @since 1.0.0
	 */
	public static function sanitize_image_select( $value ) {
		if( isset( $value ) && is_array( $value ) ) {
			if( count( $value ) ) {
				$value = $value;
			}
			else {
				$value = $value[0];
			}
		}
		else if ( empty( $value ) ) {
			$value = '';
		}

		return $value;
	}

	/**
	 * Register Group Sanitize
	 * Do not touch, or think twice
	 *
	 * @since 1.0.0
	 */
	public static function sanitize_group( $value ) {
		return ( empty( $value ) ) ? '' : $value;
	}

	/**
	 * Register Title Sanitize
	 * Do not touch, or think twice
	 *
	 * @since 1.0.0
	 */
	public static function sanitize_title( $value ) {
		return sanitize_title( $value );
	}

	/**
	 * Register Text Sanitize
	 *
	 * @since 1.0.0
	 */
	public static function sanitize_clean( $value ) {
		return $value;
	}

	/**
	 * Register Email Validate
	 *
	 * @since 1.0.0
	 */
	public static function validate_email( $value ) {
		if ( ! sanitize_email( $value ) ) {
			return __( 'Please write a valid email address!', 'lastudio' );
		}
	}

	/**
	 * Register Numeric Validate
	 *
	 * @since 1.0.0
	 */
	public static function validate_numeric( $value ) {
		if ( ! is_numeric( $value ) ) {
			return __( 'Please write a numeric data!', 'lastudio' );
		}
	}

	/**
	 * Register Required Validate
	 *
	 * @since 1.0.0
	 */
	public static function validate_required( $value ) {
		if ( empty( $value ) ) {
			return __( 'Fatal Error! This field is required!', 'lastudio' );
		}
	}

	private function get_icon_library(){

        $fontawesome = array("fa-glass","fa-music","fa-search","fa-envelope-o","fa-heart","fa-star","fa-star-o","fa-user","fa-film","fa-th-large","fa-th","fa-th-list","fa-check","fa-remove","fa-close","fa-times","fa-search-plus","fa-search-minus","fa-power-off","fa-signal","fa-gear","fa-cog","fa-trash-o","fa-home","fa-file-o","fa-clock-o","fa-road","fa-download","fa-arrow-circle-o-down","fa-arrow-circle-o-up","fa-inbox","fa-play-circle-o","fa-rotate-right","fa-repeat","fa-refresh","fa-list-alt","fa-lock","fa-flag","fa-headphones","fa-volume-off","fa-volume-down","fa-volume-up","fa-qrcode","fa-barcode","fa-tag","fa-tags","fa-book","fa-bookmark","fa-print","fa-camera","fa-font","fa-bold","fa-italic","fa-text-height","fa-text-width","fa-align-left","fa-align-center","fa-align-right","fa-align-justify","fa-list","fa-dedent","fa-outdent","fa-indent","fa-video-camera","fa-photo","fa-image","fa-picture-o","fa-pencil","fa-map-marker","fa-adjust","fa-tint","fa-edit","fa-pencil-square-o","fa-share-square-o","fa-check-square-o","fa-arrows","fa-step-backward","fa-fast-backward","fa-backward","fa-play","fa-pause","fa-stop","fa-forward","fa-fast-forward","fa-step-forward","fa-eject","fa-chevron-left","fa-chevron-right","fa-plus-circle","fa-minus-circle","fa-times-circle","fa-check-circle","fa-question-circle","fa-info-circle","fa-crosshairs","fa-times-circle-o","fa-check-circle-o","fa-ban","fa-arrow-left","fa-arrow-right","fa-arrow-up","fa-arrow-down","fa-mail-forward","fa-share","fa-expand","fa-compress","fa-plus","fa-minus","fa-asterisk","fa-exclamation-circle","fa-gift","fa-leaf","fa-fire","fa-eye","fa-eye-slash","fa-warning","fa-exclamation-triangle","fa-plane","fa-calendar","fa-random","fa-comment","fa-magnet","fa-chevron-up","fa-chevron-down","fa-retweet","fa-shopping-cart","fa-folder","fa-folder-open","fa-arrows-v","fa-arrows-h","fa-bar-chart-o","fa-bar-chart","fa-twitter-square","fa-facebook-square","fa-camera-retro","fa-key","fa-gears","fa-cogs","fa-comments","fa-thumbs-o-up","fa-thumbs-o-down","fa-star-half","fa-heart-o","fa-sign-out","fa-linkedin-square","fa-thumb-tack","fa-external-link","fa-sign-in","fa-trophy","fa-github-square","fa-upload","fa-lemon-o","fa-phone","fa-square-o","fa-bookmark-o","fa-phone-square","fa-twitter","fa-facebook-f","fa-facebook","fa-github","fa-unlock","fa-credit-card","fa-feed","fa-rss","fa-hdd-o","fa-bullhorn","fa-bell","fa-certificate","fa-hand-o-right","fa-hand-o-left","fa-hand-o-up","fa-hand-o-down","fa-arrow-circle-left","fa-arrow-circle-right","fa-arrow-circle-up","fa-arrow-circle-down","fa-globe","fa-wrench","fa-tasks","fa-filter","fa-briefcase","fa-arrows-alt","fa-group","fa-users","fa-chain","fa-link","fa-cloud","fa-flask","fa-cut","fa-scissors","fa-copy","fa-files-o","fa-paperclip","fa-save","fa-floppy-o","fa-square","fa-navicon","fa-reorder","fa-bars","fa-list-ul","fa-list-ol","fa-strikethrough","fa-underline","fa-table","fa-magic","fa-truck","fa-pinterest","fa-pinterest-square","fa-google-plus-square","fa-google-plus","fa-money","fa-caret-down","fa-caret-up","fa-caret-left","fa-caret-right","fa-columns","fa-unsorted","fa-sort","fa-sort-down","fa-sort-desc","fa-sort-up","fa-sort-asc","fa-envelope","fa-linkedin","fa-rotate-left","fa-undo","fa-legal","fa-gavel","fa-dashboard","fa-tachometer","fa-comment-o","fa-comments-o","fa-flash","fa-bolt","fa-sitemap","fa-umbrella","fa-paste","fa-clipboard","fa-lightbulb-o","fa-exchange","fa-cloud-download","fa-cloud-upload","fa-user-md","fa-stethoscope","fa-suitcase","fa-bell-o","fa-coffee","fa-cutlery","fa-file-text-o","fa-building-o","fa-hospital-o","fa-ambulance","fa-medkit","fa-fighter-jet","fa-beer","fa-h-square","fa-plus-square","fa-angle-double-left","fa-angle-double-right","fa-angle-double-up","fa-angle-double-down","fa-angle-left","fa-angle-right","fa-angle-up","fa-angle-down","fa-desktop","fa-laptop","fa-tablet","fa-mobile-phone","fa-mobile","fa-circle-o","fa-quote-left","fa-quote-right","fa-spinner","fa-circle","fa-mail-reply","fa-reply","fa-github-alt","fa-folder-o","fa-folder-open-o","fa-smile-o","fa-frown-o","fa-meh-o","fa-gamepad","fa-keyboard-o","fa-flag-o","fa-flag-checkered","fa-terminal","fa-code","fa-mail-reply-all","fa-reply-all","fa-star-half-empty","fa-star-half-full","fa-star-half-o","fa-location-arrow","fa-crop","fa-code-fork","fa-unlink","fa-chain-broken","fa-question","fa-info","fa-exclamation","fa-superscript","fa-subscript","fa-eraser","fa-puzzle-piece","fa-microphone","fa-microphone-slash","fa-shield","fa-calendar-o","fa-fire-extinguisher","fa-rocket","fa-maxcdn","fa-chevron-circle-left","fa-chevron-circle-right","fa-chevron-circle-up","fa-chevron-circle-down","fa-html5","fa-css3","fa-anchor","fa-unlock-alt","fa-bullseye","fa-ellipsis-h","fa-ellipsis-v","fa-rss-square","fa-play-circle","fa-ticket","fa-minus-square","fa-minus-square-o","fa-level-up","fa-level-down","fa-check-square","fa-pencil-square","fa-external-link-square","fa-share-square","fa-compass","fa-toggle-down","fa-caret-square-o-down","fa-toggle-up","fa-caret-square-o-up","fa-toggle-right","fa-caret-square-o-right","fa-euro","fa-eur","fa-gbp","fa-dollar","fa-usd","fa-rupee","fa-inr","fa-cny","fa-rmb","fa-yen","fa-jpy","fa-ruble","fa-rouble","fa-rub","fa-won","fa-krw","fa-bitcoin","fa-btc","fa-file","fa-file-text","fa-sort-alpha-asc","fa-sort-alpha-desc","fa-sort-amount-asc","fa-sort-amount-desc","fa-sort-numeric-asc","fa-sort-numeric-desc","fa-thumbs-up","fa-thumbs-down","fa-youtube-square","fa-youtube","fa-xing","fa-xing-square","fa-youtube-play","fa-dropbox","fa-stack-overflow","fa-instagram","fa-flickr","fa-adn","fa-bitbucket","fa-bitbucket-square","fa-tumblr","fa-tumblr-square","fa-long-arrow-down","fa-long-arrow-up","fa-long-arrow-left","fa-long-arrow-right","fa-apple","fa-windows","fa-android","fa-linux","fa-dribbble","fa-skype","fa-foursquare","fa-trello","fa-female","fa-male","fa-gittip","fa-gratipay","fa-sun-o","fa-moon-o","fa-archive","fa-bug","fa-vk","fa-weibo","fa-renren","fa-pagelines","fa-stack-exchange","fa-arrow-circle-o-right","fa-arrow-circle-o-left","fa-toggle-left","fa-caret-square-o-left","fa-dot-circle-o","fa-wheelchair","fa-vimeo-square","fa-turkish-lira","fa-try","fa-plus-square-o","fa-space-shuttle","fa-slack","fa-envelope-square","fa-wordpress","fa-openid","fa-institution","fa-bank","fa-university","fa-mortar-board","fa-graduation-cap","fa-yahoo","fa-google","fa-reddit","fa-reddit-square","fa-stumbleupon-circle","fa-stumbleupon","fa-delicious","fa-digg","fa-pied-piper-pp","fa-pied-piper-alt","fa-drupal","fa-joomla","fa-language","fa-fax","fa-building","fa-child","fa-paw","fa-spoon","fa-cube","fa-cubes","fa-behance","fa-behance-square","fa-steam","fa-steam-square","fa-recycle","fa-automobile","fa-car","fa-cab","fa-taxi","fa-tree","fa-spotify","fa-deviantart","fa-soundcloud","fa-database","fa-file-pdf-o","fa-file-word-o","fa-file-excel-o","fa-file-powerpoint-o","fa-file-photo-o","fa-file-picture-o","fa-file-image-o","fa-file-zip-o","fa-file-archive-o","fa-file-sound-o","fa-file-audio-o","fa-file-movie-o","fa-file-video-o","fa-file-code-o","fa-vine","fa-codepen","fa-jsfiddle","fa-life-bouy","fa-life-buoy","fa-life-saver","fa-support","fa-life-ring","fa-circle-o-notch","fa-ra","fa-resistance","fa-rebel","fa-ge","fa-empire","fa-git-square","fa-git","fa-y-combinator-square","fa-yc-square","fa-hacker-news","fa-tencent-weibo","fa-qq","fa-wechat","fa-weixin","fa-send","fa-paper-plane","fa-send-o","fa-paper-plane-o","fa-history","fa-circle-thin","fa-header","fa-paragraph","fa-sliders","fa-share-alt","fa-share-alt-square","fa-bomb","fa-soccer-ball-o","fa-futbol-o","fa-tty","fa-binoculars","fa-plug","fa-slideshare","fa-twitch","fa-yelp","fa-newspaper-o","fa-wifi","fa-calculator","fa-paypal","fa-google-wallet","fa-cc-visa","fa-cc-mastercard","fa-cc-discover","fa-cc-amex","fa-cc-paypal","fa-cc-stripe","fa-bell-slash","fa-bell-slash-o","fa-trash","fa-copyright","fa-at","fa-eyedropper","fa-paint-brush","fa-birthday-cake","fa-area-chart","fa-pie-chart","fa-line-chart","fa-lastfm","fa-lastfm-square","fa-toggle-off","fa-toggle-on","fa-bicycle","fa-bus","fa-ioxhost","fa-angellist","fa-cc","fa-shekel","fa-sheqel","fa-ils","fa-meanpath","fa-buysellads","fa-connectdevelop","fa-dashcube","fa-forumbee","fa-leanpub","fa-sellsy","fa-shirtsinbulk","fa-simplybuilt","fa-skyatlas","fa-cart-plus","fa-cart-arrow-down","fa-diamond","fa-ship","fa-user-secret","fa-motorcycle","fa-street-view","fa-heartbeat","fa-venus","fa-mars","fa-mercury","fa-intersex","fa-transgender","fa-transgender-alt","fa-venus-double","fa-mars-double","fa-venus-mars","fa-mars-stroke","fa-mars-stroke-v","fa-mars-stroke-h","fa-neuter","fa-genderless","fa-facebook-official","fa-pinterest-p","fa-whatsapp","fa-server","fa-user-plus","fa-user-times","fa-hotel","fa-bed","fa-viacoin","fa-train","fa-subway","fa-medium","fa-yc","fa-y-combinator","fa-optin-monster","fa-opencart","fa-expeditedssl","fa-battery-4","fa-battery","fa-battery-full","fa-battery-3","fa-battery-three-quarters","fa-battery-2","fa-battery-half","fa-battery-1","fa-battery-quarter","fa-battery-0","fa-battery-empty","fa-mouse-pointer","fa-i-cursor","fa-object-group","fa-object-ungroup","fa-sticky-note","fa-sticky-note-o","fa-cc-jcb","fa-cc-diners-club","fa-clone","fa-balance-scale","fa-hourglass-o","fa-hourglass-1","fa-hourglass-start","fa-hourglass-2","fa-hourglass-half","fa-hourglass-3","fa-hourglass-end","fa-hourglass","fa-hand-grab-o","fa-hand-rock-o","fa-hand-stop-o","fa-hand-paper-o","fa-hand-scissors-o","fa-hand-lizard-o","fa-hand-spock-o","fa-hand-pointer-o","fa-hand-peace-o","fa-trademark","fa-registered","fa-creative-commons","fa-gg","fa-gg-circle","fa-tripadvisor","fa-odnoklassniki","fa-odnoklassniki-square","fa-get-pocket","fa-wikipedia-w","fa-safari","fa-chrome","fa-firefox","fa-opera","fa-internet-explorer","fa-tv","fa-television","fa-contao","fa-500px","fa-amazon","fa-calendar-plus-o","fa-calendar-minus-o","fa-calendar-times-o","fa-calendar-check-o","fa-industry","fa-map-pin","fa-map-signs","fa-map-o","fa-map","fa-commenting","fa-commenting-o","fa-houzz","fa-vimeo","fa-black-tie","fa-fonticons","fa-reddit-alien","fa-edge","fa-credit-card-alt","fa-codiepie","fa-modx","fa-fort-awesome","fa-usb","fa-product-hunt","fa-mixcloud","fa-scribd","fa-pause-circle","fa-pause-circle-o","fa-stop-circle","fa-stop-circle-o","fa-shopping-bag","fa-shopping-basket","fa-hashtag","fa-bluetooth","fa-bluetooth-b","fa-percent","fa-gitlab","fa-wpbeginner","fa-wpforms","fa-envira","fa-universal-access","fa-wheelchair-alt","fa-question-circle-o","fa-blind","fa-audio-description","fa-volume-control-phone","fa-braille","fa-assistive-listening-systems","fa-asl-interpreting","fa-american-sign-language-interpreting","fa-deafness","fa-hard-of-hearing","fa-deaf","fa-glide","fa-glide-g","fa-signing","fa-sign-language","fa-low-vision","fa-viadeo","fa-viadeo-square","fa-snapchat","fa-snapchat-ghost","fa-snapchat-square","fa-pied-piper","fa-first-order","fa-yoast","fa-themeisle","fa-google-plus-circle","fa-google-plus-official","fa-fa","fa-font-awesome","fa-handshake-o","fa-envelope-open","fa-envelope-open-o","fa-linode","fa-address-book","fa-address-book-o","fa-vcard","fa-address-card","fa-vcard-o","fa-address-card-o","fa-user-circle","fa-user-circle-o","fa-user-o","fa-id-badge","fa-drivers-license","fa-id-card","fa-drivers-license-o","fa-id-card-o","fa-quora","fa-free-code-camp","fa-telegram","fa-thermometer-4","fa-thermometer","fa-thermometer-full","fa-thermometer-3","fa-thermometer-three-quarters","fa-thermometer-2","fa-thermometer-half","fa-thermometer-1","fa-thermometer-quarter","fa-thermometer-0","fa-thermometer-empty","fa-shower","fa-bathtub","fa-s15","fa-bath","fa-podcast","fa-window-maximize","fa-window-minimize","fa-window-restore","fa-times-rectangle","fa-window-close","fa-times-rectangle-o","fa-window-close-o","fa-bandcamp","fa-grav","fa-etsy","fa-imdb","fa-ravelry","fa-eercast","fa-microchip","fa-snowflake-o","fa-superpowers","fa-wpexplorer","fa-meetup");

        $fontawesome_full = array();
        foreach ($fontawesome as $item){
            $fontawesome_full[] = 'fa ' .  $item;
        }
        $icon_packages = array();
        $icon_packages[] = array(
            'name' => 'Font Awesome',
            'icons' => $fontawesome_full
        );

        if(function_exists('lastudio_elements')){
            $dlicon = array("files_add","files_archive-3d-check","files_archive-3d-content","files_archive-check","files_archive-content","files_archive-paper-check","files_archive-paper","files_archive","files_audio","files_book-07","files_book-08","files_bookmark","files_box","files_chart-bar","files_chart-pie","files_check","files_cloud","files_copy","files_dev","files_download","files_drawer","files_edit","files_exclamation","files_folder-13","files_folder-14","files_folder-15","files_folder-16","files_folder-17","files_folder-18","files_folder-19","files_folder-add","files_folder-audio","files_folder-bookmark","files_folder-chart-bar","files_folder-chart-pie","files_folder-check","files_folder-cloud","files_folder-dev","files_folder-download","files_folder-edit","files_folder-exclamation","files_folder-gallery","files_folder-heart","files_folder-image","files_folder-info","files_folder-link","files_folder-locked","files_folder-money","files_folder-music","files_folder-no-access","files_folder-play","files_folder-question","files_folder-refresh","files_folder-remove","files_folder-search","files_folder-settings-81","files_folder-settings-97","files_folder-shared","files_folder-star","files_folder-time","files_folder-upload","files_folder-user","files_folder-vector","files_gallery","files_heart","files_image","files_info","files_link","files_locked","files_money","files_music","files_no-access","files_notebook","files_paper","files_play","files_question","files_refresh","files_remove","files_replace-folder","files_replace","files_search","files_settings-46","files_settings-99","files_shared","files_single-content-02","files_single-content-03","files_single-copies","files_single-copy-04","files_single-copy-06","files_single-folded-content","files_single-folded","files_single-paragraph","files_single","files_star","files_time","files_upload","files_user","files_vector","files_zip-54","files_zip-55","tech_cable-49","tech_cable-50","tech_cd-reader","tech_computer-monitor","tech_computer-old","tech_computer","tech_controller-modern","tech_controller","tech_desktop-screen","tech_desktop","tech_disk-reader","tech_disk","tech_gopro","tech_headphones","tech_keyboard-mouse","tech_keyboard-wifi","tech_keyboard","tech_laptop-1","tech_laptop-2","tech_laptop","tech_mobile-button","tech_mobile-camera","tech_mobile-recharger-08","tech_mobile-recharger-09","tech_mobile-toolbar","tech_mobile","tech_music","tech_navigation","tech_player-19","tech_player-48","tech_print-fold","tech_print-round-fold","tech_print-round","tech_print","tech_ram","tech_remote","tech_signal","tech_socket","tech_sync","tech_tablet-button","tech_tablet-reader-31","tech_tablet-reader-42","tech_tablet-toolbar","tech_tablet","tech_tv-old","tech_tv","tech_watch-circle","tech_watch-time","tech_watch","tech_webcam-38","tech_webcam-39","tech_wifi-router","tech_wifi","tech-2_cctv","tech-2_connection","tech-2_device-connection","tech-2_dock","tech-2_firewall","tech-2_hdmi","tech-2_headphone","tech-2_headset","tech-2_keyboard-hide","tech-2_keyboard-wireless","tech-2_l-add","tech-2_l-check","tech-2_l-location","tech-2_l-remove","tech-2_l-search","tech-2_l-security","tech-2_l-settings","tech-2_l-sync","tech-2_l-system-update","tech-2_lock-landscape","tech-2_lock-portrait","tech-2_mic","tech-2_mobile-landscape","tech-2_p-add","tech-2_p-check","tech-2_p-edit","tech-2_p-heart","tech-2_p-location","tech-2_p-remove","tech-2_p-search","tech-2_p-settings","tech-2_p-share","tech-2_p-sync","tech-2_p-system-update","tech-2_p-time","tech-2_pci-card","tech-2_rotate-lock","tech-2_rotate","tech-2_sim-card","tech-2_socket-europe-1","tech-2_socket-europe-2","tech-2_socket-uk","tech-2_vpn","tech-2_wifi-off","tech-2_wifi-protected","tech-2_wifi","users_add-27","users_add-29","users_badge-13","users_badge-14","users_badge-15","users_circle-08","users_circle-09","users_circle-10","users_contacts","users_delete-28","users_delete-30","users_man-20","users_man-23","users_man-glasses","users_mobile-contact","users_multiple-11","users_multiple-19","users_network","users_parent","users_single-01","users_single-02","users_single-03","users_single-04","users_single-05","users_single-body","users_single-position","users_square-31","users_square-32","users_square-33","users_woman-21","users_woman-24","users_woman-25","users_woman-man","users-2_a-add","users-2_a-check","users-2_a-delete","users-2_a-edit","users-2_a-heart","users-2_a-location","users-2_a-remove","users-2_a-search","users-2_a-security","users-2_a-share","users-2_a-star","users-2_a-sync","users-2_a-time","users-2_accessibility","users-2_b-add","users-2_b-check","users-2_b-location","users-2_b-love","users-2_b-meeting","users-2_b-remove","users-2_b-security","users-2_child","users-2_contacts-44","users-2_contacts-45","users-2_couple-gay","users-2_couple-lesbian","users-2_disabled","users-2_exchange","users-2_family","users-2_focus","users-2_home","users-2_man-down","users-2_man-up","users-2_man","users-2_meeting","users-2_mickey-mouse","users-2_multiple","users-2_pin","users-2_police","users-2_search","users-2_standing-man","users-2_standing-woman","users-2_voice-record","users-2_wc","users-2_woman-down","users-2_woman-up","users-2_woman","shopping_award","shopping_bag-09","shopping_bag-16","shopping_bag-17","shopping_bag-20","shopping_bag-add-18","shopping_bag-add-21","shopping_bag-edit","shopping_bag-remove-19","shopping_bag-remove-22","shopping_barcode-scan","shopping_barcode","shopping_bardcode-qr","shopping_basket-add","shopping_basket-edit","shopping_basket-remove","shopping_basket-simple-add","shopping_basket-simple-remove","shopping_basket-simple","shopping_basket","shopping_bitcoin","shopping_board","shopping_box-3d-50","shopping_box-3d-67","shopping_box-ribbon","shopping_box","shopping_cart-add","shopping_cart-modern-add","shopping_cart-modern-in","shopping_cart-modern-remove","shopping_cart-modern","shopping_cart-remove","shopping_cart-simple-add","shopping_cart-simple-in","shopping_cart-simple-remove","shopping_cart-simple","shopping_cart","shopping_cash-register","shopping_chart","shopping_credit-card-in","shopping_credit-card","shopping_credit-locked","shopping_delivery-fast","shopping_delivery-time","shopping_delivery-track","shopping_delivery","shopping_discount","shopping_gift","shopping_hand-card","shopping_list","shopping_mobile-card","shopping_mobile-cart","shopping_mobile-touch","shopping_newsletter","shopping_pos","shopping_receipt-list-42","shopping_receipt-list-43","shopping_receipt","shopping_shop-location","shopping_shop","shopping_stock","shopping_tag-content","shopping_tag-cut","shopping_tag-line","shopping_tag-sale","shopping_tag","shopping_wallet","arrows-1_back-78","arrows-1_back-80","arrows-1_bold-direction","arrows-1_bold-down","arrows-1_bold-left","arrows-1_bold-right","arrows-1_bold-up","arrows-1_circle-down-12","arrows-1_circle-down-40","arrows-1_circle-left-10","arrows-1_circle-left-38","arrows-1_circle-right-09","arrows-1_circle-right-37","arrows-1_circle-up-11","arrows-1_circle-up-39","arrows-1_cloud-download-93","arrows-1_cloud-download-95","arrows-1_cloud-upload-94","arrows-1_cloud-upload-96","arrows-1_curved-next","arrows-1_curved-previous","arrows-1_direction-53","arrows-1_direction-56","arrows-1_double-left","arrows-1_double-right","arrows-1_download","arrows-1_enlarge-diagonal-43","arrows-1_enlarge-diagonal-44","arrows-1_enlarge-horizontal","arrows-1_enlarge-vertical","arrows-1_fit-horizontal","arrows-1_fit-vertical","arrows-1_fullscreen-70","arrows-1_fullscreen-71","arrows-1_fullscreen-76","arrows-1_fullscreen-77","arrows-1_fullscreen-double-74","arrows-1_fullscreen-double-75","arrows-1_fullscreen-split-72","arrows-1_fullscreen-split-73","arrows-1_log-in","arrows-1_log-out","arrows-1_loop-82","arrows-1_loop-83","arrows-1_minimal-down","arrows-1_minimal-left","arrows-1_minimal-right","arrows-1_minimal-up","arrows-1_redo-79","arrows-1_redo-81","arrows-1_refresh-68","arrows-1_refresh-69","arrows-1_round-down","arrows-1_round-left","arrows-1_round-right","arrows-1_round-up","arrows-1_share-66","arrows-1_share-91","arrows-1_share-92","arrows-1_shuffle-97","arrows-1_shuffle-98","arrows-1_simple-down","arrows-1_simple-left","arrows-1_simple-right","arrows-1_simple-up","arrows-1_small-triangle-down","arrows-1_small-triangle-left","arrows-1_small-triangle-right","arrows-1_small-triangle-up","arrows-1_square-down","arrows-1_square-left","arrows-1_square-right","arrows-1_square-up","arrows-1_strong-down","arrows-1_strong-left","arrows-1_strong-right","arrows-1_strong-up","arrows-1_tail-down","arrows-1_tail-left","arrows-1_tail-right","arrows-1_tail-triangle-down","arrows-1_tail-triangle-left","arrows-1_tail-triangle-right","arrows-1_tail-triangle-up","arrows-1_tail-up","arrows-1_trend-down","arrows-1_trend-up","arrows-1_triangle-down-20","arrows-1_triangle-down-65","arrows-1_triangle-left-18","arrows-1_triangle-left-63","arrows-1_triangle-right-17","arrows-1_triangle-right-62","arrows-1_triangle-up-19","arrows-1_triangle-up-64","arrows-1_window-zoom-in","arrows-1_window-zoom-out","arrows-1_zoom-88","arrows-1_zoom-99","arrows-1_zoom-100","arrows-2_block-down","arrows-2_block-left","arrows-2_block-right","arrows-2_block-up","arrows-2_circle-in","arrows-2_circle-out","arrows-2_circuit-round","arrows-2_circuit","arrows-2_computer-upload","arrows-2_conversion","arrows-2_corner-down-round","arrows-2_corner-down","arrows-2_corner-left-down","arrows-2_corner-left-round","arrows-2_corner-left","arrows-2_corner-right-down","arrows-2_corner-right-round","arrows-2_corner-right","arrows-2_corner-up-left","arrows-2_corner-up-right","arrows-2_corner-up-round","arrows-2_corner-up","arrows-2_cross-down","arrows-2_cross-horizontal","arrows-2_cross-left","arrows-2_cross-right","arrows-2_cross-up","arrows-2_cross-vertical","arrows-2_curve-circuit","arrows-2_curve-directions","arrows-2_curve-split","arrows-2_delete-49","arrows-2_delete-50","arrows-2_direction","arrows-2_dots-download","arrows-2_dots-upload","arrows-2_eject","arrows-2_enlarge-circle","arrows-2_file-download-87","arrows-2_file-download-89","arrows-2_file-download-94","arrows-2_file-upload-86","arrows-2_file-upload-88","arrows-2_file-upload-93","arrows-2_fork-round","arrows-2_fork","arrows-2_hit-down","arrows-2_hit-left","arrows-2_hit-right","arrows-2_hit-up","arrows-2_lines","arrows-2_log-out","arrows-2_loop","arrows-2_merge-round","arrows-2_merge","arrows-2_move-05","arrows-2_move-06","arrows-2_move-92","arrows-2_move-down-right","arrows-2_move-down","arrows-2_move-left","arrows-2_move-right","arrows-2_move-up-left","arrows-2_move-up","arrows-2_push-next","arrows-2_push-previous","arrows-2_reload","arrows-2_replay","arrows-2_rotate-left","arrows-2_rotate-right","arrows-2_round-left-down","arrows-2_round-right-down","arrows-2_round-up-left","arrows-2_round-up-right","arrows-2_select-83","arrows-2_select-84","arrows-2_separate-round","arrows-2_separate","arrows-2_share-left","arrows-2_share-right","arrows-2_skew-down","arrows-2_skew-left","arrows-2_skew-right","arrows-2_skew-up","arrows-2_small-left","arrows-2_small-right","arrows-2_split-horizontal","arrows-2_split-round","arrows-2_split-vertical","arrows-2_split","arrows-2_square-download","arrows-2_square-upload","arrows-2_time","arrows-2_triangle-down","arrows-2_triangle-left","arrows-2_triangle-right","arrows-2_triangle-up","arrows-2_unite-round","arrows-2_unite","arrows-2_zoom","arrows-3_circle-down","arrows-3_circle-left","arrows-3_circle-right","arrows-3_circle-simple-down","arrows-3_circle-simple-left","arrows-3_circle-simple-right","arrows-3_circle-simple-up","arrows-3_circle-up","arrows-3_cloud-refresh","arrows-3_separate","arrows-3_small-down","arrows-3_small-up","arrows-3_square-corner-down-left","arrows-3_square-corner-down-right","arrows-3_square-corner-up-left","arrows-3_square-corner-up-right","arrows-3_square-down-06","arrows-3_square-down-22","arrows-3_square-enlarge","arrows-3_square-left-04","arrows-3_square-left-20","arrows-3_square-right-03","arrows-3_square-right-19","arrows-3_square-simple-down","arrows-3_square-simple-left","arrows-3_square-simple-right","arrows-3_square-simple-up","arrows-3_square-up-05","arrows-3_square-up-21","arrows-3_square-zoom","arrows-3_super-bold-down","arrows-3_super-bold-left","arrows-3_super-bold-right","arrows-3_super-bold-up","arrows-4_block-bottom-left","arrows-4_block-bottom-right","arrows-4_block-top-left","arrows-4_block-top-right","arrows-4_centralize","arrows-4_compare","arrows-4_contrast","arrows-4_cross","arrows-4_diag-bottom-left","arrows-4_diag-bottom-right","arrows-4_diag-top-left","arrows-4_diag-top-right","arrows-4_disperse","arrows-4_download","arrows-4_enlarge-45","arrows-4_enlarge-46","arrows-4_export","arrows-4_format-left","arrows-4_format-right","arrows-4_input-12","arrows-4_input-21","arrows-4_invert","arrows-4_launch-11","arrows-4_launch-47","arrows-4_logout","arrows-4_loop-30","arrows-4_loop-34","arrows-4_merge","arrows-4_open-in-browser","arrows-4_priority-high","arrows-4_priority-low","arrows-4_redo-10","arrows-4_redo-26","arrows-4_reply-all","arrows-4_reply","arrows-4_restore","arrows-4_share","arrows-4_shuffle-01","arrows-4_shuffle-35","arrows-4_split-33","arrows-4_split-37","arrows-4_stre-down","arrows-4_stre-left","arrows-4_stre-right","arrows-4_stre-up","arrows-4_swap-horizontal","arrows-4_swap-vertical","arrows-4_system-update","arrows-4_undo-25","arrows-4_undo-29","arrows-4_upload","files-2_ai-illustrator","files-2_avi","files-2_css","files-2_csv","files-2_doc","files-2_docx","files-2_epub","files-2_exe","files-2_font","files-2_gif","files-2_html","files-2_jpg-jpeg","files-2_js-javascript-jquery","files-3_mov","files-3_mp3","files-3_mp4","files-3_pdf","files-3_png","files-3_psd-photoshop","files-3_rar","files-3_sketch","files-3_svg","files-3_txt","files-3_wav","files-3_zip","design_album","design_align-bottom","design_align-center-horizontal","design_align-center-vertical","design_align-left","design_align-right","design_align-top","design_app","design_artboard","design_blend","design_book-bookmark","design_book-open","design_brush","design_bug","design_bullet-list-67","design_bullet-list-68","design_bullet-list-69","design_bullet-list-70","design_clone","design_code-editor","design_code","design_collection","design_command","design_compass","design_contrast","design_copy","design_crop","design_cursor-48","design_cursor-49","design_design-dev","design_design","design_distribute-horizontal","design_distribute-vertical","design_drag","design_eraser-32","design_eraser-33","design_eraser-46","design_flip-horizontal","design_flip-vertical","design_image","design_magnet","design_marker","design_measure-02","design_measure-17","design_measure-big","design_mobile-design","design_mobile-dev","design_mouse-08","design_mouse-09","design_mouse-10","design_newsletter-dev","design_note-code","design_paint-16","design_paint-37","design_paint-38","design_paint-bucket-39","design_paint-bucket-40","design_palette","design_pantone","design_paper-design","design_paper-dev","design_patch-19","design_patch-34","design_path-exclude","design_path-intersect","design_path-minus","design_path-unite","design_pen-01","design_pen-23","design_pen-tool","design_phone","design_photo-editor","design_responsive","design_scissors-dashed","design_scissors","design_shape-adjust","design_shape-circle","design_shape-polygon","design_shape-square","design_shape-triangle","design_shapes","design_sharpener","design_slice","design_spray","design_stamp","design_tablet-mobile","design_tablet","design_text","design_todo","design_usb","design_vector","design_wand-11","design_wand-99","design_watch-dev","design_web-design","design_webpage","design_window-code","design_window-dev","design_window-paragraph","design_window-responsive","design-2_3d-28","design-2_3d-29","design-2_android","design-2_angle","design-2_animation-14","design-2_animation-31","design-2_animation-32","design-2_apple","design-2_browser-chrome","design-2_browser-edge","design-2_browser-firefox","design-2_browser-ie","design-2_browser-opera","design-2_browser-safari","design-2_bucket","design-2_button","design-2_canvas","design-2_css3","design-2_cursor-add","design-2_cursor-grab","design-2_cursor-load","design-2_cursor-menu","design-2_cursor-not-allowed","design-2_cursor-pointer","design-2_cursor-text","design-2_divider","design-2_filter-organization","design-2_form","design-2_frame","design-2_group","design-2_html5","design-2_image","design-2_layers","design-2_layout-11","design-2_layout-25","design-2_microsoft","design-2_mirror","design-2_move-down","design-2_move-up","design-2_paint-brush","design-2_ruler-pencil","design-2_scale-down","design-2_scale-up","design-2_scale","design-2_selection","design-2_slider","design-2_text","design-2_transform-origin","design-2_transform","design-2_ungroup","loader_circle-04","loader_dots-06","loader_gear","loader_refresh","ui-1_analytics-88","ui-1_analytics-89","ui-1_attach-86","ui-1_attach-87","ui-1_bell-53","ui-1_bell-54","ui-1_bell-55","ui-1_bold-add","ui-1_bold-delete","ui-1_bold-remove","ui-1_bookmark-add","ui-1_bookmark-remove","ui-1_calendar-57","ui-1_calendar-60","ui-1_calendar-check-59","ui-1_calendar-check-62","ui-1_calendar-grid-58","ui-1_calendar-grid-61","ui-1_check-bold","ui-1_check-circle-07","ui-1_check-circle-08","ui-1_check-curve","ui-1_check-simple","ui-1_check-small","ui-1_check-square-09","ui-1_check-square-11","ui-1_check","ui-1_circle-add","ui-1_circle-bold-add","ui-1_circle-bold-remove","ui-1_circle-delete","ui-1_circle-remove","ui-1_dashboard-29","ui-1_dashboard-30","ui-1_dashboard-half","ui-1_dashboard-level","ui-1_database","ui-1_drop","ui-1_edit-71","ui-1_edit-72","ui-1_edit-73","ui-1_edit-74","ui-1_edit-75","ui-1_edit-76","ui-1_edit-77","ui-1_edit-78","ui-1_email-83","ui-1_email-84","ui-1_email-85","ui-1_eye-17","ui-1_eye-19","ui-1_eye-ban-18","ui-1_eye-ban-20","ui-1_flame","ui-1_home-51","ui-1_home-52","ui-1_home-minimal","ui-1_home-simple","ui-1_leaf-80","ui-1_leaf-81","ui-1_leaf-edit","ui-1_lock-circle-open","ui-1_lock-circle","ui-1_lock-open","ui-1_lock","ui-1_notification-69","ui-1_notification-70","ui-1_pencil","ui-1_preferences-circle-rotate","ui-1_preferences-circle","ui-1_preferences-container-circle-rotate","ui-1_preferences-container-circle","ui-1_preferences-container-rotate","ui-1_preferences-container","ui-1_preferences-rotate","ui-1_preferences","ui-1_send","ui-1_settings-gear-63","ui-1_settings-gear-64","ui-1_settings-gear-65","ui-1_settings-tool-66","ui-1_settings-tool-67","ui-1_settings","ui-1_simple-add","ui-1_simple-delete","ui-1_simple-remove","ui-1_trash-round","ui-1_trash-simple","ui-1_trash","ui-1_ui-03","ui-1_ui-04","ui-1_zoom-bold-in","ui-1_zoom-bold-out","ui-1_zoom-bold","ui-1_zoom-in","ui-1_zoom-out","ui-1_zoom-split-in","ui-1_zoom-split-out","ui-1_zoom-split","ui-1_zoom","ui-2_alert","ui-2_alert-","ui-2_alert-circle","ui-2_alert-circle-","ui-2_alert-circle-i","ui-2_alert-i","ui-2_alert-square","ui-2_alert-square-","ui-2_alert-square-i","ui-2_archive","ui-2_ban-bold","ui-2_ban","ui-2_battery-81","ui-2_battery-83","ui-2_battery-half","ui-2_battery-low","ui-2_bluetooth","ui-2_book","ui-2_chart-bar-52","ui-2_chart-bar-53","ui-2_chat-content","ui-2_chat-round-content","ui-2_chat-round","ui-2_chat","ui-2_circle-bold-delete","ui-2_cloud-25","ui-2_cloud-26","ui-2_disk","ui-2_enlarge-57","ui-2_enlarge-58","ui-2_enlarge-59","ui-2_fat-add","ui-2_fat-delete","ui-2_fat-remove","ui-2_favourite-28","ui-2_favourite-31","ui-2_favourite-add-29","ui-2_favourite-add-32","ui-2_favourite-remove-30","ui-2_favourite-remove-33","ui-2_filter","ui-2_fullsize","ui-2_grid-45","ui-2_grid-46","ui-2_grid-48","ui-2_grid-49","ui-2_grid-50","ui-2_grid-square","ui-2_hourglass","ui-2_lab","ui-2_layers","ui-2_like","ui-2_link-66","ui-2_link-67","ui-2_link-68","ui-2_link-69","ui-2_link-71","ui-2_link-72","ui-2_link-broken-70","ui-2_link-broken-73","ui-2_menu-34","ui-2_menu-35","ui-2_menu-bold","ui-2_menu-dots","ui-2_menu-square","ui-2_node","ui-2_paragraph","ui-2_phone","ui-2_settings-90","ui-2_settings-91","ui-2_share-bold","ui-2_share","ui-2_small-add","ui-2_small-delete","ui-2_small-remove","ui-2_square-add-08","ui-2_square-add-11","ui-2_square-delete-10","ui-2_square-delete-13","ui-2_square-remove-09","ui-2_square-remove-12","ui-2_target","ui-2_tile-55","ui-2_tile-56","ui-2_time-alarm","ui-2_time-clock","ui-2_time-countdown","ui-2_time","ui-2_webpage","ui-2_window-add","ui-2_window-delete","ui-3_alert","ui-3_backward","ui-3_bolt","ui-3_bullet-list","ui-3_calendar-add","ui-3_card-add","ui-3_card-alert","ui-3_chart-bars","ui-3_chart","ui-3_chat-33","ui-3_chat-45","ui-3_chat-46","ui-3_chat-reply","ui-3_check-in","ui-3_check-out","ui-3_dock-bottom","ui-3_dock-left","ui-3_dock-right","ui-3_dock-top","ui-3_filter-check","ui-3_filter-remove","ui-3_forward","ui-3_funnel-39","ui-3_funnel-40","ui-3_funnel-41","ui-3_heart-add","ui-3_heart-remove","ui-3_heart","ui-3_infinite","ui-3_link","ui-3_menu-left","ui-3_menu-right","ui-3_menu","ui-3_metrics","ui-3_phone-call-end","ui-3_phone-call","ui-3_phone","ui-3_playlist","ui-3_search","ui-3_security","ui-3_segmentation","ui-3_select","ui-3_send","ui-3_signal","ui-3_slide-left","ui-3_slide-right","ui-3_table-left","ui-3_table-right","ui-3_tag","ui-3_widget","envir_bulb-saver","envir_bulb","envir_car","envir_fuel-electric","envir_fuel","envir_home","envir_level","envir_panel","envir_radiation","envir_recycling","envir_save-planet","envir_waste-danger","envir_waste-recycling","envir_waste","envir_water-hand","envir_water-sink","envir_water","envir_wind","text_align-center","text_align-justify","text_align-left","text_align-right","text_background","text_bold","text_capitalize","text_caps-all","text_caps-small","text_color","text_edit","text_italic","text_line-height","text_list-bullet","text_list-numbers","text_margin-left","text_margin-right","text_quote","text_scale-horizontal","text_scale-vertical","text_size","text_strikethrough","text_subscript","text_superscript","text_tracking","text_underline","gestures_2x-drag-down","gestures_2x-drag-up","gestures_2x-swipe-down","gestures_2x-swipe-left","gestures_2x-swipe-right","gestures_2x-swipe-up","gestures_2x-tap","gestures_3x-swipe-left","gestures_3x-swipe-right","gestures_3x-swipe-up","gestures_3x-tap","gestures_4x-swipe-left","gestures_4x-swipe-right","gestures_4x-swipe-up","gestures_active-38","gestures_active-40","gestures_camera","gestures_double-tap","gestures_drag-21","gestures_drag-31","gestures_drag-down","gestures_drag-left","gestures_drag-right","gestures_drag-up","gestures_flick-down","gestures_flick-left","gestures_flick-right","gestures_flick-up","gestures_grab","gestures_hold","gestures_pin","gestures_pinch","gestures_rotate-22","gestures_rotate-23","gestures_scan","gestures_scroll-horitontal","gestures_scroll-vertical","gestures_stretch","gestures_swipe-bottom","gestures_swipe-left","gestures_swipe-right","gestures_swipe-up","gestures_tap-01","gestures_tap-02","sport_badminton","sport_baseball-ball","sport_baseball-bat","sport_baseball","sport_basketball-12","sport_basketball-13","sport_boxing","sport_cardio","sport_cricket","sport_crown","sport_dart","sport_dumbbells","sport_energy-drink","sport_energy-supplement","sport_fencing","sport_fishing","sport_flag-finish","sport_football-headguard","sport_golf","sport_helmet","sport_hockey","sport_kettlebell","sport_ping-pong","sport_podium-trophy","sport_podium","sport_rope","sport_rugby","sport_shaker","sport_shoe-run","sport_skateboard","sport_snowboard","sport_soccer-field","sport_steering-wheel","sport_supplement","sport_surf","sport_tactic","sport_tennis-ball","sport_tennis","sport_trophy","sport_user-balance","sport_user-climb","sport_user-meditation","sport_user-run","sport_user-snowboard","sport_user-swim","sport_volleyball","sport_whistle","holidays_bat","holidays_biscuit","holidays_bones","holidays_boot","holidays_candy","holidays_cat","holidays_cauldron","holidays_chimney","holidays_cockade","holidays_coffin","holidays_dead-hand","holidays_decoration","holidays_deer","holidays_egg-38","holidays_egg-39","holidays_frankenstein","holidays_ghost","holidays_gift-exchange","holidays_gift","holidays_glove","holidays_grave","holidays_light","holidays_message","holidays_mistletoe","holidays_owl","holidays_pumpkin","holidays_rabbit","holidays_santa-hat","holidays_sickle","holidays_snow-ball","holidays_snowman-head","holidays_snowman","holidays_soak","holidays_spider","holidays_tree-ball","holidays_tree","holidays_vampire","holidays_witch-hat","holidays_wolf","holidays_zombie","nature_bear","nature_bee","nature_butterfly","nature_chicken","nature_clover","nature_collar","nature_cow","nature_dog-house","nature_dog","nature_flower-05","nature_flower-06","nature_flower-07","nature_food-dog","nature_food","nature_forest","nature_mountain","nature_mushroom","nature_panda","nature_paw","nature_pig","nature_plant-ground","nature_plant-vase","nature_rat","nature_sheep","nature_snake","nature_tree-01","nature_tree-02","nature_tree-03","nature_turtle","nature_wood","travel_axe","travel_backpack","travel_bag","travel_barbecue","travel_beach-umbrella","travel_berlin","travel_binocular","travel_camper","travel_camping","travel_castle","travel_china","travel_church","travel_drink","travel_explore","travel_fire","travel_hotel-bell","travel_hotel-symbol","travel_hotel","travel_hut","travel_igloo","travel_info","travel_istanbul","travel_jellyfish","travel_lamp","travel_lighthouse","travel_london","travel_luggage","travel_mosque","travel_ny","travel_octopus","travel_paris-tower","travel_passport","travel_pickaxe","travel_pool","travel_pyramid","travel_rackets","travel_rio","travel_road-sign-left","travel_road-sign-right","travel_rome","travel_rowing","travel_sea-mask","travel_sf-bridge","travel_shark","travel_spa","travel_sunglasses","travel_surf","travel_swimsuit","travel_swimwear","travel_swiss-knife","travel_temple-02","travel_temple-25","travel_trolley","travel_white-house","travel_world","travel_worldmap","food_alcohol","food_apple","food_baby","food_bacon","food_baguette","food_banana","food_barbecue-02","food_barbecue-15","food_barbecue-tools","food_beer-95","food_beer-96","food_beverage","food_bottle-wine","food_bottle","food_bowl","food_bread","food_broccoli","food_cake-13","food_cake-100","food_cake-slice","food_candle","food_candy","food_carrot","food_champagne","food_cheese-24","food_cheese-87","food_cheeseburger","food_chef-hat","food_cherry","food_chicken","food_chili","food_chinese","food_chips","food_chocolate","food_cocktail","food_coffe-long","food_coffee-long","food_coffee","food_cookies","food_course","food_crab","food_croissant","food_cutlery-75","food_cutlery-76","food_cutlery-77","food_dishwasher","food_donut","food_drink","food_egg","food_energy-drink","food_fish","food_fishbone","food_fridge","food_glass","food_grape","food_hob","food_hot-dog","food_ice-cream-22","food_ice-cream-72","food_jam","food_kettle","food_kitchen-fan","food_knife","food_lemon-slice","food_lighter","food_lobster","food_matches","food_measuring-cup","food_meat-spit","food_microwave","food_milk","food_moka","food_muffin","food_mug","food_oven","food_pan","food_pizza-slice","food_pizza","food_plate","food_pot","food_prosciutto","food_recipe-book-46","food_recipe-book-47","food_rolling-pin","food_salt","food_sausage","food_scale","food_scotch","food_shrimp","food_steak","food_store","food_strawberry","food_sushi","food_tacos","food_tea","food_temperature","food_vest-07","food_vest-31","food_watermelon","food_whisk","emoticons_alien","emoticons_angry-10","emoticons_angry-44","emoticons_big-eyes","emoticons_big-smile","emoticons_bigmouth","emoticons_bleah","emoticons_blind","emoticons_bomb","emoticons_bored","emoticons_cake","emoticons_cry-15","emoticons_cry-57","emoticons_cute","emoticons_devil","emoticons_disgusted","emoticons_fist","emoticons_ghost","emoticons_hannibal","emoticons_happy-sun","emoticons_kid","emoticons_kiss","emoticons_laugh-17","emoticons_laugh-35","emoticons_like-no","emoticons_like","emoticons_mad-12","emoticons_mad-58","emoticons_malicious","emoticons_manga-62","emoticons_manga-63","emoticons_monster","emoticons_nerd-22","emoticons_nerd-23","emoticons_ninja","emoticons_no-words","emoticons_parrot","emoticons_penguin","emoticons_pirate","emoticons_poop","emoticons_puzzled","emoticons_quite-happy","emoticons_robot","emoticons_rock","emoticons_sad","emoticons_satisfied","emoticons_shark","emoticons_shy","emoticons_sick","emoticons_silly","emoticons_skull","emoticons_sleep","emoticons_sloth","emoticons_smart","emoticons_smile","emoticons_soldier","emoticons_speechless","emoticons_spiteful","emoticons_sunglasses-48","emoticons_sunglasses-49","emoticons_surprise","emoticons_upset-13","emoticons_upset-14","emoticons_virus","emoticons_what","emoticons_whiskers","emoticons_wink-06","emoticons_wink-11","emoticons_wink-69","weather_celsius","weather_cloud-13","weather_cloud-14","weather_cloud-drop","weather_cloud-fog-31","weather_cloud-fog-32","weather_cloud-hail","weather_cloud-light","weather_cloud-moon","weather_cloud-rain","weather_cloud-rainbow","weather_cloud-snow-34","weather_cloud-snow-42","weather_cloud-sun-17","weather_cloud-sun-19","weather_compass","weather_drop-12","weather_drop-15","weather_drops","weather_eclipse","weather_fahrenheit","weather_fog","weather_forecast","weather_hurricane-44","weather_hurricane-45","weather_moon-cloud-drop","weather_moon-cloud-fog","weather_moon-cloud-hail","weather_moon-cloud-light","weather_moon-cloud-rain","weather_moon-cloud-snow-61","weather_moon-cloud-snow-62","weather_moon-fog","weather_moon-full","weather_moon-stars","weather_moon","weather_rain-hail","weather_rain","weather_rainbow","weather_snow","weather_sun-cloud-drop","weather_sun-cloud-fog","weather_sun-cloud-hail","weather_sun-cloud-light","weather_sun-cloud-rain","weather_sun-cloud-snow-54","weather_sun-cloud-snow-55","weather_sun-cloud","weather_sun-fog-29","weather_sun-fog-30","weather_sun-fog-43","weather_sun","weather_wind","transportation_air-baloon","transportation_bike-sport","transportation_bike","transportation_boat-front","transportation_boat-small-02","transportation_boat-small-03","transportation_boat","transportation_bus-front-10","transportation_bus-front-12","transportation_bus","transportation_car-front","transportation_car-simple","transportation_car-sport","transportation_car-taxi","transportation_car","transportation_helicopter","transportation_helmet","transportation_light-traffic","transportation_moto","transportation_plane-17","transportation_plane-18","transportation_road","transportation_skateboard","transportation_tractor","transportation_train-speed","transportation_train","transportation_tram","transportation_truck-front","transportation_vespa-front","transportation_vespa","education_abc","education_agenda-bookmark","education_atom","education_award-55","education_backpack-57","education_backpack-58","education_ball-basket","education_ball-soccer","education_board-51","education_book-39","education_book-bookmark","education_book-open","education_books-46","education_chalkboard","education_flask","education_glasses","education_grammar-check","education_hat","education_language","education_microscope","education_molecule","education_notepad","education_paper-diploma","education_paper","education_pencil-47","education_school","objects_alien-29","objects_alien-33","objects_anchor","objects_astronaut","objects_axe","objects_baby-bottle","objects_baby","objects_baloon","objects_battery","objects_bear","objects_billiard","objects_binocular","objects_bow","objects_bowling","objects_broom","objects_cone","objects_controller","objects_diamond","objects_dice","objects_globe","objects_hut","objects_key-25","objects_key-26","objects_lamp","objects_leaf-36","objects_leaf-38","objects_light","objects_pipe","objects_planet","objects_puzzle-09","objects_puzzle-10","objects_shovel","objects_skull","objects_spaceship","objects_spray","objects_support-16","objects_support-17","objects_umbrella-13","objects_umbrella-14","objects_wool-ball","media-1_3d","media-1_action-73","media-1_action-74","media-1_album","media-1_audio-91","media-1_audio-92","media-1_balance","media-1_brightness-46","media-1_brightness-47","media-1_button-circle-pause","media-1_button-circle-play","media-1_button-circle-stop","media-1_button-eject","media-1_button-next","media-1_button-pause","media-1_button-play","media-1_button-power","media-1_button-previous","media-1_button-record","media-1_button-rewind","media-1_button-skip","media-1_button-stop","media-1_camera-18","media-1_camera-19","media-1_camera-20","media-1_camera-ban-36","media-1_camera-ban-37","media-1_camera-compact","media-1_camera-screen","media-1_camera-square-57","media-1_camera-square-58","media-1_camera-time","media-1_countdown-34","media-1_countdown-35","media-1_edit-color","media-1_edit-contrast-42","media-1_edit-contrast-43","media-1_edit-saturation","media-1_flash-21","media-1_flash-24","media-1_flash-29","media-1_flash-auto-22","media-1_flash-auto-25","media-1_flash-off-23","media-1_flash-off-26","media-1_focus-32","media-1_focus-38","media-1_focus-40","media-1_focus-circle","media-1_frame-12","media-1_frame-41","media-1_grid","media-1_image-01","media-1_image-02","media-1_image-05","media-1_image-add","media-1_image-delete","media-1_image-location","media-1_kid","media-1_layers","media-1_lens-31","media-1_lens-56","media-1_macro","media-1_movie-61","media-1_movie-62","media-1_night","media-1_picture","media-1_play-68","media-1_play-69","media-1_player","media-1_polaroid-add","media-1_polaroid-delete","media-1_polaroid-multiple","media-1_polaroid-user","media-1_polaroid","media-1_roll","media-1_rotate-left","media-1_rotate-right","media-1_sd","media-1_selfie","media-1_shake","media-1_speaker","media-1_sport","media-1_ticket-75","media-1_ticket-76","media-1_touch","media-1_tripod","media-1_video-64","media-1_video-65","media-1_video-66","media-1_video-67","media-1_videocamera-71","media-1_videocamera-72","media-1_volume-93","media-1_volume-97","media-1_volume-98","media-1_volume-ban","media-1_volume-down","media-1_volume-off","media-1_volume-up","media-2_guitar","media-2_headphones-mic","media-2_headphones","media-2_knob","media-2_mic","media-2_music-album","media-2_music-cloud","media-2_note-03","media-2_note-04","media-2_piano","media-2_radio","media-2_remix","media-2_sound-wave","media-2_speaker-01","media-2_speaker-05","media-2_tape","location_appointment","location_bookmark-add","location_bookmark-remove","location_bookmark","location_compass-04","location_compass-05","location_compass-06","location_crosshair","location_explore-user","location_explore","location_flag-complex","location_flag-diagonal-33","location_flag-diagonal-34","location_flag-points-31","location_flag-points-32","location_flag-simple","location_flag-triangle","location_flag","location_gps","location_map-big","location_map-compass","location_map-gps","location_map-marker","location_map-pin","location_map","location_marker","location_pin-add","location_pin-copy","location_pin-remove","location_pin","location_pins","location_position-marker","location_position-pin","location_position-user","location_radar","location_road","location_route-alert","location_route-close","location_route-open","location_square-marker","location_square-pin","location_treasure-map-21","location_treasure-map-40","location_worl-marker","location_world-pin","location_world","health_ambulance","health_apple","health_bag-49","health_bag-50","health_brain","health_dna-27","health_dna-38","health_doctor","health_flask","health_heartbeat-16","health_height","health_hospital-32","health_hospital-33","health_hospital-34","health_humidity-26","health_humidity-52","health_intestine","health_lungs","health_molecule-39","health_molecule-40","health_notebook","health_nurse","health_patch-46","health_pill-42","health_pill-43","health_pill-container-44","health_pill-container-47","health_pulse-chart","health_pulse-phone","health_pulse-sleep","health_pulse-watch","health_pulse","health_sleep","health_steps","health_syringe","health_temperature-23","health_temperature-24","health_tooth","health_weed","health_weight","health_wheelchair","health_woman","furniture_air-conditioner","furniture_armchair","furniture_bath-tub","furniture_bed-09","furniture_bed-23","furniture_bed-side","furniture_cabinet","furniture_cactus","furniture_chair","furniture_coat-hanger","furniture_coffee","furniture_cradle","furniture_curtain","furniture_desk-drawer","furniture_desk","furniture_door","furniture_drawer","furniture_fridge","furniture_hanger-clothes","furniture_hanger","furniture_heater","furniture_iron","furniture_lamp-floor","furniture_lamp","furniture_library","furniture_light","furniture_mixer","furniture_oven","furniture_shower","furniture_sink-wash","furniture_sink","furniture_sofa","furniture_storage-hanger","furniture_storage","furniture_table","furniture_toilet-paper","furniture_toilet","furniture_tv","furniture_wardrobe","furniture_wash","clothes_baby","clothes_backpack","clothes_bag-21","clothes_bag-22","clothes_belt","clothes_boot-woman","clothes_boot","clothes_bra","clothes_button","clothes_cap","clothes_coat","clothes_corset","clothes_dress-man","clothes_dress-woman","clothes_flip","clothes_glasses","clothes_gloves","clothes_hat-top","clothes_hat","clothes_hoodie","clothes_iron-dont","clothes_iron","clothes_jeans-41","clothes_jeans-43","clothes_jeans-pocket","clothes_kitchen","clothes_long-sleeve","clothes_makeup","clothes_needle","clothes_pajamas","clothes_ring","clothes_scarf","clothes_shirt-business","clothes_shirt-buttons","clothes_shirt-neck","clothes_shirt","clothes_shoe-man","clothes_shoe-sport","clothes_shoe-woman","clothes_skirt","clothes_slacks-12","clothes_slacks-13","clothes_sock","clothes_tie-bow","clothes_tshirt-53","clothes_tshirt-54","clothes_tshirt-sport","clothes_underwear-man","clothes_underwear","clothes_vest-sport","clothes_vest","clothes_wash-30","clothes_wash-60","clothes_wash-90","clothes_wash-hand","clothes_wash","business_agenda","business_atm","business_award-48","business_award-49","business_award-74","business_badge","business_bank","business_board-27","business_board-28","business_board-29","business_board-30","business_books","business_briefcase-24","business_briefcase-25","business_briefcase-26","business_building","business_bulb-61","business_bulb-62","business_bulb-63","business_business-contact-85","business_business-contact-86","business_business-contact-87","business_business-contact-88","business_business-contact-89","business_businessman-03","business_businessman-04","business_calculator","business_chair","business_chart-bar-32","business_chart-bar-33","business_chart-growth","business_chart-pie-35","business_chart-pie-36","business_chart","business_cheque","business_coins","business_connect","business_contacts","business_currency-dollar","business_currency-euro","business_currency-pound","business_currency-yen","business_factory","business_globe","business_goal-64","business_goal-65","business_gold","business_hammer","business_handout","business_handshake","business_hat","business_hierarchy-53","business_hierarchy-54","business_hierarchy-55","business_hierarchy-56","business_laptop-71","business_laptop-72","business_laptop-91","business_law","business_math","business_money-11","business_money-12","business_money-13","business_money-bag","business_money-coins","business_money-growth","business_money-time","business_net","business_notes","business_payment","business_percentage-38","business_percentage-39","business_pig","business_pin","business_plug","business_progress","business_round-dollar","business_round-euro","business_round-pound","business_round-yen","business_safe","business_scale","business_sign","business_signature","business_stock","business_strategy","business_tie-01","business_tie-02","business_wallet-43","business_wallet-44","business_wallet-90");
            $dlicon_full = array();
            foreach ($dlicon as $item){
                $dlicon_full[] = 'dlicon ' .  $item;
            }
            $icon_packages[] = array(
                'name' => 'LaStudio Icon',
                'icons' => $dlicon_full
            );
        }

        return apply_filters('lastudio/filter/framework/field/icon/packages', $icon_packages);
	}

	/**
	 * Get icons from admin ajax
	 *
	 * @since 1.0.0
	 */
	public function ajax_get_icons(){
		$icons = $this->get_icon_library();
		if( ! empty( $icons ) ) {
			foreach ( $icons as $icon_object ) {
                echo ( count( $icons ) >= 2 ) ? '<h4 class="la-icon-title">'. $icon_object['name'] .'</h4>' : '';
                foreach ( $icon_object['icons'] as $icon ) {
                    echo '<a class="la-icon-tooltip" data-la-icon="'. $icon .'" data-title="'. $icon .'"><span class="la-icon--selector la-selector"><i class="'. $icon .'"></i></span></a>';
                }
			}
		}
		die();
	}

	/**
	 * Render icon on admin footer
	 *
	 * @since 1.0.0
	 */
	public function render_admin_footer(){
		include_once plugin_dir_path( dirname(__FILE__) ) . 'admin/partials/admin-footer.php';
	}

	/**
	 * Get value form admin field autocomplete
	 *
	 * @since 1.0.0
	 */
	public function ajax_autocomplete(){
		if ( empty( $_GET['query_args'] ) || empty( $_GET['s'] ) ) {
			echo '<b>' . __('Query is empty ...', 'lastudio' ) . '</b>';
			die();
		}
		ob_start();

		$args = array(
			's' => $_GET['s']
		);

		$query = new WP_Query( wp_parse_args( $_GET['query_args'], $args ) );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				echo '<div data-id="' . get_the_ID() . '">' . get_the_title() . '</div>';
			}
		} else {
			echo '<b>' . __('Not found', 'lastudio' ) . '</b>';
		}

		wp_reset_postdata();
		echo ob_get_clean();
		die();
	}

	/**
	 * Get theme options form export field
	 *
	 * @since 1.0.0
	 */
	public function ajax_export_options(){
		$unique = isset($_REQUEST['unique']) ? $_REQUEST['unique'] : 'la_options';
		header('Content-Type: plain/text');
		header('Content-disposition: attachment; filename=backup-'.esc_attr($unique).'-'. gmdate( 'd-m-Y' ) .'.txt');
		header('Content-Transfer-Encoding: binary');
		header('Pragma: no-cache');
		header('Expires: 0');
		echo wp_json_encode(get_option($unique));
		die();
	}

}
