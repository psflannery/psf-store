<?php
/**
 * Store test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Store_test
 */

if ( ! function_exists( 'psf_store_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function psf_store_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Store test, use a find and replace
		 * to change 'psf-store' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'psf-store', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'  => esc_html__( 'Primary', 'psf-store' ),
			'customer' => esc_html__( 'Customer', 'psf-store' ),
			'info'     => esc_html__( 'Info', 'psf-store' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'psf_store_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 190,
			'width'       => 190,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Add support for Block Styles
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles
		//add_editor_style( 'style-editor.css' );
	}
endif;
add_action( 'after_setup_theme', 'psf_store_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function psf_store_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'psf_store_content_width', 640 );
}
add_action( 'after_setup_theme', 'psf_store_content_width', 0 );

/**
 * Register custom fonts.
 *
 * @return void
 * 
 * @since store_test 1.0.0
 */
function psf_store_fonts_url() {
	$fonts_url = '';
	
	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Montserrat, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$montserrat = _x( 'on', 'montserrat font: on or off', 'psf-store' );
	
	if ( 'off' !== $montserrat ) {
		$font_families = array();
		$font_families[] = 'Montserrat:300,400,500,600';
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @param  array  $urls           URLs to print for resource hints.
 * @param  string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 *
 * @since store_test 1.0.0
 */
function psf_store_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'psf-store-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'psf_store_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function psf_store_widgets_init() {
	$sidebar_args['sidebar'] = array(
		'name'          => __( 'Sidebar', 'psf-store' ),
		'id'            => 'sidebar-1',
		'description'   => '',
	);

	$sidebar_args['header'] = array(
		'name'        => __( 'Below Header', 'psf-store' ),
		'id'          => 'header-1',
		'description' => __( 'Widgets added to this region will appear beneath the header and above the main content.', 'psf-store' ),
	);

	$sidebar_args['archive-product'] = array(
		'name'        => __( 'Product Archive Top', 'psf-store' ),
		'id'          => 'archive-product-1',
		'description' => __( 'Widgets added to this region will appear above the product archive.', 'psf-store' ),
	);

	$sidebar_args['single-product'] = array(
		'name'        => __( 'Below Product', 'psf-store' ),
		'id'          => 'single-product-1',
		'description' => __( 'Widgets added to this region will appear beneath the product description.', 'psf-store' ),
	);

	$sidebar_args['single-product-2'] = array(
		'name'        => __( 'Recently Viewed Items', 'psf-store' ),
		'id'          => 'single-product-2',
		'description' => __( 'A region exclusively for the Recently Viewed Items widget.', 'psf-store' ),
	);

	$sidebar_args['footer-top'] = array(
		'name'        => __( 'Above Footer', 'psf-store' ),
		'id'          => 'above-footer-1',
		'description' => __( 'Widgets added to this region will appear above the footer and below the main content.', 'psf-store' ),
	);

	$sidebar_args['contact'] = array(
		'name'        => __( 'Contact Page', 'psf_store' ),
		'id'          => 'contact',
		'description' => __( 'Widgets added to this region will appear on the contact page.', 'psf_store' ),
	);

	$rows    = intval( apply_filters( 'psf_store_footer_widget_rows', 2 ) );
	$regions = intval( apply_filters( 'psf_store_footer_widget_columns', 4 ) );

	for ( $row = 1; $row <= $rows; $row++ ) {
		for ( $region = 1; $region <= $regions; $region++ ) {
			$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
			$footer   = sprintf( 'footer_%d', $footer_n );
			
			if ( 1 == $rows ) {
				// translators: 1: column number
				$footer_region_name = sprintf( __( 'Footer Column %1$d', 'psf-store' ), $region );
				
				// translators: 1: column number
				$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'psf-store' ), $region );
			} else {
				// translators: 1: row number, 2: column number
				$footer_region_name = sprintf( __( 'Footer Row %1$d - Column %2$d', 'psf-store' ), $row, $region );
	
				// translators: 1: column number, 2: row number
				$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'psf-store' ), $region, $row );
			}
	
			$sidebar_args[ $footer ] = array(
				'name'        => $footer_region_name,
				'id'          => sprintf( 'footer-%d', $footer_n ),
				'description' => $footer_region_description,
			);
		}
	}

	$sidebar_args = apply_filters( 'psf_store_sidebar_args', $sidebar_args );

	foreach ( $sidebar_args as $sidebar => $args ) {
		$widget_tags = array(
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		);
		
		/**
		 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
		 *
		 * 'psf_store_sidebar_widget_tags'
		 * 'psf_store_header_widget_tags'
		 * 'psf_store_footer-top_widget_tags'
		 * 'psf_store_archive-product_widget_tags'
		 * 'psf_store_single-product_widget_tags'
		 * 'psf_store_single-product-2_widget_tags'
		 * 'psf_store_contact_widget_tags'
		 *
		 * 'psf_store_footer_1_widget_tags'
		 * 'psf_store_footer_2_widget_tags'
		 * 'psf_store_footer_3_widget_tags'
		 * 'psf_store_footer_4_widget_tags'
		 */
		$filter_hook = sprintf( 'psf_store_%s_widget_tags', $sidebar );
		$widget_tags = apply_filters( $filter_hook, $widget_tags );
		
		if ( is_array( $widget_tags ) ) {
			register_sidebar( $args + $widget_tags );
		}
	}
}
add_action( 'widgets_init', 'psf_store_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function psf_store_scripts() {
	/**
	 * If WP is in script debug, or we pass ?script_debug in a URL - set debug to true.
	 */
	$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) || ( isset( $_GET['script_debug'] ) ) ? true : false;

	$version = '1.0.0';

	/**
	 * Should we load minified files?
	 */
	$suffix = ( true === $debug ) ? '' : '.min';

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'psf-store-fonts', psf_store_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'psf-store-style', get_stylesheet_uri() );

	wp_enqueue_script( 'psf-store-plugins', get_template_directory_uri() . '/js/plugins.min.js', array(), $version, true );
	wp_enqueue_script( 'psf-store-main', get_template_directory_uri() . '/js/main' . $suffix . '.js', array(), $version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'psf_store_scripts' );

/**
 * Enqueue supplemental block editor styles
 *
function psf_store_editor_frame_styles() {
	wp_enqueue_style( 'psf_store-frame-styles', get_theme_file_uri( '/style-editor-frame.css' ), false, '1.0', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'psf_store_editor_frame_styles' ); */

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Load custom filters and hooks.
 */
require get_template_directory() . '/inc/hooks.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * SVG icons functions and filters.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce/woocommerce.php';
	require get_template_directory() . '/inc/woocommerce/woocommerce-template-functions.php';
	require get_template_directory() . '/inc/woocommerce/woocommerce-template-hooked-functions.php';
	require get_template_directory() . '/inc/woocommerce/woocommerce-template-hooks.php';
}
