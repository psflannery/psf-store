<?php
/**
 * Store test customizer panels.
 *
 * @package Store_test
 */

/**
 * Add a custom panels to attach sections too.
 *
 * @param object $wp_customize Instance of WP_Customize_Class.
 *
 * @since store_test 1.0.0
 */

function psf_store_customize_panels( $wp_customize ) {
	
	// Register a new panel.
	$wp_customize->add_panel(
		'store-options', array(
			'priority'       => 150,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => esc_html__( 'Store Options', 'psf-store' ),
			'description'    => esc_html__( 'This panel is used for setting, adding and adjusting various layout components for the theme.', 'psf-store' ),
		)
	);
}
add_action( 'customize_register', 'psf_store_customize_panels' );