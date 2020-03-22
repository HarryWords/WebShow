<?php
/**
 * Images list item template
 */
$settings   = $this->get_settings_for_display();

$read_more_label  = $this->get_settings_for_display('read_more_label');
$custom_excerpt_length  = $this->get_settings_for_display('custom_excerpt_length');
if(empty($read_more_label)){
    $read_more_label = __('Read More', 'lastudio-elements');
}

$preset     = $settings['preset'];


$item_instance = 'item-instance-' . $this->item_counter;

$this->add_render_attribute( $item_instance, 'class', get_post_class( array(
    'loop__item',
    'grid-item',
    'lastudio-portfolio__item',
    'visible-status'
), get_the_ID() ) );

if ( 'masonry' == $settings['layout_type'] ) {
    $item_sizes = $this->get_masonry_item_sizes($this->__processed_index);
    $this->add_render_attribute( $item_instance, 'data-width', $item_sizes['item_width'] );
    $this->add_render_attribute( $item_instance, 'data-height', $item_sizes['item_height'] );
}

$term_obj = get_the_terms(get_the_ID(), 'la_portfolio_category');
$slug_list = array('all');
$cat_list = array();
if(!is_wp_error($term_obj) && !empty($term_obj)){
    foreach ($term_obj as $term){
        $slug_list[] = $term->slug;
    }
    $cat_list = wp_list_pluck($term_obj, 'name');
}


$link_instance = 'link-instance-' . $this->item_counter;

$link_css_class = array('lastudio-images-layout__link');

if ( 'list' != $settings['layout_type'] && $preset == 'type-1') {
    $link_css_class[] =  'img-perspective';
}

if ( 'list' == $settings['layout_type'] && $settings['preset_list'] == 'list-type-5') {
    $link_css_class[] =  'img-perspective';
}

$this->add_render_attribute( $link_instance, 'class', $link_css_class);

$item_image_url = get_the_post_thumbnail_url(get_the_ID(), $settings['image_size']);

$item_button_url = get_the_permalink();

$this->add_render_attribute( $link_instance, 'href', $item_button_url );

?>
<article <?php echo $this->get_render_attribute_string( $item_instance ); ?>>
    <div class="lastudio-portfolio__inner">
        <div class="lastudio-portfolio__image_wrap">
            <a <?php echo $this->get_render_attribute_string( $link_instance ); ?>>
                <div class="lastudio-portfolio__image" style="background-image: url('<?php echo esc_url($item_image_url); ?>')">
                    <?php the_post_thumbnail($settings['image_size'], array('class' => 'lastudio-portfolio__image-instance'));?>
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
                    $title_tag = $this->__get_html( 'title_html_tag', '%s' );
                    echo sprintf(
                        '<%1$s class="lastudio-portfolio__title"><a href="%2$s">%3$s</a></%1$s>',
                        esc_attr($title_tag),
                        esc_url($item_button_url),
                        esc_html(get_the_title())
                    );
                    if( $this->get_settings_for_display('show_category') && !empty($cat_list)){
                        echo sprintf('<p class="lastudio-portfolio__category">%s</p>', join(', ', $cat_list));
                    }

                    if( $this->get_settings_for_display('show_excerpt') && !empty($custom_excerpt_length)){
                        lastudio_elements_utility()->get_content( array(
                            'length'       => intval( $custom_excerpt_length ),
                            'content_type' => 'post_excerpt',
                            'html'         => '<p %1$s>%2$s</p>',
                            'class'        => 'lastudio-portfolio__desc',
                            'echo'         => true,
                        ), 'post', get_the_ID()  );
                    }
                    if( $this->get_settings_for_display('show_readmore_btn') ) {
                        echo sprintf(
                            '<a %1$s href="%2$s"><span class="lastudio-portfolio__button-text">%3$s</span></a>',
                            'class="lastudio-portfolio__button button"',
                            $item_button_url,
                            esc_html($read_more_label)
                        );
                    }
                    if( $this->get_settings_for_display('show_divider') ){
                        echo '<div class="lastudio-portfolio__divider"><span></span></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</article>