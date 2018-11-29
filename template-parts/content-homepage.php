<?php
/**
 * Template part for displaying page content in template-homepage.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Store_test
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	psf_store_post_thumbnail();

	/**
	 * Functions hooked in to storefront_page add_action
	 *
	 * @hooked psf_store_homepage_header      - 10
	 * @hooked psf_store_page_content         - 20
	 */
	do_action( 'psf_store_homepage' );
	?>
		
</div>