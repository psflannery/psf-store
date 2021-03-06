<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Store_test
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_woocommerce_setup() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 200,
		'single_image_width'    => 800,
    ) );
}
add_action( 'after_setup_theme', 'psf_store_woocommerce_setup' );

/**
 * Define explicit height for Woocommerce single product images.
 * 
 * @param  array $size Array of dimensions.
 * @return array       Array of dimensions.
 *
 * @since store_test 1.0.2
 */
function psf_store_woocommerce_image_size_single( $size ) {
	$size = array(
		'width'  => 800,
		'height' => 800,
		'crop'   => 0,
	);

	return $size;
}
add_filter( 'woocommerce_get_image_size_single', 'psf_store_woocommerce_image_size_single' );

/**
 * Define explicit height for Woocommerce thumbnail images.
 * 
 * @param  array $size Array of dimensions.
 * @return array       Array of dimensions.
 *
 * @since store_test 1.0.2
 *
function psf_store_woocommerce_image_size_thumbnail( $size ) {
	$size = array(
		'width'  => 200,
		'height' => 200,
		'crop'   => 0,
	);

	return $size;
}
add_filter( 'woocommerce_get_image_size_thumbnail', 'psf_store_woocommerce_image_size_thumbnail' );
*/

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_woocommerce_scripts() {
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'psf-store-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'psf_store_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 *
 * @since store_test 1.0.0
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 *
 * @since store_test 1.0.0
 */
function psf_store_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'psf_store_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function psf_store_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'psf_store_woocommerce_products_per_page' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 *
 * @since store_test 1.0.0
 */
function psf_store_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 12,
		'columns'        => 6,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'psf_store_woocommerce_related_products_args' );

/**
 * Checks if the current page is a product archive
 * 
 * @return boolean
 *
 * @since store_test 1.0.0
 */
function psf_store_is_product_archive() {
	if ( psf_store_is_woocommerce_activated() ) {
		if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
