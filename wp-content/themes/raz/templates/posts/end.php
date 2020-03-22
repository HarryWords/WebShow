<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/*
 * Template loop-end
 */

$layout             = raz_get_theme_loop_prop('loop_layout', 'grid');
$style              = raz_get_theme_loop_prop('loop_style', 1);

global $raz_loop;
$raz_loop = array();
$blog_pagination_type = Raz()->settings()->get('blog_pagination_type', 'pagination');

echo '</div>';
?>
<!-- ./end-main-loop -->
<?php if($blog_pagination_type == 'load_more'): ?>
    <div class="blog-main-loop__btn-loadmore">
        <a href="javascript:;">
            <span><?php echo esc_html_x('Load more posts', 'front-view', 'raz'); ?></span>
        </a>
    </div>
<?php endif; ?>