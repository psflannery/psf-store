<?php
/**
 * SVG icons related functions and filters
 *
 * @package Store_test
 */

/**
 * Add SVG definitions to the footer.
 *
 * @since store_test 1.0.0
 */
function psf_store_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/images/svg-icons.svg';
	
	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
add_action( 'wp_footer', 'psf_store_include_svg_icons', 9999 );

/**
 * Return SVG markup.
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 *
 * @since store_test 1.0.0
 */
function psf_store_get_svg( $args = array() ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return __( 'Please define default parameters in the form of an array.', 'psf-store' );
	}
	
	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return __( 'Please define an SVG icon filename.', 'psf-store' );
	}
	
	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'aria_hidden' => true, // Hide from screen readers.
		'fallback'    => false,
	);
	
	// Parse args.
	$args = wp_parse_args( $args, $defaults );
	
	// Set aria hidden.
	$aria_hidden = '';
	if ( true === $args['aria_hidden'] ) {
		$aria_hidden = ' aria-hidden="true"';
	}
	
	// Set ARIA.
	$aria_labelledby = '';
	if ( $args['title'] && $args['desc'] ) {
		$aria_labelledby = ' aria-labelledby="title desc"';
	}
	
	// Begin SVG markup.
	$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';
	
	// If there is a title, display it.
	if ( $args['title'] ) {
		$svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
	}
	
	// If there is a description, display it.
	if ( $args['desc'] ) {
		$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
	}
	
	// Use absolute path in the Customizer so that icons show up in there.
	if ( is_customize_preview() ) {
		$svg .= '<use xlink:href="' . get_template_directory() . '/assets/images/svg-icons.svg#icon-' . esc_html( $args['icon'] ) . '"></use>';
	} else {
		$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	}
	
	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}
	
	$svg .= '</svg>';
	
	return $svg;
}

/**
 * Display SVG icons in customer links menu.
 * 
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 *
 * @since store_test 1.0.0
 */
function psf_store_customer_menu_icons( $item_output, $item, $depth, $args ) {
	// Get supported icons.
	$icons = psf_store_link_icons();

	if ( 'customer' === $args->theme_location ) {
		foreach ( $icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . psf_store_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'psf_store_customer_menu_icons', 10, 4 );

/**
 * Returns an array of supported links (URL and icon name).
 *
 * @return array $link_icons
 */
function psf_store_link_icons() {
	// Supported link icons.
	$link_icons = array(
		'my-account' => 'user-account',
		'basket'     => 'basket',
		'close'      => 'close',
		'add'        => 'add',
		'remove'     => 'remove',
	);

	return apply_filters( 'psf_store_link_icons', $link_icons );
}
