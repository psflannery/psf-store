<?php
/**
 * Store test customizer settings.
 *
 * @package Store_test
 */

function psf_store_details( $wp_customize ) {
	// Register address line 1 setting.
	$wp_customize->add_setting(
		'psf_store_address_1',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => get_option( 'woocommerce_store_address', '' ),
			'transport'         => 'postMessage',
		)
	);

	// Create address line 1 setting field.
	$wp_customize->add_control(
		'psf_store_address_1',
		array(
			'label'   => esc_html__( 'Address Line 1', 'psf-store' ),
			'section' => 'psf_store_details_section',
			'type'    => 'text',
		)
	);

	// Register address line 2 setting.
	$wp_customize->add_setting(
		'psf_store_address_2',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => get_option( 'woocommerce_store_address_2', '' ),
			'transport'         => 'postMessage',
		)
	);

	// Create address line 2 setting field.
	$wp_customize->add_control(
		'psf_store_address_2',
		array(
			'label'   => esc_html__( 'Address Line 2', 'psf-store' ),
			'section' => 'psf_store_details_section',
			'type'    => 'text',
		)
	);

	// Register address city setting.
	$wp_customize->add_setting(
		'psf_store_address_city',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => ! empty( get_option( 'woocommerce_store_city', '' ) ) ? get_option( 'woocommerce_store_city', '' ) : '',
			'transport'         => 'postMessage',
		)
	);

	// Create address city setting field.
	$wp_customize->add_control(
		'psf_store_address_city',
		array(
			'label'   => esc_html__( 'City', 'psf-store' ),
			'section' => 'psf_store_details_section',
			'type'    => 'text',
		)
	);

	// Register address postcode setting.
	$wp_customize->add_setting(
		'psf_store_address_postcode',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => ! empty( get_option( 'woocommerce_store_postcode', '' ) ) ? get_option( 'woocommerce_store_postcode', '' ) : '',
		)
	);

	// Create address postcode setting field.
	$wp_customize->add_control(
		'psf_store_address_postcode',
		array(
			'label'   => esc_html__( 'Postcode', 'psf-store' ),
			'section' => 'psf_store_details_section',
			'type'    => 'text',
		)
	);

	// Register address phone setting.
	$wp_customize->add_setting(
		'psf_store_address_phone',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => '',
		)
	);

	// Create address phone setting field.
	$wp_customize->add_control(
		'psf_store_address_phone',
		array(
			'label'   => esc_html__( 'Phone', 'psf-store' ),
			'section' => 'psf_store_details_section',
			'type'    => 'text',
		)
	);

	// Register address phone setting.
	$wp_customize->add_setting(
		'psf_store_address_email',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => '',
		)
	);

	// Create address phone setting field.
	$wp_customize->add_control(
		'psf_store_address_email',
		array(
			'label'   => esc_html__( 'Email', 'psf-store' ),
			'section' => 'psf_store_details_section',
			'type'    => 'email',
		)
	);
}
add_action( 'customize_register', 'psf_store_details' );


/**
 * Register Category Title setting
 * 
 * @param  object $wp_customize Instance of WP_Customize_Class.
 *
 * @since store_test 1.0.0
 */
function psf_store_customize_category_titles( $wp_customize ) {
	// Register a setting.
	$wp_customize->add_setting(
		'psf_store_category_titles',
		array(
			'sanitize_callback' => 'psf_store_sanitize_checkbox',
			'default'           => true,
			'transport'         => 'postMessage',
		)
	);

	// Create the setting field.
	$wp_customize->add_control(
		'psf_store_category_titles',
		array(
			'label'       => esc_html__( 'Category Title', 'psf-store' ),
			'description' => esc_html__( 'Toggle the category titles on or off.', 'psf-store' ),
			'section'     => 'psf_store_category_titles',
			'type'        => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'psf_store_customize_category_titles' );

/**
 * Register promotions text setting.
 *
 * @param object $wp_customize Instance of WP_Customize_Class.
 *
 * @since store_test 1.0.0
 */
function psf_store_customize_promotions_text( $wp_customize ) {
	// Register a setting.
	$wp_customize->add_setting(
		'psf_store_promotions_text',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => '',
			'transport'         => 'postMessage',
		)
	);

	// Create the setting field.
	$wp_customize->add_control(
		'psf_store_promotions_text',
		array(
			'label'       => esc_html__( 'Promotions', 'psf-store' ),
			'description' => esc_html__( 'This text will be shown site-wide. Use it to show information and promotions to visitors!', 'psf-store' ),
			'section'     => 'psf_store_header_section',
			'type'        => 'textarea',
		)
	);

}
add_action( 'customize_register', 'psf_store_customize_promotions_text' );


/**
 * Register the mission statement.
 *
 * @since store_test 1.0.0
 */
function psf_store_customize_footer_text( $wp_customize ) {
	// Add the Mission Statement Setting and Control
	$wp_customize->add_setting(
		'psf_store_footer_text',
		array(
			'sanitize_callback' => 'psf_store_sanitize_customizer_text',
			'default'           => '',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'psf_store_footer_text',
		array(
			'label'       => __( 'Footer', 'psf-store' ),
			'description' => esc_html__( 'This text will be shown site-wide. It will appear in the footer of each page.', 'psf-store' ),
			'section'     => 'psf_store_footer_section',
			'type'        => 'textarea',
		)
	);

}
add_action( 'customize_register', 'psf_store_customize_footer_text' );


/**
 * Register the Sticky add to cart settings
 *
 * @since store_test 1.0.2
 */
function psf_store_customize_sticky_add_to_cart( $wp_customize ) {
	$wp_customize->add_setting(
		'psf_store_sticky_add_to_cart', 
		array(
			'default'               => true,
			'sanitize_callback'     => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'psf_store_sticky_add_to_cart', 
		array(
			'type'                  => 'checkbox',
			'section'               => 'psf_store_single_product_page',
			'label'                 => __( 'Sticky Add-To-Cart', 'psf-store' ),
			'description'           => __( 'A small content bar at the top of the browser window which includes relevant product information and an add-to-cart button. It slides into view once the standard add-to-cart button has scrolled out of view.', 'psf-store' ),
			'priority'              => 10,
		)
	);
}
add_action( 'customize_register', 'psf_store_customize_sticky_add_to_cart' );
