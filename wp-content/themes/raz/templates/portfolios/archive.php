<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $raz_loop;

$tmp = $raz_loop;
$raz_loop = array();

$loop_layout = Raz()->settings()->get('portfolio_display_type', 'grid');
$loop_style = Raz()->settings()->get('portfolio_display_style', '1');

$height_mode        = raz_get_theme_loop_prop('height_mode', 'original');
$thumb_custom_height= raz_get_theme_loop_prop('height', '');

raz_set_theme_loop_prop('is_main_loop', true, true);
raz_set_theme_loop_prop('loop_layout', $loop_layout);
raz_set_theme_loop_prop('loop_style', $loop_style);
raz_set_theme_loop_prop('responsive_column', Raz()->settings()->get('portfolio_column', array('xlg'=> 1, 'lg'=> 1,'md'=> 1,'sm'=> 1,'xs'=> 1)));
raz_set_theme_loop_prop('image_size', Raz()->settings()->get('portfolio_thumbnail_size', 'full'));
raz_set_theme_loop_prop('title_tag', 'h3');
raz_set_theme_loop_prop('excerpt_length', '15');
raz_set_theme_loop_prop('item_space', Raz()->settings()->get('portfolio_item_space', 'default'));
raz_set_theme_loop_prop('height_mode', Raz()->settings()->get('portfolio_thumbnail_height_mode', 'original'));
raz_set_theme_loop_prop('height', Raz()->settings()->get('portfolio_thumbnail_height_custom', ''));

echo '<div id="archive_portfolio_listing" class="la-portfolio-listing">';

if( have_posts() ){

    get_template_part("templates/portfolios/start", $loop_style);

    while( have_posts() ){

        the_post();

        get_template_part("templates/portfolios/loop", $loop_style);

    }

    get_template_part("templates/portfolios/end", $loop_style);

}

echo '</div>';
/**
 * Display pagination and reset loop
 */

raz_the_pagination();

wp_reset_postdata();

$raz_loop = $tmp;