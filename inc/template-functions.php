<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Store_test
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function psf_store_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'psf_store_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function psf_store_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'psf_store_pingback_header' );

/**
 * Display the footer widget regions.
 *
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_footer_widgets() {
	$rows    = intval( apply_filters( 'psf_store_footer_widget_rows', 2 ) );
	$regions = intval( apply_filters( 'psf_store_footer_widget_columns', 4 ) );
	
	for ( $row = 1; $row <= $rows; $row++ ) :
		
		// Defines the number of active columns in this footer row.
		for ( $region = $regions; 0 < $region; $region-- ) {
			if ( is_active_sidebar( 'footer-' . esc_attr( $region + $regions * ( $row - 1 ) ) ) ) {
				$columns = $region;
				break;
			}
		}
		
		if ( isset( $columns ) ) : 
			$bs_classes = 'col-sm-6 col-md widget--col-xx px-5-xx'; ?>
			
			<div class="widget--row">
				<div class=<?php echo '"footer-widgets small row row-' . esc_attr( $row ) . ' py-5"'; ?>>

				<?php
				for ( $column = 1; $column <= $columns; $column++ ) :
					$footer_n = $column + $regions * ( $row - 1 );
					$filter_hook = sprintf( 'psf_store_footer_widget_%s_class', $footer_n );
					$widget_area_class = apply_filters( $filter_hook, esc_attr( $bs_classes ) );

					if ( is_active_sidebar( 'footer-' . esc_attr( $footer_n ) ) ) : ?>

					<div class="<?php echo $widget_area_class; ?> footer-widget-<?php echo esc_attr( $column ); ?>">

						<?php dynamic_sidebar( 'footer-' . esc_attr( $footer_n ) ); ?>
						
					</div>

					<?php
					endif;
				endfor; ?>

				</div>
			</div>

			<?php
			unset( $columns );
		endif;
	endfor;
}

/**
 * Set page container width
 * 
 * @return string container class.
 *
 * @since store_test 1.0.0
 */
function psf_store_container_width() {
	$classes = 'container';

	if ( is_page_template( 'page-templates/full--sidebar-half.php' ) 
		|| is_shop() 
		|| is_product_category() 
		|| is_product_tag() 
	) {
		$classes = 'container';
	}

	return $classes;
}
add_filter( 'psf_store_container_class', 'psf_store_container_width' );

/**
 * Comments wrapper open
 *
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_before_comments() {
	if ( is_singular() ) : ?>
		
		<div class="row">
			<div class="offset-md-5 col-md-6">
	
	<?php
	endif;
}
add_action( 'before-comments', 'psf_store_before_comments' );

/**
 * Comments wrapper close
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_after_comments() {
	if ( is_singular() ) : ?>
		
			</div><!-- .offset-md-5 .col-md-6 -->
		</div><!-- .row -->

	<?php
	endif;
}
add_action( 'after-comments', 'psf_store_after_comments' );

/**
 * Check if WooCommerce is activate
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
if ( ! function_exists( 'psf_store_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function psf_store_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 *
 * @since store_test 1.0.0
 */
function psf_store_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;
	
	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

if ( ! function_exists( 'psf_store_login_page_open' ) ) {
	/**
	 * Account page open
	 * Render different markup if user if logged in.
	 *
	 * @return  void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_login_page_open() {
		if( is_user_logged_in() ) {
			echo '<main id="main" class="site-main pb-5 my-5">';
		} else {
			echo '<main id="main" class="site-main pb-5 my-5 row">';
			echo '<div class="col-md-4 mx-auto card">';
		}
	}
}
add_action( 'before-login-page', 'psf_store_login_page_open', 10 );


if ( ! function_exists( 'psf_store_login_page_close' ) ) {
	/**
	 * Account page close
	 * Render different markup if user if logged in.
	 *
	 * @return  void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_login_page_close() {
		if( is_user_logged_in() ) {
			echo '</main>';
		} else {
			echo '</div><!-- .col-md-4 .mx-auto -->';
			echo '</main>';
		}
	}
}
add_action( 'after-login-page', 'psf_store_login_page_close', 10 );
