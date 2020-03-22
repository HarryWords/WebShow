<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$footer_copyright = Raz()->settings()->get('footer_copyright');
?>
<?php if(!empty($footer_copyright)): ?>
<footer id="colophon" class="site-footer site-footer-default">
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner"><?php echo wp_kses_post(Raz_Helper::remove_js_autop( $footer_copyright ));?></div>
        </div>
    </div>
</footer>
<?php endif; ?>