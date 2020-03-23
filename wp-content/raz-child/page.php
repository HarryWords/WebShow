<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header(); ?>
<?php do_action( 'raz/action/before_render_main' ); ?>
    <div id="main" class="site-main">
        <div class="container">
            <div class="row">
                <main id="site-content" class="<?php echo esc_attr(Raz()->layout()->get_main_content_css_class('col-xs-12 site-content'))?>">
                    <div class="site-content-inner">

                        <?php do_action( 'raz/action/before_render_main_inner' );?>

                        <div class="page-content<?php if(!get_post_meta( get_the_ID(), '_elementor_edit_mode', true )){ echo ' entry-content entry-content-no-builder'; } ?>">
                            <?php

                            do_action( 'raz/action/before_render_main_content' );

                            if( have_posts() ) :  the_post();

                                the_content();

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="clearfix"></div><div class="page-links"><span class="page-links-title">' . esc_html_x( 'Pages:','front-view', 'raz' ) . '</span>',
                                        'after' => '</div>',
                                        'link_before' => '<span>',
                                        'link_after' => '</span>'
                                    )
                                );

                            endif;

                            do_action( 'raz/action/after_render_main_content' );

                            ?>
                        </div>

                        <!-- <?php
                        if ( comments_open() || get_comments_number() ) :
                            echo '<div class="clearfix"></div><div class="single-post-detail padding-top-30">';
                            comments_template();
                            echo '</div>';
                        endif;
                        ?> -->

                        <?php do_action( 'raz/action/after_render_main_inner' );?>
                    </div>
                </main>
                <!-- #site-content -->
                <?php get_sidebar();?>
            </div>
        </div>
    </div>
    <!-- .site-main -->
<?php do_action( 'raz/action/after_render_main' ); ?>
<?php get_footer();?>