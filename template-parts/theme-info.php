<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Peace
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<a href="<?php echo esc_url( __( 'https://www.customwptheme.co/mindful', 'peace' ) ); ?>"><?php printf( __( '%s', 'peace' ), 'Mindful' ); ?></a>
	<a href="<?php echo esc_url( __( 'https://www.customwptheme.co/', 'peace' ) ); ?>"><?php printf( __( 'theme by %s', 'peace' ), 'CustomWPTheme' ); ?></a> | 
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'peace' ) ); ?>"><?php printf( __( 'Powered by %s', 'peace' ), 'WordPress' ); ?></a>
</div><!-- .site-info -->