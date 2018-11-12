<?php
/**
 * The sidebar containing the widget area on the single product page
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

if ( ! is_active_sidebar( 'single-product-1' ) ) {
	return;
}
?>

<aside id="sidebar-single-product" class="widget-area container">
	<div class="row">
		<div class="col">
			<div class="border-top pt-5">
				<div class="row">

					<?php dynamic_sidebar( 'single-product-1' ); ?>

				</div>
			</div>
		</div>
	</div>
</aside>