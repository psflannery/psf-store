<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

defined( 'ABSPATH' ) || exit;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
	<section class="product-container">
		<div class="py-5">
			<div class="row">
				<div class="col-md-7 px-0 px-md-3 pb-5 mb-4">

					<?php
					/**
					 * Hook: woocommerce_before_single_product_summary.
					 *
					 * @hooked psf_store_product_image_wrapper_open - 9
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 * @hooked psf_store_product_image_wrapper_close - 21
					 */
					do_action( 'woocommerce_before_single_product_summary' );
					?>

				</div>
				<div class="col-md-4 pb-5 px-4 px-md-3 mb-4">
					<div class="summary entry-summary row">

						<?php
						/**
						 * Hook: woocommerce_single_product_summary.
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked psf_store_price_availabilty_wrapper_open - 9
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked psf_store_price_availabilty_wrapper_close - 11
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_rating - 25
						 * @hooked psf_store_product_hidden_inputs - 29
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_sharing - 35
						 * //@hooked woocommerce_template_single_meta - 40
						 * @hooked psf_store_tabs_wrapper_open - 39
						 * @hooked woocommerce_output_product_data_tabs - 40
						 * @hooked psf_store_tabs_wrapper_open - 41
						 * @hooked WC_Structured_Data::generate_product_data() - 60
						 */
						do_action( 'woocommerce_single_product_summary' );
						?>

					</div>
				</div>

				<?php
				/**
				 * Hook: psf_store_single_product_summary_footer
				 *
				 * @hooked psf_store_single_product_sidebar
				 */
				do_action( 'psf_store_single_product_summary_footer' );
				?>

			</div>
		</div>
	</section>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_upsell_display - 5
	 * @hooked woocommerce_output_related_products - 6
	 * @hooked psf_store_recently_viewed_product_widget_area - 8
	 * //@hooked woocommerce_output_product_data_tabs - 10
	 * @hooked comments_template - 50
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>