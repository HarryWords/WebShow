<?php
namespace Lastudio_Elements\Modules\Banner\Widgets;
use Lastudio_Elements\Base\Lastudio_Widget;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced_Map Widget
 */
class Banner extends Lastudio_Widget {
    public function get_name() {
        return 'lastudio-banner';
    }

    protected function get_widget_title() {
        return esc_html__( 'Banner', 'lastudio-elements' );
    }

    public function get_icon() {
        return 'lastudioelements-icon-10';
    }

    protected function _register_controls() {

        $hover_effect = apply_filters(
            'lastudio-elements/banner/hover_effect',
            array(
                'none'   => esc_html__( 'None', 'lastudio-elements' ),
                'lily'   => esc_html__( 'Lily', 'lastudio-elements' ),
                'sadie'  => esc_html__( 'Sadie', 'lastudio-elements' ),
                'layla'  => esc_html__( 'Layla', 'lastudio-elements' ),
                'oscar'  => esc_html__( 'Oscar', 'lastudio-elements' ),
                'marley' => esc_html__( 'Marley', 'lastudio-elements' ),
                'ruby'   => esc_html__( 'Ruby', 'lastudio-elements' ),
                'roxy'   => esc_html__( 'Roxy', 'lastudio-elements' ),
                'bubba'  => esc_html__( 'Bubba', 'lastudio-elements' ),
                'romeo'  => esc_html__( 'Romeo', 'lastudio-elements' ),
                'sarah'  => esc_html__( 'Sarah', 'lastudio-elements' ),
                'chico'  => esc_html__( 'Chico', 'lastudio-elements' )
            )
        );

        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Content', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'banner_image',
            array(
                'label'   => esc_html__( 'Image', 'lastudio-elements' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
                ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'banner_image_size',
            array(
                'type'       => 'select',
                'label'      => esc_html__( 'Image Size', 'lastudio-elements' ),
                'default'    => 'full',
                'options'    => lastudio_elements_tools()->get_image_sizes(),
            )
        );

        $this->add_control(
            'banner_title',
            array(
                'label'   => esc_html__( 'Title', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'banner_title_html_tag',
            array(
                'label'   => esc_html__( 'Title HTML Tag', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'h1'   => esc_html__( 'H1', 'lastudio-elements' ),
                    'h2'   => esc_html__( 'H2', 'lastudio-elements' ),
                    'h3'   => esc_html__( 'H3', 'lastudio-elements' ),
                    'h4'   => esc_html__( 'H4', 'lastudio-elements' ),
                    'h5'   => esc_html__( 'H5', 'lastudio-elements' ),
                    'h6'   => esc_html__( 'H6', 'lastudio-elements' ),
                    'div'  => esc_html__( 'div', 'lastudio-elements' ),
                    'span' => esc_html__( 'span', 'lastudio-elements' ),
                    'p'    => esc_html__( 'p', 'lastudio-elements' ),
                ),
                'default' => 'h5',
            )
        );

        $this->add_control(
            'banner_text',
            array(
                'label'   => esc_html__( 'Description', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXTAREA,
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'banner_button_text',
            array(
                'label'   => esc_html__( 'Item Button Text', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $this->add_control(
            'banner_link',
            array(
                'label'   => esc_html__( 'Link', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => array(
                    'active' => true,
                    'categories' => array(
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY,
                    ),
                ),
            )
        );

        $this->add_control(
            'banner_link_target',
            array(
                'label'        => esc_html__( 'Open link in new window', 'lastudio-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => '_blank',
                'condition'    => array(
                    'banner_link!' => '',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Settings', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'enable_custom_image_height',
            array(
                'label'        => esc_html__( 'Enable Custom Image Height', 'lastudio-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-elements' ),
                'label_off'    => esc_html__( 'No', 'lastudio-elements' ),
                'return_value' => 'true',
                'default'      => ''
            )
        );

        $this->add_responsive_control(
            'custom_image_height',
            array(
                'label' => esc_html__( 'Image Height', 'lastudio-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 1000,
                    ),
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'vh' => array(
                        'min' => 0,
                        'max' => 100,
                    )
                ),
                'size_units' => ['px', '%', 'vh'],
                'default' => [
                    'size' => 300,
                    'unit' => 'px'
                ],
                'selectors' => array(
                    '{{WRAPPER}} .lastudio-banner' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lastudio-banner img' => 'position: absolute; width: 100%; height: 100%; left: 0; top: 0; object-fit: cover'
                ),
                'render_type' => 'template',
                'condition' => [
                    'enable_custom_image_height!' => ''
                ]
            )
        );

        $this->add_control(
            'animation_effect',
            array(
                'label'   => esc_html__( 'Animation Effect', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'lily',
                'options' => $hover_effect
            )
        );

        $this->end_controls_section();

        $css_scheme = apply_filters(
            'lastudio-elements/banner/css-scheme',
            array(
                'banner'         => '.lastudio-banner',
                'banner_content' => '.lastudio-banner__content',
                'banner_overlay' => '.lastudio-banner__overlay',
                'banner_title'   => '.lastudio-banner__title',
                'banner_text'    => '.lastudio-banner__text',
                'banner_button'  => '.lastudio-banner__button',
            )
        );

        $this->start_controls_section(
            'section_banner_item_style',
            array(
                'label'      => esc_html__( 'General', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->start_controls_tabs( 'tabs_background' );

        $this->start_controls_tab(
            'tab_background_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'items_content_color',
            array(
                'label'     => esc_html__( 'Additional Elements Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lastudio-effect-layla ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-layla ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-oscar ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-marley ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-ruby ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-roxy ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-roxy ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-bubba ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-bubba ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-romeo ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-romeo ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-sarah ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-chico ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner_overlay'],
            )
        );

        $this->add_control(
            'normal_opacity',
            array(
                'label'   => esc_html__( 'Opacity', 'lastudio-elements' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0',
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_background_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'items_content_hover_color',
            array(
                'label'     => esc_html__( 'Additional Elements Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lastudio-effect-layla:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-layla:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-oscar:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-marley:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-ruby:hover ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-roxy:hover ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-roxy:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-bubba:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-bubba:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-romeo:hover ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-romeo:hover ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-sarah:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lastudio-effect-chico:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'background_hover',
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'],
            )
        );

        $this->add_control(
            'hover_opacity',
            array(
                'label'   => esc_html__( 'Opacity', 'lastudio-elements' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0.4',
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'banner_padding',
            array(
                'label'      => __( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator'  => 'before',
            )
        );

        $this->add_responsive_control(
            'banner_margin',
            array(
                'label'      => __( 'Margin', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'banner_border',
                'label'       => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['banner'],
            )
        );

        $this->add_control(
            'banner_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'banner_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner'],
            )
        );

        $this->add_control(
            'banner_content_horizontal_alignment',
            array(
                'label'   => esc_html__( 'Horizontal Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-arrow-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-arrow-right',
                    )
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '. $css_scheme['banner_content'] => 'justify-content: {{VALUE}};',
                ),
                'condition' => array(
                    'animation_effect' => 'none'
                ),
            )
        );

        $this->add_control(
            'banner_content_vertical_alignment',
            array(
                'label'   => esc_html__( 'Vertical Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Start', 'lastudio-elements' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'End', 'lastudio-elements' ),
                        'icon'  => 'eicon-v-align-bottom',
                    )
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '. $css_scheme['banner_content'] => 'align-items: {{VALUE}};',
                ),
                'condition' => array(
                    'animation_effect' => 'none'
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_banner_title_style',
            array(
                'label'      => esc_html__( 'Title Typography', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'banner_title_color',
            array(
                'label'     => esc_html__( 'Title Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'banner_title_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner_title'],
            )
        );

        $this->add_responsive_control(
            'banner_title_margin',
            array(
                'label'      => esc_html__( 'Margin', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'banner_title_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                )
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'banner_title_border',
                'label'       => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['banner_title'],
            )
        );

        $this->add_control(
            'banner_title_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'background: {{VALUE}}',
                )
            )
        );

        $this->add_responsive_control(
            'title_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-arrow-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-arrow-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_banner_text_style',
            array(
                'label'      => esc_html__( 'Description Typography', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'banner_text_color',
            array(
                'label'     => esc_html__( 'Description Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'banner_text_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner_text'],
            )
        );

        $this->add_responsive_control(
            'text_margin',
            array(
                'label'      => esc_html__( 'Margin', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'text_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-arrow-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-arrow-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();


        /**
         * Submit Button Style Section
         */
        $this->start_controls_section(
            'section_submit_button_style',
            array(
                'label'      => esc_html__( 'Banner Button', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );


        $this->add_responsive_control(
            'button_width',
            array(
                'label'      => esc_html__( 'Width', 'lastudio-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_button'] => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'button_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ),
                ),
                'condition' => array(
                    'layout' => 'block',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_button']  => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-elements' ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'button_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner_button'],
                'fields_options' => array(
                    'background' => array(
                        'default' => 'classic',
                    ),
                    'color' => array(
                        'label'  => _x( 'Background Color', 'Background Control', 'lastudio-elements' ),
                        'scheme' => array(
                            'type'  => Scheme_Color::get_type(),
                            'value' => Scheme_Color::COLOR_1,
                        ),
                    ),
                    'color_b' => array(
                        'label' => _x( 'Second Background Color', 'Background Control', 'lastudio-elements' ),
                    ),
                ),
                'exclude' => array(
                    'image',
                    'position',
                    'attachment',
                    'attachment_alert',
                    'repeat',
                    'size',
                ),
            )
        );

        $this->add_control(
            'button_color',
            array(
                'label'     => esc_html__( 'Text Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_button'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['banner_button'],
            )
        );

        $this->add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'button_margin',
            array(
                'label'      => __( 'Margin', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_border',
                'label'       => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['banner_button'],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner_button'],
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-elements' ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'button_hover_bg',
                'selector' => '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button'],
                'fields_options' => array(
                    'background' => array(
                        'default' => 'classic',
                    ),
                    'color' => array(
                        'label' => _x( 'Background Color', 'Background Control', 'lastudio-elements' ),
                    ),
                    'color_b' => array(
                        'label' => _x( 'Second Background Color', 'Background Control', 'lastudio-elements' ),
                    ),
                ),
                'exclude' => array(
                    'image',
                    'position',
                    'attachment',
                    'attachment_alert',
                    'repeat',
                    'size',
                ),
            )
        );

        $this->add_control(
            'button_hover_color',
            array(
                'label'     => esc_html__( 'Text Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_hover_typography',
                'selector' => '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button'],
            )
        );

        $this->add_responsive_control(
            'button_hover_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'button_hover_margin',
            array(
                'label'      => __( 'Margin', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'button_hover_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_hover_border',
                'label'       => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button']
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_button']
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Order Style Section
         */
        $this->start_controls_section(
            'section_order_style',
            array(
                'label'      => esc_html__( 'Content Order', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'banner_title_order',
            array(
                'label'   => esc_html__( 'Title Order', 'lastudio-elements' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 2,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['banner_title'] => 'order: {{VALUE}};',
                ),
            )
        );


        $this->add_control(
            'banner_text_order',
            array(
                'label'   => esc_html__( 'Description Order', 'lastudio-elements' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 2,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['banner_text'] => 'order: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

    }

    protected function render() {

        $this->__context = 'render';

        $this->__open_wrap();
        include $this->__get_global_template( 'index' );
        $this->__close_wrap();
    }

    public function __get_banner_image() {

        $image = $this->get_settings_for_display( 'banner_image' );

        if ( empty( $image['id'] ) && empty( $image['url'] ) ) {
            return;
        }

        $format = apply_filters( 'lastudio-elements/banner/image-format', '<img src="%s" alt="" class="lastudio-banner__img">' );

        if ( empty( $image['id'] ) ) {
            return sprintf( $format, $image['url'] );
        }

        $size = $this->get_settings_for_display( 'banner_image_size' );

        if ( ! $size ) {
            $size = 'full';
        }

        return wp_get_attachment_image($image['id'], $size, false, array('class' => 'lastudio-banner__img'));
    }

    public function __get_banner_image_src() {

        $image = $this->get_settings_for_display( 'banner_image' );

        if ( empty( $image['id'] ) && empty( $image['url'] ) ) {
            return;
        }

        if ( empty( $image['id'] ) ) {
            return $image['url'];
        }

        $size = $this->get_settings_for_display( 'banner_image_size' );

        if ( ! $size ) {
            $size = 'full';
        }

        $image_url = wp_get_attachment_image_url( $image['id'], $size );

        return $image_url;
    }
}