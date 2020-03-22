<?php

function lahb_icon_menu( $atts, $uniqid, $once_run_flag ) {

	extract( LAHB_Helper::component_atts( array(
		'menu'      	    => '',
		'show_tooltip'	    => 'false',
        'tooltip_text'	    => 'Search',
        'tooltip_position'	=> 'tooltip-on-bottom',
		'extra_class'	    => '',
		'main_icon' 	    => '',
	), $atts ));

	$out = '';

    if ( ! empty( $menu ) && is_nav_menu( $menu ) ) {

        $menu_out = wp_nav_menu( array(
            'menu'          => $menu,
            'container'     => false,
            'depth'         => '5',
            'fallback_cb'   => array( 'LAHB_Nav_Walker', 'fallback' ),
            'items_wrap'    => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'echo'          => false,
            'walker'		=> new LAHB_Nav_Walker()
        ));

    } else {

        $menu_out = '';

    }
    $main_icon = ! empty( $main_icon ) ? lahb_rename_icon($main_icon) : 'dl-icon-menu5' ;

    // tooltip
    $tooltip_text   = ! empty( $tooltip_text ) ? $tooltip_text : '' ;
    $tooltip = $tooltip_class = '';
    if ( $show_tooltip == 'true' && $tooltip_text ) :
        
        $tooltip_position   = ( isset( $tooltip_position ) && $tooltip_position ) ? $tooltip_position : 'tooltip-on-bottom';
        $tooltip_class      = ' lahb-tooltip ' . $tooltip_position;
        $tooltip            = ' data-tooltip=" ' . esc_attr( LAHB_Helper::render_string($tooltip_text) ) . ' "';

    endif;

	// styles
	if ( $once_run_flag ) :

		$dynamic_style = '';
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Icon', '#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) . ' .la-icon-menu-icon i','#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) . ':hover .la-icon-menu-icon i' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Box', '#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Dropdown Box', '#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) .' .lahb-icon-menu-content' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Menu Item', '#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) .' .lahb-icon-menu-content .menu li' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Menu Item Text', '#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) .' .lahb-icon-menu-content .menu > li > a','#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) . ':hover .lahb-icon-menu-content .menu > li:hover > a' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Menu Item Icon', '#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) .' .lahb-icon-menu-content .menu > li > a > i','#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) . ':hover .lahb-icon-menu-content .menu > li:hover > a > i' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Tooltip', '#lastudio-header-builder .icon_menu_' . esc_attr( $uniqid ) . '.lahb-tooltip[data-tooltip]:before' );

        if ( $dynamic_style ) :
            LAHB_Helper::set_dynamic_styles( $dynamic_style );
        endif;

	endif;

	// extra class
	$extra_class = $extra_class ? ' ' . $extra_class : '' ;

	// render
	$out .= '
		<div class="lahb-element lahb-header-dropdown lahb-icon-menu-wrap lahb-icon-menu ' . esc_attr( $tooltip_class . $extra_class ) . ' icon_menu_'.esc_attr( $uniqid ).'"'. $tooltip . '>
            <a href="#" class="lahb-trigger-element js-icon_menu_trigger"></a>
            <div class="la-icon-menu-icon lahb-icon-element hcolorf ">
                <i class="' . $main_icon . '"></i>
            </div>';
    $out .= '<div class="la-element-dropdown lahb-icon-menu-content">';
    $out .= $menu_out;
    $out .= '</div>';
	$out .= '</div>';
	return $out;

}

LAHB_Helper::add_element( 'icon-menu', 'lahb_icon_menu' );
