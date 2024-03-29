<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$site_layout = Raz()->layout()->get_site_layout();
?>
<?php if( $site_layout != 'col-1c' ): ?>
    <aside id="sidebar_primary" class="<?php echo esc_attr(Raz()->layout()->get_main_sidebar_css_class('col-xs-12'));?>">
        <div class="sidebar-inner">
            <?php
				dynamic_sidebar(apply_filters('raz/filter/sidebar_primary_name', 'sidebar-primary'));
            ?>
        </div>
    </aside>
<?php endif;?>