<?php

function lahb_icon_content( $atts, $uniqid, $once_run_flag ) {

	extract( LAHB_Helper::component_atts( array(
		'content'		=> '',
		'icon'			=> '',
		'extra_class'	=> '',
        'link'			=> '',
        'link_new_tab'	=> 'false',
	), $atts ));

	$out = '';

	$content = ! empty( $content ) ? '<span>' . LAHB_Helper::render_string($content) . '</span>' : '' ;
	$icon	 = ! empty( $icon ) ? '<i class="' . lahb_rename_icon($icon) . '" ></i>' : '' ;
    $link			= $link ? $link : '' ;
    $link_new_tab	= $link_new_tab == 'true' ? 'target="_blank"' : '' ;

	// styles
	if ( $once_run_flag ) :

		$dynamic_style = '';
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Text', '#lastudio-header-builder .icon_content_' . esc_attr( $uniqid ) .' span','#lastudio-header-builder .icon_content_' . esc_attr( $uniqid ) .':hover span' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'Icon', '#lastudio-header-builder .icon_content_' . esc_attr( $uniqid ) .' i','#lastudio-header-builder .icon_content_' . esc_attr( $uniqid ) .':hover i'  );
		$dynamic_style .= lahb_styling_tab_output( $atts, 'Background', '#lastudio-header-builder .icon_content_' . esc_attr( $uniqid ) .'' );
		$dynamic_style .= lahb_styling_tab_output( $atts, 'Box', '#lastudio-header-builder .icon_content_' . esc_attr( $uniqid ) .'' );

        if ( $dynamic_style ) :
            LAHB_Helper::set_dynamic_styles( $dynamic_style );
        endif;

	endif;

	// extra class
	$extra_class = $extra_class ? ' ' . $extra_class : '' ;


	// render
	$out .= '<div class="lahb-element lahb-icon-content' . esc_attr( $extra_class ) . ' icon_content_'.esc_attr( $uniqid ).'">';

    if ( ! empty ( $link ) ) {
        $out .= '<a href="' . esc_attr( $link ) . '" '. $link_new_tab .'>';
    }

    $out .= $icon . do_shortcode($content);

    if ( ! empty ( $link ) ) {
        $out .= '</a>';
    }

    $out .= '</div>';

	return $out;

}

LAHB_Helper::add_element( 'icon-content', 'lahb_icon_content' );
