<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$layout             = raz_get_theme_loop_prop('loop_layout', 'grid');
$style              = raz_get_theme_loop_prop('loop_style', 4);
$responsive_column  = raz_get_theme_loop_prop('responsive_column', array());
$slider_configs     = raz_get_theme_loop_prop('slider_configs', '');
$item_space         = raz_get_theme_loop_prop('item_space', '70');
$slider_css_class   = raz_get_theme_loop_prop('slider_css_class', '');

$is_masonry_mode    = false;

if($layout == 'masonry'){
    $layout = 'grid';
    $is_masonry_mode = true;
    raz_set_theme_loop_prop('loop_layout', $layout);
    raz_set_theme_loop_prop('is_masonry_mode', $is_masonry_mode);
}

$loopCssClass       = array('lastudio-posts','showposts-loop');
$loopCssClass[]     = $layout .'-' . $style;
$loopCssClass[]     = 'showposts-' . $layout;

if($layout == 'grid'){
    $loopCssClass[] = 'preset-type-' . $style;
}
else{
    $loopCssClass[] = 'preset-type-list-' . $style;
}

if($layout == 'grid'){
    $loopCssClass[] = 'grid-items';
    $loopCssClass[] = 'grid-space-'. $item_space;
    if(!empty($slider_configs) && !$is_masonry_mode){
        $loopCssClass[] = 'js-el la-slick-slider' . $slider_css_class;
    }
    else{
        $loopCssClass[] = raz_render_grid_css_class_from_columns($responsive_column);
    }
}
else{
    $slider_configs = '';
}

if($is_masonry_mode){
    $html_att_tag = ' data-la_component="DefaultMasonry" data-item_selector=".loop__item"';
    $loopCssClass[] = 'js-el la-isotope-container';
}
else{
    $html_att_tag = (!empty($slider_configs) ? ' data-la_component="AutoCarousel" ' . $slider_configs : '');
}

printf(
    '<div class="%1$s"%2$s>',
    esc_attr(implode(' ', $loopCssClass)),
    $html_att_tag
);

if( $layout == 'list' && $style == 1){
    echo '<div class="loop__item__one blog__item">';
}