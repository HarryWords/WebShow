<?php
function lahb_menu_f( $atts, $uniqid, $once_run_flag ) {

    static $has_run_primary_menu = true;

	extract( LAHB_Helper::component_atts( array(
		'menu'						=> '',
		'desc_item'					=> 'false',
		'full_menu'					=> 'false',
		'height_100'				=> 'false',
		'extra_class'				=> '',
		'show_mobile_menu'			=> 'true',
		'mobile_menu_display_width' => '',
		'show_parent_arrow'			=> '',
		'parent_arrow_direction'	=> '',
		'show_megamenu'	            => 'false',
        'hamburger_icon'            => '',
        'screen_view_index'         => ''
	), $atts ));

	$out = $parent_arrow = '';

	$desc_item = $desc_item == 'true' ? ' has-desc-item' : '';
	$full_menu = $full_menu == 'true' ? ' full-width-menu' : '';
	$show_mobile_menu_class = $show_mobile_menu == 'false' ? ' la-hide-mobile-menu' : '';

	if(empty($hamburger_icon) || $hamburger_icon == 'none'){
        $hamburger_icon = 'fa fa-bars';
    }

    $hamburger_icon	 = ! empty( $hamburger_icon ) ? '<i class="' . lahb_rename_icon($hamburger_icon) . '" ></i>' : '' ;

	if( filter_var($show_megamenu, FILTER_VALIDATE_BOOLEAN) ) {
        $desc_item .= ' has-megamenu';
    }

	if ( filter_var($show_parent_arrow, FILTER_VALIDATE_BOOLEAN) ) {
		$parent_arrow = ' has-parent-arrow';

		switch ( $parent_arrow_direction ) {
			case 'top':
				$parent_arrow .= ' arrow-top';
				break;
			case 'right':
				$parent_arrow .= ' arrow-right';
				break;
			case 'bottom':
				$parent_arrow .= ' arrow-bottom';
				break;
			case 'left':
				$parent_arrow .= ' arrow-left';
				break;
		}
	}

    $menu_d_args = array(
        'container'		=> false,
        'depth'			=> '5',
        'items_wrap'	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'echo'			=> false
    );


    if ( $once_run_flag ) :

	    $has_nav = false;

	    if(is_nav_menu($menu)){
            $menu_d_args['menu'] = $menu;
            $has_nav = true;
        }
        else{
            if($has_run_primary_menu){
                $has_nav = true;
                $menu_d_args['theme_location'] = 'main-nav';
            }
        }

        if($has_nav){
            $menu_out = wp_nav_menu(array_merge($menu_d_args, array(
                'show_megamenu' => $show_megamenu,
                'fallback_cb'   => array( 'LAHB_Nav_Walker', 'fallback' ),
                'walker'		=> new LAHB_Nav_Walker()
            )));
            if ( $show_mobile_menu == 'true' ) {
                $responsive_menu_out = wp_nav_menu(array_merge($menu_d_args, array(
                    'menu_class'    => 'responav menu',
                    'fallback_cb'   => array( 'LAHB_Nav_Walker', 'fallback' ),
                    'walker'		=> new LAHB_Nav_Walker()
                )));
            }
        }
		else {
			$menu_out = '
				<div class="lahb-element">
					<span>' . esc_html__( 'Your menu is empty or not selected! ', 'lastudio-header-builder' ) . '<a href="https://codex.wordpress.org/Appearance_Menus_Screen" class="sf-with-ul hcolorf" target="_blank">' . esc_html__( 'How to config a menu', 'lastudio-header-builder' ) . '</a></span>
				</div>
			';

			$responsive_menu_out = $show_mobile_menu == 'true' ? $menu_out : '';
		}

		$dynamic_style = '';
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Menu Item', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' > ul > li > a,.lahb-responsive-menu-' . esc_attr( $uniqid ) . ' .responav li.menu-item > a:not(.button)','.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' > ul > li:hover > a,.lahb-responsive-menu-' . esc_attr( $uniqid ) . ' .responav li.menu-item:hover > a:not(.button)' );
		$dynamic_style .= lahb_styling_tab_output( $atts, 'Current Menu Item', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu > li.current > a, .lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu > li.menu-item > a.active, .lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu ul.sub-menu li.current > a,.lahb-responsive-menu-' . esc_attr( $uniqid ) . ' .responav li.current-menu-item > a:not(.button)' );
		$dynamic_style .= lahb_styling_tab_output( $atts, 'Current Item Shape', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu > li.current > a:after','.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu > li.current:hover > a:after' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Parent Menu Arrow', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . '.has-parent-arrow > ul > li.menu-item-has-children:before,.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . '.has-parent-arrow > ul > li.mega > a:before' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Menu Icon', '.lahb-wrap .lahb-responsive-menu-' . esc_attr( $uniqid ) . ' .responav > li > a > .la-menu-icon, .lahb-wrap .lahb-responsive-menu-' . esc_attr( $uniqid ) . ' .responav > li:hover > a > .la-menu-icon, .lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu > li > a .la-menu-icon', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu > li > a:hover .la-menu-icon' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Submenu Menu Icon', '.lahb-wrap .lahb-responsive-menu-' . esc_attr( $uniqid ) . ' .responav > li > ul.sub-menu a > .la-menu-icon, .lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu .sub-menu .la-menu-icon', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu .sub-menu li a:hover .la-menu-icon' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Menu Description', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .la-menu-desc' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Menu Badge', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu a span.menu-item-badge' );
		$dynamic_style .= lahb_styling_tab_output( $atts, 'Submenu Item', '.lahb-nav-wrap.nav__wrap_' . esc_attr( $uniqid ) . ' .menu ul li.menu-item a' );
		$dynamic_style .= lahb_styling_tab_output( $atts, 'Submenu Currnet Item', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu ul.sub-menu li.current > a' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Submenu Box', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu > li:not(.mega) ul' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Box', '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ',.nav__res_hm_icon_' . esc_attr( $uniqid ) );

        $dynamic_style .= lahb_styling_tab_output( $atts, 'Responsive Menu Box', '.lahb-responsive-menu-' . esc_attr( $uniqid ) );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Responsive Hamburger Icon', '.nav__res_hm_icon_' . esc_attr( $uniqid ) . ' a' );

        if ( $dynamic_style ) {
            LAHB_Helper::set_dynamic_styles( $dynamic_style );
        }

        if( filter_var($height_100, FILTER_VALIDATE_BOOLEAN) ) {
        	LAHB_Helper::set_dynamic_styles( '.lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ', .lahb-wrap .nav__wrap_' . esc_attr( $uniqid ) . ' .menu, .nav__wrap_'.esc_attr( $uniqid ).' .menu > li, .nav__wrap_'.esc_attr( $uniqid ).' .menu > li > a { height: 100%; }' );
        }

	endif;

	// extra class
	$extra_class = $extra_class ? ' ' . $extra_class : '' ;

	if($has_run_primary_menu){
        $nav_schema = ' itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"';
    }
    else{
        $nav_schema = '';
    }

	// render
	if ( $show_mobile_menu == 'true' ) {
		if ( $once_run_flag ) {
			// responsive menu
			$out .= '<div class="lahb-responsive-menu-wrap lahb-responsive-menu-' . esc_attr( $uniqid ) . '" data-uniqid="' . esc_attr( $uniqid ) . '"><div class="close-responsive-nav"><div class="lahb-menu-cross-icon"></div></div>'.$responsive_menu_out.'</div>';
			// normal menu
			$out .= '<nav class="lahb-element lahb-nav-wrap' . esc_attr( $extra_class ) .  $desc_item . $parent_arrow . $full_menu . $show_mobile_menu_class . ' nav__wrap_'.esc_attr( $uniqid ).'" data-uniqid="' . esc_attr( $uniqid ) . '"'.$nav_schema.'>' . $menu_out . '</nav>';
		}
		else {
			$out .= '<div class="lahb-element lahb-responsive-menu-icon-wrap nav__res_hm_icon_'.esc_attr( $uniqid ).'" data-uniqid="' . esc_attr( $uniqid ) . '"><a href="#">'.$hamburger_icon.'</a></div>';
		}
	}
	else {

        $menu_out = wp_nav_menu(array_merge($menu_d_args, array(
            'menu'			=> $menu,
            'show_megamenu' => $show_megamenu,
            'fallback_cb'   => array( 'LAHB_Nav_Walker', 'fallback' ),
            'walker'		=> new LAHB_Nav_Walker()
        )));

		// normal menu
		$out .= '<nav class="lahb-element lahb-nav-wrap' . esc_attr( $extra_class ) .  $desc_item . $parent_arrow . $full_menu . $show_mobile_menu_class . ' nav__wrap_'.esc_attr( $uniqid ).'" data-uniqid="' . esc_attr( $uniqid ) . '"'.$nav_schema.'>' . $menu_out . '</nav>';
	}

    $has_run_primary_menu = false;

	return $out;
}

LAHB_Helper::add_element( 'menu', 'lahb_menu_f' );