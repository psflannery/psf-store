<?php
/**
 * The sidebar containing the widget area on the single product page
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

if ( ! is_active_sidebar( 'single-product-2' ) && psf_store_get_recently_viewed_products_count() <= 4 ) {
	return;
}
?>

<section id="sidebar-recently-viewed-product" class="products products--carousel recently alignfull">
	<div class="border-top py-5">
		<div class="container">

			<?php dynamic_sidebar( 'single-product-2' ); ?>

		</div>
	</div>
</section>