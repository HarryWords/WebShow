<?php
/**
 * Loop item thumbnail
 */
if ( 'yes' !== $this->get_attr( 'show_image' ) || 'background' === $this->get_attr( 'show_image_as' ) ) {
    return;
}

$srcset = ' srcset="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="';

lastudio_elements_utility()->get_image( array(
    'size'        => $this->get_attr( 'thumb_size' ),
    'mobile_size' => $this->get_attr( 'thumb_size' ),
    'class'       => 'post-thumbnail__link',
    'html'        => '<div class="post-thumbnail"><a href="%1$s" %2$s><img class="post-thumbnail__img wp-post-image la-lazyload-image" src="%3$s" data-src="%3$s" alt="%4$s" %5$s '. $srcset .'></a></div>',
    'placeholder' => false,
    'echo'        => true,
), 'post', get_the_ID());