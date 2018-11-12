<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<ul class="woocommerce-checkout-review-order-table list-group mb-3">
	<?php
	// Items
	do_action( 'woocommerce_review_order_before_cart_contents' );
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>
			<li class="list-group-item d-flex justify-content-between lh-condensed <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>"><!-- filter -->
				<h6 class="product-name my-0">
					<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ); ?>
					<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <span class="product-quantity small text-muted">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
				</h6>
				<p class="product-total mb-0 small">
					<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
				</p>
			</li>
			<?php
		}
	}
	do_action( 'woocommerce_review_order_after_cart_contents' );
	?>

	<li class="cart-subtotal list-group-item d-flex justify-content-between">
		<span><?php _e( 'Subtotal', 'psf-store' ); ?></span>
		<span><?php wc_cart_totals_subtotal_html(); ?></span>
	</li>

	<?php 
	// Coupons
	foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<li class="list-group-item d-flex justify-content-between bg-light cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<span class="text-success"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
			<span class="text-success"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
		</li>
	<?php 
	endforeach; ?>

	<?php 
	// Shipping
	if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) :

		do_action( 'woocommerce_review_order_before_shipping' );
		wc_cart_totals_shipping_html();
		do_action( 'woocommerce_review_order_after_shipping' );
 
	endif; ?>

	<?php 
	// Fees
	foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<li class="fee list-group-item d-flex justify-content-between">
			<span><?php echo esc_html( $fee->name ); ?></span>
			<span><?php wc_cart_totals_fee_html( $fee ); ?></span>
		</li>
	<?php 
	endforeach; ?>

	<?php 
	// Tax
	if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) :
		if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) :
			foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
				<li class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
					<span><?php echo esc_html( $tax->label ); ?></span>
					<span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
				</li>
			<?php 
			endforeach;
		else : ?>
			<li class="tax-total list-group-item d-flex justify-content-between">
				<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
				<span><?php wc_cart_totals_taxes_total_html(); ?></span>
			</li>
		<?php
		endif;
	endif; ?>

	<?php 
	// Total
	do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<li class="order-total list-group-item d-flex justify-content-between">
		<span><?php _e( 'Total', 'psf-store' ); ?></span>
		<?php wc_cart_totals_order_total_html(); ?>
	</li>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</ul>