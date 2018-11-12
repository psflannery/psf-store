<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author 	WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
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

<?php foreach ( $messages as $message ) : ?>
	<div class="woocommerce-message alert alert-success alert-dismissible fade show" role="alert">
		
		<?php 
			echo wc_kses_notice( $message );
		?>

		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			<?php //echo psf_store_get_svg( array( 'icon' => 'close' ) ) ;?>
		</button>
	</div>
<?php endforeach; ?>