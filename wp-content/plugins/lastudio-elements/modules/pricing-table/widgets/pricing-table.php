<?php
namespace Lastudio_Elements\Modules\PricingTable\Widgets;

use Lastudio_Elements\Base\Lastudio_Widget;
use Lastudio_Elements\Controls\Group_Control_Box_Style;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Pricing_Table Widget
 */
class Pricing_Table extends Lastudio_Widget {

    public function get_name() {
        return 'lastudio-pricing-table';
    }

    protected function get_widget_title() {
        return esc_html__( 'Pricing Table', 'lastudio-elements' );
    }

    public function get_icon() {
        return 'lastudioelements-icon-4';
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_general',
            array(
                'label' => esc_html__( 'General', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'icon',
            array(
                'label'       => esc_html__( 'Icon', 'lastudio-elements' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'file'        => '',
                'default'     => 'fa fa-flag-o',
            )
        );

        $this->add_control(
            'title',
            array(
                'label'   => esc_html__( 'Title', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Title', 'lastudio-elements' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'subtitle',
            array(
                'label'   => esc_html__( 'Subtitle', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Subtitle', 'lastudio-elements' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'featured',
            array(
                'label'        => esc_html__( 'Is Featured?', 'lastudio-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-elements' ),
                'label_off'    => esc_html__( 'No', 'lastudio-elements' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->add_control(
            'featured_badge',
            array(
                'label'   => esc_html__( 'Featured Badge', 'lastudio-elements' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => lastudio_elements_tools()->get_badge_placeholder(),
                ),
                'condition' => array(
                    'featured' => 'yes',
                ),
            )
        );

        $this->add_control(
            'featured_position',
            array(
                'label'   => esc_html__( 'Featured Position', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'lastudio-elements' ),
                    'right' => esc_html__( 'Right', 'lastudio-elements' ),
                ),
                'condition' => array(
                    'featured' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'featured_left',
            array(
                'label'      => esc_html__( 'Left Indent', 'lastudio-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -200,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'featured_position' => 'left',
                    'featured' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__badge' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ),
            )
        );

        $this->add_responsive_control(
            'featured_right',
            array(
                'label'      => esc_html__( 'Right Indent', 'lastudio-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -200,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'featured_position' => 'right',
                    'featured' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__badge' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ),
            )
        );

        $this->add_responsive_control(
            'featured_top',
            array(
                'label'      => esc_html__( 'Top Indent', 'lastudio-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -200,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__badge' => 'top: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'featured' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_price',
            array(
                'label' => esc_html__( 'Price', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'price_prefix',
            array(
                'label'   => esc_html__( 'Price Prefix', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( '$', 'lastudio-elements' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'price',
            array(
                'label'   => esc_html__( 'Price Value', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( '100', 'lastudio-elements' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'price_suffix',
            array(
                'label'   => esc_html__( 'Price Suffix', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( '/per month', 'lastudio-elements' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'price_desc',
            array(
                'label' => esc_html__( 'Price Description', 'lastudio-elements' ),
                'type'  => Controls_Manager::TEXTAREA,
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features',
            array(
                'label' => esc_html__( 'Features', 'lastudio-elements' ),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            array(
                'label' => esc_html__( 'Text', 'lastudio-elements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Feature', 'lastudio-elements' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $repeater->add_control(
            'item_included',
            array(
                'label'   => esc_html__( 'Is Included?', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'item-included',
                'options' => array(
                    'item-included'=> esc_html__( 'Included', 'lastudio-elements' ),
                    'item-excluded' => esc_html__( 'Excluded', 'lastudio-elements' ),
                ),
            )
        );

        $this->add_control(
            'features_list',
            array(
                'type'    => Controls_Manager::REPEATER,
                'fields'  => array_values( $repeater->get_controls() ),
                'default' => array(
                    array(
                        'item_text'     => esc_html__( 'Feature #1', 'lastudio-elements' ),
                        'item_included' => 'item-included',
                    ),
                    array(
                        'item_text'     => esc_html__( 'Feature #2', 'lastudio-elements' ),
                        'item_included' => 'item-included',
                    ),
                    array(
                        'item_text'     => esc_html__( 'Feature #3', 'lastudio-elements' ),
                        'item_included' => 'item-excluded',
                    ),
                    array(
                        'item_text'     => esc_html__( 'Feature #4', 'lastudio-elements' ),
                        'item_included' => 'item-excluded',
                    ),
                ),
                'title_field' => '{{{ item_text }}}',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_action',
            array(
                'label' => esc_html__( 'Action Button', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'button_before',
            array(
                'label'   => esc_html__( 'Text Before Action Button', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label'   => esc_html__( 'Button Text', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Buy', 'lastudio-elements' ),
            )
        );

        $this->add_control(
            'button_url',
            array(
                'label'   => esc_html__( 'Button URL', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '#',
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
            'button_after',
            array(
                'label'   => esc_html__( 'Text After Action Button', 'lastudio-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $this->end_controls_section();

        $css_scheme = apply_filters(
            'lastudio-elements/pricing-table/css-scheme',
            array(
                'table'         => '.pricing-table',
                'header'        => '.pricing-table__heading',
                'icon_wrap'     => '.pricing-table__icon',
                'icon_box'      => '.pricing-table__icon-box',
                'icon'          => '.pricing-table__icon-box > *',
                'title'         => '.pricing-table__title',
                'subtitle'      => '.pricing-table__subtitle',
                'price'         => '.pricing-table__price',
                'price_prefix'  => '.pricing-table__price-prefix',
                'price_value'   => '.pricing-table__price-val',
                'price_suffix'  => '.pricing-table__price-suffix',
                'price_desc'    => '.pricing-table__price-desc',
                'features'      => '.pricing-table__features',
                'features_item' => '.pricing-feature',
                'included_item' => '.pricing-feature.item-included',
                'excluded_item' => '.pricing-feature.item-excluded',
                'action'        => '.pricing-table__action',
                'button'        => '.pricing-table__action .pricing-table-button',
                'button_icon'   => '.pricing-table__action .button-icon',
            )
        );

        $this->start_controls_section(
            'section_table_style',
            array(
                'label'      => esc_html__( 'Table', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'table_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'table_border',
                'label'          => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['table'],
                'fields_options' => array(
                    'border' => array(
                        'default' => 'solid',
                    ),
                    'width' => array(
                        'default' => array(
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => true,
                        ),
                    ),
                    'color' => array(
                        'scheme' => array(
                            'type'  => Scheme_Color::get_type(),
                            'value' => Scheme_Color::COLOR_3,
                        ),
                    ),
                ),
            )
        );

        $this->add_responsive_control(
            'table_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['table'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'table_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
            )
        );

        $this->add_responsive_control(
            'table_padding',
            array(
                'label'      => esc_html__( 'Table Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['table'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_header_style',
            array(
                'label'      => esc_html__( 'Header', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'header_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['header'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'header_title_style',
            array(
                'label'     => esc_html__( 'Title', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'  => esc_html__( 'Title Color', 'lastudio-elements' ),
                'type'   => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
            )
        );

        $this->add_control(
            'header_subtitle_style',
            array(
                'label'     => esc_html__( 'Subtitle', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'subtitle_color',
            array(
                'label'  => esc_html__( 'Subtitle Color', 'lastudio-elements' ),
                'type'   => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['subtitle'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'subtitle_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['subtitle'],
            )
        );

        $this->add_responsive_control(
            'header_padding',
            array(
                'label'      => esc_html__( 'Header Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['header'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'header_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['header'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'header_border',
                'label'          => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['header'],
            )
        );

        $this->add_responsive_control(
            'header_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['header'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            array(
                'label'      => esc_html__( 'Icon', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'icon_style',
                'label'          => esc_html__( 'Icon Style', 'lastudio-elements' ),
                'selector'       => '{{WRAPPER}} ' . $css_scheme['icon'],
                'fields_options' => array(
                    'box_font_color' => array(
                        'scheme' => array(
                            'type'  => Scheme_Color::get_type(),
                            'value' => Scheme_Color::COLOR_1,
                        ),
                    ),
                ),
            )
        );

        $this->add_responsive_control(
            'icon_wrap_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'icon_box_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_style',
            array(
                'label'      => esc_html__( 'Pricing', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'price_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'price_prefix_style',
            array(
                'label'     => esc_html__( 'Prefix', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'price_prefix_color',
            array(
                'label' => esc_html__( 'Price Prefix Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_prefix_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['price_prefix'],
            )
        );

        $this->add_control(
            'price_prefix_vertical_align',
            array(
                'label'   => esc_html__( 'Vertical Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => lastudio_elements_tools()->verrtical_align_attr(),
                'default' => 'baseline',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'vertical-align: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'price_prefix_dispaly',
            array(
                'label'   => esc_html__( 'Prefix Display', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'inline-block' => esc_html__( 'Inline', 'lastudio-elements' ),
                    'block'        => esc_html__( 'Block', 'lastudio-elements' ),
                ),
                'default' => 'inline-block',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'display: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'price_val_style',
            array(
                'label'     => esc_html__( 'Price Value', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'price_color',
            array(
                'label' => esc_html__( 'Price Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_value'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'price_typography',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}}  ' . $css_scheme['price_value'],
            )
        );

        $this->add_control(
            'price_suffix_style',
            array(
                'label'     => esc_html__( 'Suffix', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'price_suffix_color',
            array(
                'label' => esc_html__( 'Price Suffix Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_suffix_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['price_suffix'],
            )
        );

        $this->add_control(
            'price_suffix_vertical_align',
            array(
                'label'   => esc_html__( 'Vertical Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => lastudio_elements_tools()->verrtical_align_attr(),
                'default' => 'baseline',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'vertical-align: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'price_suffix_dispaly',
            array(
                'label'   => esc_html__( 'Suffix Display', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'inline-block' => esc_html__( 'Inline', 'lastudio-elements' ),
                    'block'        => esc_html__( 'Block', 'lastudio-elements' ),
                ),
                'default'   => 'inline-block',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'display: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'price_desc_style',
            array(
                'label'     => esc_html__( 'Description', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'price_desc_color',
            array(
                'label' => esc_html__( 'Price Description Color', 'lastudio-elements' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_desc'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_desc_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['price_desc'],
            )
        );

        $this->add_control(
            'price_desc_gap',
            array(
                'label' => esc_html__( 'Gap', 'lastudio-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 30,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_desc'] => 'margin-top: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'price_padding',
            array(
                'label'      => esc_html__( 'Pricing Block Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'price_border',
                'label'          => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['price'],
            )
        );

        $this->add_responsive_control(
            'price_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'price_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features_style',
            array(
                'label'      => esc_html__( 'Features', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'features_custom_width',
            array(
                'label'        => esc_html__( 'Custom width', 'lastudio-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-elements' ),
                'label_off'    => esc_html__( 'No', 'lastudio-elements' ),
                'return_value' => 'yes',
                'default'      => 'false',
            )
        );

        $this->add_responsive_control(
            'features_width',
            array(
                'label'      => esc_html__( 'Width', 'lastudio-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'size' => 350,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto',
                ),
                'condition' => array(
                    'features_custom_width' => 'yes',
                )
            )
        );

        $this->add_control(
            'features_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'features_padding',
            array(
                'label'      => esc_html__( 'Features Block Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'features_border',
                'label'          => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['features'],
            )
        );

        $this->add_responsive_control(
            'features_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'features_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'features_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['features_item'],
            )
        );

        $this->add_control(
            'heading_included_feature_style',
            array(
                'label'     => esc_html__( 'Included Feature', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'inc_features_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['included_item'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'included_bullet_icon',
            array(
                'label'       => esc_html__( 'Included Bullet Icon', 'lastudio-elements' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'file'        => '',
                'default'     => 'fa fa-check',
            )
        );

        $this->add_control(
            'inc_bullet_icon_size',
            array(
                'label'   => esc_html__( 'Icon Size', 'lastudio-elements' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 14,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 6,
                        'max' => 90,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'inc_bullet_color',
            array(
                'label' => esc_html__( 'Bullet Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet:before' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'heading_excluded_feature_style',
            array(
                'label'     => esc_html__( 'Excluded Feature', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'exc_features_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'excluded_bullet_icon',
            array(
                'label'       => esc_html__( 'Excluded Bullet Icon', 'lastudio-elements' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'file'        => '',
                'default'     => 'fa fa-times',
            )
        );

        $this->add_control(
            'exc_bullet_icon_size',
            array(
                'label'   => esc_html__( 'Icon Size', 'lastudio-elements' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 14,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 6,
                        'max' => 90,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'exc_bullet_color',
            array(
                'label' => esc_html__( 'Bullet Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet:before' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'exc_text_decoration',
            array(
                'label'   => esc_html__( 'Text Decoration', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'         => esc_html__( 'None', 'lastudio-elements' ),
                    'line-through' => esc_html__( 'Line Through', 'lastudio-elements' ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .pricing-feature__text' => 'text-decoration: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'features_divider_style',
            array(
                'label'     => esc_html__( 'Features Divider', 'lastudio-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'features_divider',
            array(
                'label'        => esc_html__( 'Divider', 'lastudio-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-elements' ),
                'label_off'    => esc_html__( 'No', 'lastudio-elements' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->add_control(
            'features_divider_line',
            array(
                'label' => esc_html__( 'Style', 'lastudio-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'solid' => esc_html__( 'Solid', 'lastudio-elements' ),
                    'double' => esc_html__( 'Double', 'lastudio-elements' ),
                    'dotted' => esc_html__( 'Dotted', 'lastudio-elements' ),
                    'dashed' => esc_html__( 'Dashed', 'lastudio-elements' ),
                ),
                'default' => 'solid',
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-style: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'features_divider_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ),
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'features_divider_weight',
            array(
                'label'   => esc_html__( 'Weight', 'lastudio-elements' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 1,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 10,
                    ),
                ),
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'features_divider_width',
            array(
                'label' => esc_html__( 'Width', 'lastudio-elements' ),
                'type' => Controls_Manager::SLIDER,
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'width: {{SIZE}}%',
                ),
            )
        );

        $this->add_control(
            'features_divider_gap',
            array(
                'label' => esc_html__( 'Gap', 'lastudio-elements' ),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 15,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_actions_style',
            array(
                'label'      => esc_html__( 'Action Box', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'action_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'action_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'action_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['action'],
            )
        );

        $this->add_responsive_control(
            'action_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'action_border',
                'label'          => esc_html__( 'Border', 'lastudio-elements' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['action'],
            )
        );

        $this->add_responsive_control(
            'action_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'action_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-elements' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_action_button_style',
            array(
                'label'      => esc_html__( 'Action Button', 'lastudio-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'button_size',
            array(
                'label'   => esc_html__( 'Size', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => array(
                    'auto' => esc_html__( 'auto', 'lastudio-elements' ),
                    'full'  => esc_html__( 'full', 'lastudio-elements' ),
                ),
            )
        );

        $this->add_control(
            'add_button_icon',
            array(
                'label'        => esc_html__( 'Add Icon', 'lastudio-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-elements' ),
                'label_off'    => esc_html__( 'No', 'lastudio-elements' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->add_control(
            'button_icon',
            array(
                'label'       => esc_html__( 'Icon', 'lastudio-elements' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'file'        => '',
                'default'     => 'fa fa-shopping-cart',
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
            )
        );

        $this->add_control(
            'button_icon_position',
            array(
                'label'   => esc_html__( 'Icon Position', 'lastudio-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'left'  => esc_html__( 'Before Text', 'lastudio-elements' ),
                    'right' => esc_html__( 'After Text', 'lastudio-elements' ),
                ),
                'default'     => 'left',
                'render_type' => 'template',
                'selectors'   => array(
                    '{{WRAPPER}} ' . $css_scheme['button_icon'] => 'float: {{VALUE}}',
                ),
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
            )
        );

        $this->add_control(
            'button_icon_size',
            array(
                'label' => esc_html__( 'Icon Size', 'lastudio-elements' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 7,
                        'max' => 90,
                    ),
                ),
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['button_icon'] . ':before' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'button_icon_color',
            array(
                'label'     => esc_html__( 'Icon Color', 'lastudio-elements' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['button_icon'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'button_icon_margin',
            array(
                'label'      => esc_html__( 'Icon Margin', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
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
                    '{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
            )
        );

        $this->add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
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
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
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
                    '{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_hover_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
            )
        );

        $this->add_responsive_control(
            'button_hover_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {

        $this->__context = 'render';

        $this->__open_wrap();
        include $this->__get_global_template( 'index' );
        $this->__close_wrap();
    }

    protected function _content_template() {}

    public function __pricing_feature_icon() {
        return call_user_func( array( $this, sprintf( '__pricing_feature_icon_%s', $this->__context ) ) );
    }

    public function __pricing_feature_icon_render() {

        $item = $this->__processed_item;

        switch ( $item['item_included'] ) {
            case 'item-excluded':
                $icon = $this->get_settings_for_display( 'excluded_bullet_icon' );
                break;

            default:
                $icon = $this->get_settings_for_display( 'included_bullet_icon' );
                break;
        }

        if ( $icon ) {
            return sprintf( '<i class="item-bullet %s"></i>', $icon );
        }

    }

    public function __pricing_feature_icon_edit() {
        ?>
        <# if ( 'item-excluded' === item.item_included ) { #>
        <# if ( settings.excluded_bullet_icon ) { #>
        <i class="item-bullet {{{ settings.excluded_bullet_icon }}}"></i>
        <# } #>
        <# } else { #>
        <# if ( settings.included_bullet_icon ) { #>
        <i class="item-bullet {{{ settings.included_bullet_icon }}}"></i>
        <# } #>
        <# } #>
        <?php
    }

}