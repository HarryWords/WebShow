<?php

$view_mode = Raz()->settings()->get('shop_catalog_display_type', 'grid');

$view_mode = apply_filters('raz/filter/catalog_view_mode', $view_mode);

$per_page_array = Raz_WooCommerce::product_per_page_array();
$per_page = Raz_WooCommerce::product_per_page();
$current_url = add_query_arg(null, null);
$current_url = remove_query_arg(array('page', 'paged', 'mode_view', 'la_doing_ajax'), $current_url);
$current_url = preg_replace('/\/page\/\d+/', '', $current_url);

$active_shop_filter = Raz()->settings()->get('active_shop_filter', 'off');
$hide_shop_toolbar = Raz()->settings()->get('hide_shop_toolbar', 'off');
$woocommerce_toggle_grid_list = Raz()->settings()->get('woocommerce_toggle_grid_list', 'off');
?>
<div class="wc-toolbar-container<?php if ( raz_string_to_bool($active_shop_filter) && is_active_sidebar('sidebar-shop-filter')): ?> has-adv-filters<?php endif; ?>">
    <div class="wc-toolbar wc-toolbar-top clearfix">
        <?php if(!is_product()): ?>
            <?php if($hide_shop_toolbar != 'on'): ?>
            <div class="wc-toolbar-left">
                <?php woocommerce_result_count();?>
                <?php if(!empty($per_page_array)): ?>
                    <div class="wc-view-count">
                        <p><?php echo esc_html_x('Show', 'front-view', 'raz'); ?></p>
                        <ul><?php
                            foreach ($per_page_array as $val){?><li
                                <?php if($per_page == $val) { echo ' class="active"'; } ?>><a href="<?php echo esc_url(add_query_arg('per_page', $val, $current_url)); ?>"><?php echo sprintf( esc_html('%s'), $val ) ?></a></li>
                            <?php }
                        ?></ul>
                    </div>
                <?php endif ;?>
            </div>
            <div class="wc-toolbar-right">
                <?php if( raz_string_to_bool($woocommerce_toggle_grid_list) ): ?>
                    <div class="wc-view-toggle">
                    <span data-view_mode="grid"<?php
                    if ($view_mode == 'grid') {
                        echo ' class="active"';
                    }
                    ?>><i title="<?php echo esc_attr_x('Grid view', 'front-view', 'raz') ?>" class="fa fa-th"></i></span>
                        <span data-view_mode="list"<?php
                        if ($view_mode == 'list') {
                            echo ' class="active"';
                        }
                        ?>><i title="<?php echo esc_attr_x('List view', 'front-view', 'raz') ?>" class="fa fa-list"></i></span>
                    </div>
                <?php endif;?>
                <?php if (raz_string_to_bool($active_shop_filter) && is_active_sidebar('sidebar-shop-filter')): ?>
                    <div class="btn-advanced-shop-filter">
                        <span><?php echo esc_html_x('Filters', 'front-view', 'raz'); ?></span><i></i>
                    </div>
                <?php endif; ?>
                <?php
                woocommerce_catalog_ordering();
                ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div><!-- .wc-toolbar -->

    <?php if(is_woocommerce() && !is_product()) {
        $layout = Raz()->layout()->get_site_layout();
        if (raz_string_to_bool($active_shop_filter) && is_active_sidebar('sidebar-shop-filter')) {
            ?>
            <div class="clearfix"></div>
            <div class="la-advanced-product-filters clearfix">
                <div class="sidebar-inner clearfix">
                    <?php dynamic_sidebar('sidebar-shop-filter'); ?>

                    <?php if((isset($_GET['la_preset']) && count($_GET) > 1) || (!isset($_GET['la_preset']) && count($_GET) > 0)) : ?>
                    <div class="clearfix"></div>
                    <div class="la-advanced-product-filters-result">
                        <?php
                            $base_filter = Raz_Helper::get_base_shop_url();
                            if(isset($_GET['la_preset'])){
                                $base_filter = add_query_arg('la_preset', $_GET['la_preset'], $base_filter);
                            }
                        ?>
                        <a class="reset-all-shop-filter text-color-primary" href="<?php echo esc_url($base_filter) ?>"><i class="dlicon ui-1_simple-remove"></i><span><?php echo esc_html_x('Clear All Filter', 'front-view', 'raz'); ?></span></a>
                    </div>
                    <?php endif; ?>
                </div>
                <a class="close-advanced-product-filters hidden visible-xs" href="javascript:;" rel="nofollow"><i class="lastudioicon-e-remove"></i></a>
            </div>
        <?php
        }
    }
    ?>
</div>