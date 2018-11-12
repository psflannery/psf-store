<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 *
 * @package Store_test
 * 
 * @since store_test 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ) {
	return;
}

?>
<ul class="woocommerce-error alert alert-danger list-unstyled" role="alert">
	<?php foreach ( $messages as $message ) : ?>
		<li>
			<?php 
				//echo wp_kses_post( $message );
				echo wc_kses_notice( $message ); 
			?>	
		</li>
	<?php endforeach; ?>
</ul>