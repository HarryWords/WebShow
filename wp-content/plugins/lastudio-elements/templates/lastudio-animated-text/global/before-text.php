<?php
/**
 * Animated before text template
 */
$settings = $this->get_settings_for_display();
?>
<div class="lastudio-animated-text__before-text">
	<?php
		echo $this->str_to_spanned_html( $settings['before_text_content'], 'word' ) . '&nbsp;';
	?>
</div>
