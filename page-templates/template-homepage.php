<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. 
 *
 * Template name: Homepage
 *
 * @package Store_test
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked psf_store_homepage_content      - 10
			 * @hooked psf_store_product_categories    - 20
			 * @hooked psf_store_recent_products       - 30
			 * @hooked psf_store_featured_products     - 40
			 * //@hooked storefront_popular_products      - 50
			 * @hooked psf_store_on_sale_products      - 60
			 * //@hooked storefront_best_selling_products - 70
			 */
			do_action( 'homepage' );
			?>

		</main>
	</div>
<?php
get_footer();