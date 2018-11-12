<?php
/**
 * Template for displaying the product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 *
 * @package Store_test
 * 
 * @since store_test 1.0.0
 */

$classes = 'input-group';
$classes = apply_filters( 'psf_search_form_class', $classes );
?>

<form class="<?php echo $classes; ?>" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="sr-only" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'psf-store' ); ?></label>
	<input id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="form-control form-control-lg" type="search" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'psf-store' ); ?>" aria-label="<?php echo esc_attr_x( 'Search', 'label', 'psf-store' ); ?>" value="<?php echo get_search_query(); ?>" name="s">

	<?php if( $button ): ?>

	<div class="input-group-append">
		<button class="btn btn-light d-flex" type="submit">
			<span class="sr-only"><?php echo _x( 'Search', 'submit button', 'psf-store' ); ?></span>
			<?php echo psf_store_get_svg( array( 'icon' => 'search' ) ); ?>
		</button>
	</div>

	<?php endif; ?>

	<input type="hidden" name="post_type" value="product" />
</form>
