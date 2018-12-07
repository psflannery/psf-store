<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Store_test
 */

/**
 * Jetpack setup function.
 *
 * @see https://jetpack.com/support/infinite-scroll/
 * @see https://jetpack.com/support/responsive-videos/
 *
 * @since store_test 1.0.0
 */
function psf_store_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'render'         => 'psf_store_infinite_scroll_render',
		'footer'         => false,
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'psf_store_jetpack_setup' );


// Infinite Scroll
// ------------------------------------------------------------
/**
 * Custom render function for Infinite Scroll.
 *
 * @since store_test 1.0.0
 */
function psf_store_infinite_scroll_render() {
	do_action( 'psf_store_jetpack_infinite_scroll_before' );
	
	if ( psf_store_is_product_archive() ) {
		do_action( 'psf_store_jetpack_product_infinite_scroll_before' );
		woocommerce_product_loop_start();
	}

	while ( have_posts() ) :
		the_post();
		if ( psf_store_is_product_archive() ) {
			wc_get_template_part( 'content', 'product' );
		} elseif ( is_search() ) {
			get_template_part( 'template-parts/content', 'search' );
		} else {
			get_template_part( 'template-parts/content', get_post_type() );
		}
	endwhile;

	if ( psf_store_is_product_archive() ) {
		woocommerce_product_loop_end();
		do_action( 'psf_store_jetpack_product_infinite_scroll_after' );
	}

	do_action( 'psf_store_jetpack_infinite_scroll_after' );
}

/**
 * Adds container to content appended by Jetpack infinite scroll
 *
 * @return void
 *
 * @since store_test 1.0.4
 */
function jetpack_infinite_scroll_product_container() {
	add_action( 'psf_store_jetpack_product_infinite_scroll_before', 'psf_store_archive_product_container_open' );
	add_action( 'psf_store_jetpack_product_infinite_scroll_after', 'psf_store_archive_product_container_close' );
}
if ( psf_store_is_woocommerce_activated() ) {
	add_action( 'init', 'jetpack_infinite_scroll_product_container' );
}


// Lazy Load
// ------------------------------------------------------------
/**
 * Exclude Image From Jetpack Lazyload
 * 
 * @param  array $blacklisted_classes  Array of strings where each string is a class
 * @return array                       Classes to exclude from Jetpack Lazyload
 *
 * @since store_test 1.0.0
 */
function psf_store_skip_lazy_load( $blacklisted_classes ) {
	$blacklisted_classes[] = 'custom-logo';

	return $blacklisted_classes;
}
add_filter( 'jetpack_lazy_images_blacklisted_classes', 'psf_store_skip_lazy_load' );


// Contact form.
// ------------------------------------------------------------
/**
 * Add classes to Jetpack contact form
 * 
 * @param  string $field_html contact form markup
 * @return string         Customised HTML markup
 *
 * @since store_test 1.0.0
 */
function psf_store_custom_contact_markup( $field_html ) {
    
    $field_html = str_replace( 'grunion-field-wrap', 'grunion-field-wrap form-group', $field_html );
    
    return $field_html;
}
add_filter( 'grunion_contact_form_field_html', 'psf_store_custom_contact_markup' );

/**
 * Add classes to label > span in Jetpack contact form
 * 
 * @param  string $field_html contact form markup
 * @return string             Customised HTML markup
 *
 * @since store_test 1.0.0
 */
function psf_store_custom_contact_label_markup( $field_html, $field_label ) {
    
    $field_html = str_replace( '<span>', '<span class="small required align-text-super" title="required"> ', $field_html );
    
    return $field_html;
}
add_filter( 'grunion_contact_form_field_html', 'psf_store_custom_contact_label_markup', 10, 2 );

/**
 * Filter the Contact Form required field text. 
 * 
 * @return string Filtered required field text.
 *
 * @since store_test 1.0.0
 */
function psf_store_jetpack_required_field_text() {
	return esc_html__('&#42;', 'psf-store');
}
add_filter( 'jetpack_required_field_text', 'psf_store_jetpack_required_field_text' );

/**
 * Filter the contact form success message.
 * 
 * @param  string $msg Success message.
 * @return string      Filtered success message.
 *
 * @since store_test 1.0.0
 */
function psf_store_jetpack_contact_success_message( $msg ) {
	global $contact_form_message;

	return '<h3>' . esc_html__( 'Message received, thank you!', 'psf-store' ) . '</h3>' . 
	wp_kses( 
		$contact_form_message, 
		array( 
			'br'         => array(), 
			'blockquote' => array() 
		) 
	);
}
add_filter( 'grunion_contact_form_success_message', 'psf_store_jetpack_contact_success_message' );


// Sharing
// ------------------------------------------------------------
/**
 * Filters the content markup of the Jetpack sharing links
 *
 * @param string $sharing_content Content markup of the Jetpack sharing links
 * @param array  $enabled         Array of Sharing Services currently enabled.
 *
 * @since store_test 1.0.0
 */
function psf_store_share_daddy_markup( $sharing_content, $enabled ) {
	if( is_product() ) {
		$sharing_content = str_replace( 'sd-sharing-enabled', 'sd-sharing-enabled col-lg-9', $sharing_content );
	}

	return $sharing_content;
}
add_filter( 'jetpack_sharing_display_markup', 'psf_store_share_daddy_markup', 10, 2 );


// Utils
// ------------------------------------------------------------
/**
 * Remove Jetpack CSS
 *
 * @since store_test 1.0.0
 */

// Make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );

// Remove each CSS file, one at a time
function psf_store_remove_jetpack_styles() {
	if ( ! is_admin() ) {
		wp_deregister_style( 'grunion.css' );
	}
}
add_action( 'wp_print_styles', 'psf_store_remove_jetpack_styles' );
