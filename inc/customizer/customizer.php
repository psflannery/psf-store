<?php
/**
 * Store test Theme Customizer
 *
 * @package Store_test
 */

/**
 * Include other customizer files.
 *
 * @since store_test 1.0.0
 */
function psf_store_include_custom_controls() {
	require get_template_directory() . '/inc/customizer/panels.php';
	require get_template_directory() . '/inc/customizer/sections.php';
	require get_template_directory() . '/inc/customizer/settings.php';
}
add_action( 'customize_register', 'psf_store_include_custom_controls', -999 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since store_test 1.0.0
 */
function psf_store_customize_preview_js() {
	$version = '1.0.0';
	
	wp_enqueue_script( 'psf-store-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), $version, true );
}
add_action( 'customize_preview_init', 'psf_store_customize_preview_js' );

/**
 * Add support for the fancy new edit icons.
 *
 * @param object $wp_customize Instance of WP_Customize_Class.
 * @link https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/.
 *
 * @since store_test 1.0.0
 */
function psf_store_selective_refresh_support( $wp_customize ) {
	// The <div> classname to append edit icon too.
	$settings = array(
		'blogname'                  => '.site-title a',
		'blogdescription'           => '.site-description',
		'psf_store_promotions_text' => '.header-promo',
		'psf_store_footer_text'     => '#footer-text',
		'psf_store_category_titles' => '.woocommerce-products-header__title',
	);

	// Loop through, and add selector partials.
	foreach ( (array) $settings as $setting => $selector ) {
		$args = array( 'selector' => $selector );
		$wp_customize->selective_refresh->add_partial( $setting, $args );
	}
}
add_action( 'customize_register', 'psf_store_selective_refresh_support' );

/**
 * Add live preview support via postMessage.
 *
 * Note: You will need to hook this up via livepreview.js
 *
 * @param object $wp_customize Instance of WP_Customize_Class.
 * @link https://codex.wordpress.org/Theme_Customization_API#Part_3:_Configure_Live_Preview_.28Optional.29.
 *
 * @since store_test 1.0.0
 */
function psf_store_live_preview_support( $wp_customize ) {
	// Settings to apply live preview to.
	$settings = array(
		'blogname',
		'blogdescription',
		'header_textcolor',
		'background_image',
		'psf_store_promotions_text',
		'psf_store_footer_text',
	);

	// Loop through and add the live preview to each setting.
	foreach ( (array) $settings as $setting_name ) {
		// Try to get the customizer setting.
		$setting = $wp_customize->get_setting( $setting_name );
		
		// Skip if it is not an object to avoid notices.
		if ( ! is_object( $setting ) ) {
			continue;
		}
		
		// Set the transport to avoid page refresh.
		$setting->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'psf_store_live_preview_support', 999 );

/**
 * Sanitize customizer text inputs.
 *
 * @param  string $input Text saved in Customizer input fields.
 * @return string        Sanitized output.
 *
 * @since store_test 1.0.0
 */
function psf_store_sanitize_customizer_text( $input ) {
    return sanitize_text_field( force_balance_tags( $input ) );
}

/**
 * Sanitise customiser checkbox inputs.
 * 
 * @param  bool $checked [description]
 * @return bool          Value of checkbox
 *
 * @since store_test 1.0.0
 */
function psf_store_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

