body {
font-family: <?php echo raz_render_variable( $body_font_family ) ?>;
}

h1,
.h1, h2,
.h2, h3,
.h3, h4,
.h4, h5,
.h5, h6,
.h6 {
font-family: <?php echo raz_render_variable( $heading_font_family ) ?>;
}
form.track_order .button:hover{
background-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?>;
}

.background-color-secondary, .la-pagination ul .page-numbers.current, .la-pagination ul .page-numbers:hover, .slick-slider .slick-dots button, .wc-toolbar .wc-ordering ul li:hover a,
.wc-toolbar .wc-ordering ul li.active a, .widget_layered_nav.widget_layered_nav--borderstyle li:hover a, .widget_layered_nav.widget_layered_nav--borderstyle li.active a, .elementor-button:hover, .product--summary .single_add_to_cart_button {
background-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?>;
}

.background-color-secondary {
background-color: <?php echo esc_attr( Raz()->settings()->get("three_color","#b5b7c4") ) ?>;
}

.background-color-body {
background-color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?>;
}

.background-color-border {
background-color: <?php echo esc_attr( Raz()->settings()->get("border_color","rgba(150,150,150,0.30)") ) ?>;
}

.la-woo-thumbs .la-thumb.slick-current.slick-active {
background-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?>;
}

a:hover
{
color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?>;
}

.text-color-primary {
color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?> !important;
}

.slick-arrow.circle-border:hover, .swatch-wrapper:hover, .swatch-wrapper.selected,.lahfb-nav-wrap.preset-vertical-menu-02 li.mm-lv-0:hover > a:before, .lahfb-nav-wrap.preset-vertical-menu-02 li.mm-lv-0.current > a:before {
border-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?>;
}

.border-color-primary {
border-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?> !important;
}

.border-top-color-primary {
border-top-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?> !important;
}

.border-bottom-color-primary {
border-bottom-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?> !important;
}

.border-left-color-primary {
border-left-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?> !important;
}

.border-right-color-primary {
border-right-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?> !important;
}

.woocommerce-message, .woocommerce-error {
color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?>;
}

.text-color-secondary {
color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

input:focus, select:focus, textarea:focus {
border-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?>;
}

.border-color-secondary {
border-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-top-color-secondary {
border-top-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-bottom-color-secondary {
border-bottom-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-left-color-secondary {
border-left-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-right-color-secondary {
border-right-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

h1,
.h1, h2,
.h2, h3,
.h3, h4,
.h4, h5,
.h5, h6,
.h6, table th, .slick-arrow.circle-border i {
color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?>;
}

.text-color-heading {
color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-color-heading {
border-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-top-color-heading {
border-top-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-bottom-color-heading {
border-bottom-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-left-color-heading {
border-left-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.border-right-color-heading {
border-right-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?> !important;
}

.text-color-three {
color: <?php echo esc_attr( Raz()->settings()->get("three_color","#b5b7c4") ) ?> !important;
}

.border-color-three {
border-color: <?php echo esc_attr( Raz()->settings()->get("three_color","#b5b7c4") ) ?> !important;
}

.border-top-color-three {
border-top-color: <?php echo esc_attr( Raz()->settings()->get("three_color","#b5b7c4") ) ?> !important;
}

.border-bottom-color-three {
border-bottom-color: <?php echo esc_attr( Raz()->settings()->get("three_color","#b5b7c4") ) ?> !important;
}

.border-left-color-three {
border-left-color: <?php echo esc_attr( Raz()->settings()->get("three_color","#b5b7c4") ) ?> !important;
}

.border-right-color-three {
border-right-color: <?php echo esc_attr( Raz()->settings()->get("three_color","#b5b7c4") ) ?> !important;
}

body, table.woocommerce-checkout-review-order-table .variation,
table.woocommerce-checkout-review-order-table .product-quantity {
color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?>;
}

.text-color-body {
color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?> !important;
}

.border-color-body {
border-color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?> !important;
}

.border-top-color-body {
border-top-color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?> !important;
}

.border-bottom-color-body {
border-bottom-color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?> !important;
}

.border-left-color-body {
border-left-color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?> !important;
}

.border-right-color-body {
border-right-color: <?php echo esc_attr( Raz()->settings()->get("text_color","#9d9d9d") ) ?> !important;
}

input, select, textarea, table,
table th,
table td, .share-links a, .select2-container .select2-selection--single, .swatch-wrapper, .widget_shopping_cart_content .total, .calendar_wrap caption, .shop_table.woocommerce-cart-form__contents td {
border-color: <?php echo esc_attr( Raz()->settings()->get("border_color","rgba(150,150,150,0.30)") ) ?>;
}

.border-color {
border-color: <?php echo esc_attr( Raz()->settings()->get("border_color","rgba(150,150,150,0.30)") ) ?> !important;
}

.border-top-color {
border-top-color: <?php echo esc_attr( Raz()->settings()->get("border_color","rgba(150,150,150,0.30)") ) ?> !important;
}

.border-bottom-color {
border-bottom-color: <?php echo esc_attr( Raz()->settings()->get("border_color","rgba(150,150,150,0.30)") ) ?> !important;
}

.border-left-color {
border-left-color: <?php echo esc_attr( Raz()->settings()->get("border_color","rgba(150,150,150,0.30)") ) ?> !important;
}

.border-right-color {
border-right-color: <?php echo esc_attr( Raz()->settings()->get("border_color","rgba(150,150,150,0.30)") ) ?> !important;
}

.backtotop-container .btn-backtotop{
background-color: <?php echo esc_attr( Raz()->settings()->get("secondary_color","#343538") ) ?>;
color: #fff;
}
.backtotop-container .btn-backtotop:hover{
background-color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?>;
}
.header-v-default .lahb-wrap .lahb-nav-wrap .menu > li.current > a{
color: <?php echo esc_attr( Raz()->settings()->get("primary_color","#35d56a") ) ?>;
}