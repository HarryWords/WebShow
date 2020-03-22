<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<header id="lastudio-header-builder" class="lahb-wrap default-header">
    <div class="lahbhouter">
        <div class="lahbhinner">
            <div class="main-slide-toggle"></div>
            <div class="lahb-screen-view lahb-desktop-view">
                <div class="lahb-area lahb-row1-area lahb-content-middle lahb-area__auto">
                    <div class="container">
                        <div class="lahb-content-wrap lahb-area__auto">
                            <div class="lahb-col lahb-col__left">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="lahb-element lahb-logo">
                                    <?php Raz()->layout()->render_logo();?>
                                </a>
                            </div>
                            <div class="lahb-col lahb-col__center"></div>
                            <div class="lahb-col lahb-col__right">
                                <div class="lahb-responsive-menu-wrap lahb-responsive-menu-1546041916358" data-uniqid="1546041916358">
                                    <div class="close-responsive-nav">
                                        <div class="lahb-menu-cross-icon"></div>
                                    </div>
                                    <ul class="responav menu">
                                        <?php
                                        $menu_output = wp_nav_menu( array(
                                            'theme_location' => 'main-nav',
                                            'container'     => false,
                                            'link_before'   => '',
                                            'link_after'    => '',
                                            'items_wrap'    => '%3$s',
                                            'echo'          => false,
                                            'fallback_cb'   => array( 'Raz_MegaMenu_Walker', 'fallback' ),
                                            'walker'        => new Raz_MegaMenu_Walker
                                        ));
                                        echo raz_render_variable($menu_output);
                                        ?>
                                    </ul>
                                </div>
                                <nav class="lahb-element has-parent-arrow lahb-nav-wrap nav__wrap_1546041916358" data-uniqid="1546041916358"><ul class="menu"><?php echo raz_render_variable($menu_output); ?></ul></nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lahb-screen-view lahb-tablets-view">
                <div class="lahb-area lahb-row1-area lahb-content-middle lahb-area__auto">
                    <div class="container">
                        <div class="lahb-content-wrap lahb-area__auto">
                            <div class="lahb-col lahb-col__left">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="lahb-element lahb-logo">
                                    <?php Raz()->layout()->render_logo();?>
                                </a>
                            </div>
                            <div class="lahb-col lahb-col__center"></div>
                            <div class="lahb-col lahb-col__right">
                                <div class="lahb-element lahb-responsive-menu-icon-wrap nav__res_hm_icon_1546041916358" data-uniqid="1546041916358"><a href="#"><i class="fa fa-bars"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lahb-screen-view lahb-mobiles-view">
                <div class="lahb-area lahb-row1-area lahb-content-middle lahb-area__auto">
                    <div class="container">
                        <div class="lahb-content-wrap lahb-area__auto">
                            <div class="lahb-col lahb-col__left">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="lahb-element lahb-logo">
                                    <?php Raz()->layout()->render_logo();?>
                                </a>
                            </div>
                            <div class="lahb-col lahb-col__center"></div>
                            <div class="lahb-col lahb-col__right">
                                <div class="lahb-element lahb-responsive-menu-icon-wrap nav__res_hm_icon_1546041916358" data-uniqid="1546041916358"><a href="#"><i class="fa fa-bars"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lahb-wrap-sticky-height"></div>
    </div>
</header>