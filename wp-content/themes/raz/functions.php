<?php

//禁用谷歌字体
if (!function_exists('remove_wp_open_sans')) :
function remove_wp_open_sans() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
}
// 前台删除Google字体CSS   
add_action('wp_enqueue_scripts', 'remove_wp_open_sans');
// 后台删除Google字体CSS   
add_action('admin_enqueue_scripts', 'remove_wp_open_sans');
endif;





if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Require plugins vendor
 */

require_once get_template_directory() . '/plugins/tgm-plugin-activation/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/plugins/plugins.php';

/**
 * Include the main class.
 */

include_once get_template_directory() . '/framework/classes/class-core.php';


Raz::$template_dir_path   = get_template_directory();
Raz::$template_dir_url    = get_template_directory_uri();
Raz::$stylesheet_dir_path = get_stylesheet_directory();
Raz::$stylesheet_dir_url  = get_stylesheet_directory_uri();

/**
 * Include the autoloader.
 */
include_once Raz::$template_dir_path . '/framework/classes/class-autoload.php';

new Raz_Autoload();

/**
 * load functions for later usage
 */

require_once Raz::$template_dir_path . '/framework/functions/functions.php';

new Raz_Multilingual();

if(!function_exists('Raz')){
    function Raz(){
        return Raz::get_instance();
    }
}

Raz();

new Raz_Scripts();

new Raz_Admin();

new Raz_WooCommerce();

new Raz_WooCommerce_Wishlist();

new Raz_WooCommerce_Compare();

/**
 * Set the $content_width global.
 */
global $content_width;
if ( ! is_admin() ) {
    if ( ! isset( $content_width ) || empty( $content_width ) ) {
        $content_width = (int) Raz()->layout()->get_content_width();
    }
}

require_once Raz::$template_dir_path . '/framework/functions/extra-functions.php';

require_once Raz::$template_dir_path . '/framework/functions/update.php';
