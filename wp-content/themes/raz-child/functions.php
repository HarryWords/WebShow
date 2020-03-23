<?php


//屏蔽gravatar,调用多说缓存图片
function duoshuo_avatar($avatar) {
$avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"gravatar.duoshuo.com",$avatar);
return $avatar;
}
add_filter( 'get_avatar', 'duoshuo_avatar', 10, 3 );
//屏蔽谷歌文字
function coolwp_remove_open_sans_from_wp_core() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
wp_enqueue_style('open-sans','');
}
add_action( 'init', 'coolwp_remove_open_sans_from_wp_core' );

//移除谷歌字体 
function remove_open_sans() { wp_deregister_style( 'open-sans' ); wp_register_style( 'open-sans', false ); wp_enqueue_style('open-sans',''); } add_action( 'init', 'remove_open_sans' );

/**
 * Child Theme Function
 *
 */

add_action( 'after_setup_theme', 'raz_child_theme_setup' );
add_action( 'wp_enqueue_scripts', 'raz_child_enqueue_styles', 20);

if( !function_exists('raz_child_enqueue_styles') ) {
    function raz_child_enqueue_styles() {
        wp_enqueue_style( 'raz-child-style',
            get_stylesheet_directory_uri() . '/style.css',
            array( 'raz-theme' ),
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style( 'my-style', get_stylesheet_directory_uri() . '/index.css', false, '1.0', 'all' );
    }
}

if( !function_exists('raz_child_theme_setup') ) {
    function raz_child_theme_setup() {
        load_child_theme_textdomain( 'raz-child', get_stylesheet_directory() . '/languages' );
    }
}
// --------------------------------baseboot------------------------

// 关闭价格
//Hide price 关闭价格
add_filter( 'woocommerce_get_price_html', 'woocommerce_hide_price' );
function woocommerce_hide_price( $price ){
    return '';
}

//Hide buy button (add_to_cart) 关闭加入购物车按钮
add_action( 'init', 'woocommerce_hide_buy_button' );
function woocommerce_hide_buy_button(){
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_single_product_summary', 'add_compare_btn', 45 );
}

// 移除admin  more wp
function annointed_admin_bar_remove() {
global $wp_admin_bar;
$wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);

add_filter('admin_title', 'removeWtitle', 10, 2);
function removeWtitle($admin_title, $title){
return $title.' &lsaquo; '.get_bloginfo('name');
}

function footerText () {
	return '<a href="https://www.baseboot.cn">BaseBoot</a> 技术支持';
}
add_filter('admin_footer_text', 'footerText', 9999);

/* 移除WordPress后台底部右文字 */
add_filter('update_footer', '_admin_footer_right_text', 11);
function _admin_footer_right_text($text) {
	$text = '备步科技';
	return $text;
}

//移除 WordPress 仪表盘欢迎面板 
remove_action('welcome_panel', 'wp_welcome_panel');


function my_change_role_name($wp_roles) {
 
// 修改管理员名称
 
$wp_roles->roles['administrator']['name'] = '董事长';
 
$wp_roles->role_names['administrator'] = '董事长';
 
// 修改编辑名称
 
$wp_roles->roles['editor']['name'] = 'I管理员';
 
$wp_roles->role_names['editor'] = 'I管理员';
 
// 修改作者名称
 
$wp_roles->roles['author']['name'] = '经理';
 
$wp_roles->role_names['author'] = '经理';
 
// 修改撰稿人名称
 
$wp_roles->roles['contributor']['name'] = '工头';
 
$wp_roles->role_names['contributor'] = '工头';
 
// 修改订阅者名称
 
$wp_roles->roles['subscriber']['name'] = '民工';
 
$wp_roles->role_names['subscriber'] = '民工';
 
}


// 解决头像问题 
//cdn for gravatar
add_filter( 'avatar_defaults', 'default_avatar' );
function default_avatar ( $avatar_defaults ) {
	$myavatar = get_bloginfo('template_url'). '/images/default/male_avatar.png';
	$avatar_defaults[$myavatar] = "自定义默认头像";
	return $avatar_defaults;
}


add_filter('automatic_updater_disabled', '__return_true');  // 彻底关闭自动更新
remove_action('init', 'wp_schedule_update_checks'); // 关闭更新检查定时作业
wp_clear_scheduled_hook('wp_version_check');            // 移除已有的版本检查定时作业
wp_clear_scheduled_hook('wp_update_plugins');       // 移除已有的插件更新定时作业
wp_clear_scheduled_hook('wp_update_themes');            // 移除已有的主题更新定时作业
wp_clear_scheduled_hook('wp_maybe_auto_update');        // 移除已有的自动更新定时作业
remove_action( 'admin_init', '_maybe_update_core' );        // 移除后台内核更新检查
remove_action( 'load-plugins.php', 'wp_update_plugins' );   // 移除后台插件更新检查
remove_action( 'load-update.php', 'wp_update_plugins' );
remove_action( 'load-update-core.php', 'wp_update_plugins' );
remove_action( 'admin_init', '_maybe_update_plugins' );
remove_action( 'load-themes.php', 'wp_update_themes' );     // 移除后台主题更新检查
remove_action( 'load-update.php', 'wp_update_themes' );
remove_action( 'load-update-core.php', 'wp_update_themes' );

// disable  discuss
// function filter_media_comment_status( $open, $post_id ) {
//     $post = get_post( $post_id );
//     if( $post->post_type == 'attachment' ) {
//         return false;
//     }
//     return $open;
// }
// add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );


//移除后台帮助
function remove_screen_options(){ return false;}
    add_filter('screen_options_show_screen', 'remove_screen_options');
    add_filter( 'contextual_help', 'wpse50723_remove_help', 999, 3 );
    function wpse50723_remove_help($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}
//删除wordpress后台仪表盘模块
function example_remove_dashboard_widgets() {
// Globalize the metaboxes array, this holds all the widgets for wp-admin
global $wp_meta_boxes;
// 以下这一行代码将删除 "快速发布" 模块
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
// 以下这一行代码将删除 "引入链接" 模块
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
// 以下这一行代码将删除 "插件" 模块
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
// 以下这一行代码将删除 "近期评论" 模块
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
// 以下这一行代码将删除 "近期草稿" 模块
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
// 以下这一行代码将删除 "WordPress 开发日志" 模块
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
// 以下这一行代码将删除 "其它 WordPress 新闻" 模块
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
// 以下这一行代码将删除 "概况" 模块
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );
remove_action('welcome_panel', 'wp_welcome_panel');
function remove_dashboard_meta() {
remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//3.8版开始
}
add_action( 'admin_init', 'remove_dashboard_meta' );

//移除后台外观-编辑，防止用户编辑导致错误
// function remove_submenu() {
// remove_submenu_page( 'themes.php', 'theme-editor.php' );
// }
// if ( is_admin() ) {
// add_action('admin_init','remove_submenu');
// }



//禁用页面的评论功能
function disable_page_comments( $posts ) {
    if ( is_page()) {
    $posts[0]->comment_status = 'disabled';
    $posts[0]->ping_status = 'disabled';
}
return $posts;
}
add_filter( 'the_posts', 'disable_page_comments' );
// 

// --------------------------------baseboot------------------------

// --------------------------------上线后使用------------------------
// function remove_menus() {
//     global $menu;
//     $restricted = array(
//         __('Dashboard'),
//         __('Posts'),
//         __('Media'),
//         __('Links'),
//         __('Pages'),
//         __('Appearance'),
//         __('Tools'),
//         __('Users'),
//         __('Settings'),
//         __('Comments'),
//         __('Plugins')
//     );
//     end ($menu);
//     while (prev($menu)){
//         $value = explode(' ',$menu[key($menu)][0]);
//         if(strpos($value[0], '<') === FALSE) {
//             if(in_array($value[0] != NULL ? $value[0]:"" , $restricted)){
//                 unset($menu[key($menu)]);
//             }
//         }else {
//         $value2 = explode('<', $value[0]);
//             if(in_array($value2[0] != NULL ? $value2[0]:"" , $restricted)){
//                 unset($menu[key($menu)]);
//             }
//         }
//     }
// }
// if (is_admin()){
//     // 屏蔽左侧菜单
//     add_action('admin_menu', 'remove_menus');
// }
// --------------------------------上线后使用------------------------
