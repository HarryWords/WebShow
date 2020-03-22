<?php
/**
 * Portfolio template
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$layout             = raz_get_theme_loop_prop('loop_layout', 'grid');
$style              = raz_get_theme_loop_prop('loop_style', 1);
$responsive_column  = raz_get_theme_loop_prop('responsive_column', array());

$outer_classes = array('lastudio-portfolio');
$inner_classes = array('lastudio-portfolio__list');

$outer_classes[] = 'layout-type-' . $layout;
$outer_classes[] = 'preset-type-' . $style;

if ( 'masonry' == $layout || 'grid' == $layout ) {
    $outer_classes[] = 'playout-grid';
    $inner_classes[] = 'grid-items';
    $inner_classes[] = raz_render_grid_css_class_from_columns($responsive_column);
}

if('masonry' == $layout){
    $inner_classes[] = 'js-el';
    $inner_classes[] = 'la-isotope-container';
}

?>
<div class="<?php echo esc_attr( join(' ', $outer_classes ));?>">
    <div class="lastudio-portfolio__list_wrapper">
        <div class="<?php echo esc_attr( join(' ', $inner_classes ));?>"<?php
        if('masonry' == $layout){
            echo ' data-item_selector=".loop__item"';
            echo ' data-la_component="DefaultMasonry"';
        }
        ?>>