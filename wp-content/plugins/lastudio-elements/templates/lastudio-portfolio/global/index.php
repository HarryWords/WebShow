<?php
/**
 * Portfolio template
 */

$settings = $this->get_settings_for_display();

$preset        = $settings['preset'];
$layout        = $settings['layout_type'];
$columns       = $settings['columns'];
$columnsLaptop = !empty($settings['columns_laptop']) ? $settings['columns_laptop'] : $columns;
$columnsTablet = !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : $columnsLaptop;
$columnsMobile = !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : $columnsTablet;

if( $layout == 'list' ) {
    $preset = $settings['preset_list'];
}

$this->add_render_attribute( 'main-container', 'id', 'pf_' . $this->get_id() );

$this->add_render_attribute( 'main-container', 'class', array(
	'lastudio-portfolio',
	'layout-type-' . $layout,
	'preset-' . $preset,
) );

$this->add_render_attribute( 'list-container', 'class', array(
    'lastudio-portfolio__list'
) );

$this->add_render_attribute( 'list-container', 'data-item_selector', array(
    '.loop__item'
) );

if ( 'masonry' == $layout || 'grid' == $layout ) {
	$this->add_render_attribute( 'main-container', 'class', 'playout-grid' );
}

if('masonry' == $layout){
    $this->add_render_attribute( 'list-container', 'class', array('js-el', 'la-isotope-container'));
    if(!empty($settings['enable_custom_masonry_layout'])){
        $this->add_render_attribute( 'list-container', 'data-la_component', 'AdvancedMasonry');
        $this->add_render_attribute( 'list-container', 'data-container-width', $settings['container_width']['size'] );
        $this->add_render_attribute( 'list-container', 'data-item-width', $settings['masonry_item_width']['size'] );
        $this->add_render_attribute( 'list-container', 'data-item-height', $settings['masonry_item_height']['size'] );

        $this->add_render_attribute( 'list-container', 'md-col', $columnsTablet);
        $this->add_render_attribute( 'list-container', 'sm-col', $columnsTablet);
        $this->add_render_attribute( 'list-container', 'xs-col', $columnsMobile);
        $this->add_render_attribute( 'list-container', 'mb-col', $columnsMobile);
    }
    else{
        $this->add_render_attribute( 'list-container', 'data-la_component', 'DefaultMasonry');
        $this->add_render_attribute( 'list-container', 'class', array(
            'grid-items',
            'xxl-block-grid-' . $columns,
            'xl-block-grid-' . $columnsLaptop,
            'md-block-grid-' . $columnsTablet,
            'block-grid-' . $columnsMobile
        ));
    }
}

if('grid' == $layout){
    $this->add_render_attribute( 'list-container', 'class', array(
        'grid-items',
        'xxl-block-grid-' . $columns,
        'xl-block-grid-' . $columnsLaptop,
        'md-block-grid-' . $columnsTablet,
        'block-grid-' . $columnsMobile
    ));
}

if( 'grid' != $layout ) {
    $this->add_render_attribute( 'main-container', 'data-settings', $this->generate_setting_json() );
}
if( 'grid' == $layout || 'list' == $layout ) {
    $slider_options = $this->generate_carousel_setting_json();
    if(!empty($slider_options)){
        $this->add_render_attribute( 'list-container', 'data-slider_config', $slider_options );
        $this->add_render_attribute( 'list-container', 'dir', is_rtl() ? 'rtl' : 'ltr' );
        $this->add_render_attribute( 'list-container', 'class', 'js-el la-slick-slider lastudio-carousel' );
        $this->add_render_attribute( 'list-container', 'data-la_component', 'AutoCarousel');
    }
}

$the_query = $this->the_query();

?>

<div <?php echo $this->get_render_attribute_string( 'main-container' ); ?>><?php

    if($layout == 'masonry') {
        $this->render_filters();
    }

    $image_list = (array) $this->get_settings_for_display('image_list');

    if($the_query->have_posts()){
        ?>
    <div class="lastudio-portfolio__list_wrapper">
        <div <?php echo $this->get_render_attribute_string( 'list-container' ); ?>>
        <?php

        while ($the_query->have_posts()){

            $the_query->the_post();

            $this->_load_template( $this->__get_global_template( 'portfolio-loop-item' ) );

            $this->item_counter++;
            $this->__processed_index++;

            if($this->__processed_index == count($image_list)){
                $this->__processed_index = 0;
            }
        }

        if($layout == 'masonry') {
            echo '<div class="la-isotope-loading"><span></span></div>';
        }
        ?>
        </div>
    </div>
    <?php

        if( $this->get_settings_for_display('paginate') == 'yes' ){

            if( $this->get_settings_for_display('loadmore_text') ) {
                $load_more_text = $this->get_settings_for_display('loadmore_text');
            }
            else{
                $load_more_text = esc_html__('Load More', 'lastudio-elements');
            }

            $nav_classes = array('portfolio-pagination', 'la-pagination', 'clearfix', 'la-ajax-pagination');

            if( $this->get_settings_for_display('paginate_as_loadmore') == 'yes') {
                $nav_classes[] = 'active-loadmore';
            }

            $paginated = ! $the_query->get( 'no_found_rows' );

            $p_total_pages = $paginated ? (int) $the_query->max_num_pages : 1;
            $p_current_page = $paginated ? (int) max( 1, $the_query->get( 'paged', 1 ) ) : 1;

            $paged_key = 'portfolio-page' . esc_attr($this->get_id());

            $p_base = esc_url_raw( add_query_arg( $paged_key, '%#%', false ) );
            $p_format = '?'.$paged_key.'=%#%';

            if( $p_total_pages == $p_current_page ) {
                $nav_classes[] = 'nothingtoshow';
            }

            ?>
            <nav class="<?php echo join(' ', $nav_classes) ?>" data-parent-container="#pf_<?php echo $this->get_id() ?>" data-container="#pf_<?php echo $this->get_id() ?> .lastudio-portfolio__list" data-item-selector=".loop__item" data-ajax_request_id="<?php echo $paged_key ?>">
                <div class="la-ajax-loading-outer"><div class="la-loader spinner3"><div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div><div class="cube1"></div><div class="cube2"></div><div class="cube3"></div><div class="cube4"></div></div></div>
                <div class="portfolio__loadmore_ajax pagination_ajax_loadmore">
                    <a href="javascript:;"><span><?php echo esc_html($load_more_text); ?></span></a>
                </div>
                <?php
                echo paginate_links( apply_filters( 'lastudio_elementor_ajax_pagination_args', array(
                    'base'         => $p_base,
                    'format'       => $p_format,
                    'add_args'     => false,
                    'current'      => max( 1, $p_current_page ),
                    'total'        => $p_total_pages,
                    'prev_text'    => '<i class="fa fa-arrow-left"></i>',
                    'next_text'    => '<i class="fa fa-arrow-right"></i>',
                    'type'         => 'list',
                    'end_size'     => 3,
                    'mid_size'     => 3
                ), 'portfolio' ) );
                ?>
            </nav>
            <?php
        }
    ?>

    <?php

        $this->item_counter = 0;
        $this->__processed_index = 0;

    }
    ?>
</div>
