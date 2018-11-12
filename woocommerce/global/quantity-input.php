<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
//https://foundation.zurb.com/building-blocks/blocks/plus-minus-input.html

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	// translators: %s: Quantity.
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'woocommerce' ), strip_tags( $args['product_name'] ) ) : '';
	$classes = 'form-label mb-0 mr-auto';
	?>
	<div class="d-flex align-items-center justify-content-between">
		<label class="<?php echo apply_filters( 'psf_store_quantity_label', $classes ); ?>" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></label>
		<div class="quantity input-group input-group-sm plus-minus-input">
			<div class="input-group-prepend">
				<button class="btn btn-link border border-right-0" type="button" data-quantity="minus" data-field="<?php echo esc_attr( $input_id ); ?>"><?php echo psf_store_get_svg( array( 'icon' => 'remove' ) ); ?></button>
			</div>
			<input
				type="number"
				id="<?php echo esc_attr( $input_id ); ?>"
				class="input-text qty text form-control border-right-0 border-left-0"
				step="<?php echo esc_attr( $step ); ?>"
				min="<?php echo esc_attr( $min_value ); ?>"
				max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
				name="<?php echo esc_attr( $input_name ); ?>"
				value="<?php echo esc_attr( $input_value ); ?>"
				title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
				size="4"
				pattern="<?php echo esc_attr( $pattern ); ?>"
				inputmode="<?php echo esc_attr( $inputmode ); ?>"
				aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
			<div class="input-group-append">
				<button class="btn btn-link border border-left-0" type="button" data-quantity="plus" data-field="<?php echo esc_attr( $input_id ); ?>"><?php echo psf_store_get_svg( array( 'icon' => 'add' ) ); ?></button>
			</div>
		</div>
	</div>
	<?php
}