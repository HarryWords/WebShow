<?php
/**
 * Images list item template
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


$loop_index         = absint(raz_get_theme_loop_prop('loop_index', 0));
$loop_index2        = absint(raz_get_theme_loop_prop('loop_index2', 0));
$image_size         = raz_get_theme_loop_prop('image_size', 'full');
$title_tag          = raz_get_theme_loop_prop('title_tag', 'h3');
$item_sizes         = raz_get_theme_loop_prop('item_sizes', array());
$style              = raz_get_theme_loop_prop('loop_style', 1);
$height_mode        = raz_get_theme_loop_prop('height_mode', 'original');
$item_w             = 1;
$item_h             = 1;

$custom_excerpt_length              = raz_get_theme_loop_prop('excerpt_length', 0);


if($loop_index2 == count($item_sizes)){
    $loop_index2 = 0;
}

if(!empty($item_sizes[$loop_index2]['w'])){
    $item_w = $item_sizes[$loop_index2]['w'];
}
if(!empty($item_sizes[$loop_index2]['h'])){
    $item_h = $item_sizes[$loop_index2]['h'];
}

$read_more_label = esc_html__('Read More', 'raz');

$term_obj = get_the_terms(get_the_ID(), 'la_portfolio_category');
$slug_list = array('all');
$cat_list = array();
if(!is_wp_error($term_obj) && !empty($term_obj)){
    foreach ($term_obj as $term){
        $slug_list[] = $term->slug;
    }
    $cat_list = wp_list_pluck($term_obj, 'name');
}

$item_image_url = get_the_post_thumbnail_url(get_the_ID(), $image_size);

$item_button_url = get_the_permalink();

$show_excerpt = true;
$show_readmore_btn = false;
$show_category = true;
$show_divider = false;

$post_classes = array(
    'loop__item',
    'grid-item',
    'lastudio-portfolio__item',
    'visible-status'
);

if($height_mode != 'original'){
    $post_classes[] = 'pf-custom-image-height';
}

?>
<article <?php post_class($post_classes) ?> data-width="<?php echo esc_attr($item_w);?>" data-height="<?php echo esc_attr($item_h);?>">
    <div class="lastudio-portfolio__inner">
        <div class="lastudio-portfolio__image_wrap">
            <a class="lastudio-images-layout__link">
                <div class="lastudio-portfolio__image" style="background-image: url('<?php echo esc_url($item_image_url); ?>')">
                    <?php the_post_thumbnail($image_size, array('class' => 'lastudio-portfolio__image-instance'));?>
                    <div class="lastudio-portfolio__image-loader"><span></span></div>
                </div>
            </a>
            <div class="lastudio-portfolio__icons">
                <a download data-rel="lightcase:myCollection:slideshow" href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" class="la-popup lastudio-portfolio__icon_gallery"><i class="lastudioicon-eye"></i></a>
                <a href="<?php echo esc_url($item_button_url); ?>" class="lastudio-portfolio__icon_link"><i class="lastudioicon-web-link"></i></a>
            </div>
        </div>
        <div class="lastudio-portfolio__content">
            <div class="lastudio-portfolio__content-inner">
                <div class="lastudio-portfolio__content-inner2"><?php
                    echo sprintf(
                        '<%1$s class="lastudio-portfolio__title"><a href="%2$s">%3$s</a></%1$s>',
                        esc_attr($title_tag),
                        esc_url($item_button_url),
                        esc_html(get_the_title())
                    );
                    if( $show_category && !empty($cat_list)){
                        echo sprintf('<p class="lastudio-portfolio__category">%s</p>', join(', ', $cat_list));
                    }

                    if( $show_excerpt && !empty($custom_excerpt_length)){
                        lastudio_elements_utility()->get_content( array(
                            'length'       => intval( $custom_excerpt_length ),
                            'content_type' => 'post_excerpt',
                            'html'         => '<p %1$s>%2$s</p>',
                            'class'        => 'lastudio-portfolio__desc',
                            'echo'         => true,
                        ), 'post', get_the_ID()  );
                    }
                    if( $show_readmore_btn ) {
                        echo sprintf(
                            '<a %1$s href="%2$s"><span class="lastudio-portfolio__button-text">%3$s</span></a>',
                            'class="lastudio-portfolio__button button"',
                            $item_button_url,
                            esc_html($read_more_label)
                        );
                    }
                    if( $show_divider ){
                        echo '<div class="lastudio-portfolio__divider"><span></span></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</article><?php
$loop_index2++;
$loop_index++;
raz_set_theme_loop_prop('loop_index', $loop_index);
raz_set_theme_loop_prop('loop_index2', $loop_index2);