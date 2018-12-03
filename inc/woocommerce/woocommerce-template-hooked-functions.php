<?php
/**
 * Functions which hook into the Woocomerce template markup
 *
 * @package Store_test
 */

/**
 * Homepage
 */

if ( ! function_exists( 'psf_store_homepage_content' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @return  void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_homepage_content() {
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', 'homepage' );
		}
	}
}

if ( ! function_exists( 'psf_store_product_categories' ) ) {
	/**
	 * Display Product Categories
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_product_categories( $args ) {
		$args = apply_filters(
			'psf_store_product_categories_args', array(
				'limit'             => 12,
				'columns'           => 4,
				'child_categories'  => 0,
				'orderby'           => 'name',
				'title'             => __( 'Shop by Category', 'psf-store' ),
			)
		);

		$shortcode_content = psf_store_do_shortcode(
			'product_categories', apply_filters(
				'psf_store_product_categories_shortcode_args', array(
					'number'  => intval( $args['limit'] ),
					'columns' => intval( $args['columns'] ),
					'orderby' => esc_attr( $args['orderby'] ),
					'parent'  => esc_attr( $args['child_categories'] ),
				)
			)
		);

		/**
		 * Only display the section if the shortcode returns product categories
		 */
		if ( false !== strpos( $shortcode_content, 'product-category' ) ) {
			echo '<section class="storefront-product-section storefront-product-categories container" aria-label="' . esc_attr__( 'Product Categories', 'psf-store' ) . '">';
			echo '<div class="pt-5 border-top">';
			
			do_action( 'psf_store_homepage_before_product_categories' );
			
			echo '<h2 class="section-title text-center py-3 h4">' . wp_kses_post( $args['title'] ) . '</h2>';
			
			do_action( 'psf_store_homepage_after_product_categories_title' );
			
			echo $shortcode_content; // WPCS: XSS ok.
			
			do_action( 'psf_store_homepage_after_product_categories' );
			
			echo '</div>';
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'psf_store_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_on_sale_products( $args ) {
		$args = apply_filters(
			'psf_store_on_sale_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'on_sale' => 'true',
				'title'   => __( 'On Sale', 'psf-store' ),
			)
		);

		$shortcode_content = psf_store_do_shortcode(
			'products', apply_filters(
				'psf_store_on_sale_products_shortcode_args', array(
					'per_page' => intval( $args['limit'] ),
					'columns'  => intval( $args['columns'] ),
					'orderby'  => esc_attr( $args['orderby'] ),
					'order'    => esc_attr( $args['order'] ),
					'on_sale'  => esc_attr( $args['on_sale'] ),
				)
			)
		);

		/**
		 * Only display the section if the shortcode returns products
		 */
		if ( false !== strpos( $shortcode_content, 'product' ) ) {
			echo '<section class="storefront-product-section storefront-on-sale-products container" aria-label="' . esc_attr__( 'On Sale Products', 'psf-store' ) . '">';
			echo '<div class="pt-5 border-top">';
			
			do_action( 'psf_store_homepage_before_on_sale_products' );
			
			echo '<h2 class="section-title text-center py-3 h4">' . wp_kses_post( $args['title'] ) . '</h2>';
			
			do_action( 'psf_store_homepage_after_on_sale_products_title' );
			
			echo $shortcode_content; // WPCS: XSS ok.
			
			do_action( 'psf_store_homepage_after_on_sale_products' );
			
			echo '</div>';
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'psf_store_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_recent_products( $args ) {
		$args = apply_filters(
			'psf_store_recent_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   => __( 'New In', 'psf-store' ),
			)
		);

		$shortcode_content = psf_store_do_shortcode(
			'products', apply_filters(
				'psf_store_recent_products_shortcode_args', array(
					'orderby'  => esc_attr( $args['orderby'] ),
					'order'    => esc_attr( $args['order'] ),
					'per_page' => intval( $args['limit'] ),
					'columns'  => intval( $args['columns'] ),
				)
			)
		);

		/**
		 * Only display the section if the shortcode returns products
		 */
		if ( false !== strpos( $shortcode_content, 'product' ) ) {
			echo '<section class="storefront-product-section storefront-recent-products container" aria-label="' . esc_attr__( 'Recent Products', 'psf-store' ) . '">';
			echo '<div class="pt-5 border-top">';
			
			do_action( 'psf_store_homepage_before_recent_products' );
			
			echo '<h2 class="section-title text-center py-3 h4">' . wp_kses_post( $args['title'] ) . '</h2>';
			
			do_action( 'psf_store_homepage_after_recent_products_title' );
			
			echo $shortcode_content; // WPCS: XSS ok.
			
			do_action( 'psf_store_homepage_after_recent_products' );
			
			echo '</div>';
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'psf_store_featured_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_featured_products( $args ) {
		$args = apply_filters(
			'psf_store_featured_products_args', array(
				'limit'      => 4,
				'columns'    => 4,
				'orderby'    => 'date',
				'order'      => 'desc',
				'visibility' => 'featured',
				'title'      => __( 'We Recommend', 'psf-store' ),
			)
		);

		$shortcode_content = psf_store_do_shortcode(
			'products', apply_filters(
				'psf_store_featured_products_shortcode_args', array(
					'per_page'   => intval( $args['limit'] ),
					'columns'    => intval( $args['columns'] ),
					'orderby'    => esc_attr( $args['orderby'] ),
					'order'      => esc_attr( $args['order'] ),
					'visibility' => esc_attr( $args['visibility'] ),
				)
			)
		);

		/**
		 * Only display the section if the shortcode returns products
		 */
		if ( false !== strpos( $shortcode_content, 'product' ) ) {
			echo '<section class="storefront-product-section storefront-featured-products container" aria-label="' . esc_attr__( 'Featured Products', 'psf-store' ) . '">';
			echo '<div class="pt-5 border-top">';

			do_action( 'psf_store_homepage_before_featured_products' );

			echo '<h2 class="section-title text-center py-3 h4">' . wp_kses_post( $args['title'] ) . '</h2>';
			
			do_action( 'psf_store_homepage_after_featured_products_title' );

			echo $shortcode_content; // WPCS: XSS ok.

			do_action( 'psf_store_homepage_after_featured_products' );
			
			echo '</div>';
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'psf_store_featured_products_slideshow' ) ) {
	/**
	 * Display Featured Products Slideshow
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_featured_products_slideshow() {
		ob_start();

		$args = apply_filters( 
			'psf_store_featured_products_slideshow_args', array(
				'post_type'      => 'product',
				'posts_per_page' => 4,
				'orderby'        => 'date',
				'order'          => 'desc',
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					)
				)
			)
		);

		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) :

			echo '<section class="storefront-product-section storefront-featured-products-slides container" aria-label="' . esc_attr__( 'Featured Products Slides', 'psf-store' ) . '">';
			echo '<div class="pt-5 border-top">';

			do_action( 'before_psf_featured_product_slideshow' );

			echo '<ul class="list-unstyled carousel">';

			while ( $loop->have_posts() ) : $loop->the_post();

				get_template_part( 'template-parts/content', 'slides' );

			endwhile;

			echo '</ul>';

			do_action( 'after_psf_featured_product_slideshow' );

			echo '</div>';
			echo '</section>';

		else :

			get_template_part( 'template-parts/content', 'none' );
		
		endif;

		wp_reset_postdata();
		wp_reset_query();
	}
}


// Post Content
//---------------------------------------------------------------
if ( ! function_exists( 'psf_store_homepage_header' ) ) {
	/**
	 * Display the page header
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_homepage_header() {
		edit_post_link( __( 'Edit this section', 'psf-store' ), '', '', '', 'button storefront-hero__button-edit' );
		?>
		<!--<header class="entry-header py-5">-->
			
			<?php //the_title( '<h1 class="entry-title text-center mb-0 h4 text-uppercase">', '</h1>' ); ?>

		<!--</header>-->
		<?php
	}
}

if ( ! function_exists( 'psf_store_page_content' ) ) {
	/**
	 * Display the post content
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_page_content() {
		?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
						'after'  => '</div>',
					)
				);
			?>
		</div>
		<?php
	}
}


/**
 * Layout
 */

// Before Content
//---------------------------------------------------------------
if ( ! function_exists( 'psf_store_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_woocommerce_wrapper_before() {
		if( ! is_singular() ) : ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

		<?php
		endif;
	}
}

// After Content
//---------------------------------------------------------------
if ( ! function_exists( 'psf_store_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_woocommerce_wrapper_after() {
		if( ! is_singular() ) : ?>

				</main><!-- #main -->
			</div><!-- #primary -->

		<?php
		endif;
	}
}

// Sidebar
// 18/10/10 -- commented out
//---------------------------------------------------------------
if ( ! function_exists( 'psf_store_woocommerce_wrapper_after_sidebar' ) ) {
	/**
	 * After Sidebar
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_woocommerce_wrapper_after_sidebar() {
		if( ! is_singular() && is_active_sidebar( 'sidebar-1' ) ) : ?>

			</div><!-- .row --isSidebar  -->

		<?php
		endif;
	}
}

// Shop Loop
//---------------------------------------------------------------
if ( ! function_exists( 'psf_store_sorting_wrapper_open' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @return  void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_sorting_wrapper_open() {
		echo '<div class="store__sortable mt-3 d-flex justify-content-between align-items-center small text-muted container">';
	}
}

if ( ! function_exists( 'psf_store_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @return  void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'psf_store_archive_product_container_open' ) ) {
	/**
	 * Archive product container open
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.2
	 */
	function psf_store_archive_product_container_open() {
		echo '<div class="container">';
	}
}

if ( ! function_exists( 'psf_store_archive_product_container_close' ) ) {
	/**
	 * Archive product container close
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.2
	 */
	function psf_store_archive_product_container_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'psf_store_product_filter_wrap_open' ) ) {
	/**
	 * Product filter wrapper open.
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_product_filter_wrap_open() {
		echo '<div class="mb-3">';
	}
}

if ( ! function_exists( 'psf_store_product_filter_wrap_close' ) ) {
	/**
	 * Product filter wrapper close.
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_product_filter_wrap_close() {
		echo '</div>';
	}
}

// Before Shop Loop Items
//---------------------------------------------------------------

if ( ! function_exists( 'psf_store_template_loop_product_link_open' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_link_open() {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="' . psf_store_loop_product_link_classes() . '">';
	}
}

if ( ! function_exists( 'psf_store_template_loop_category_link_open' ) ) {
	/**
	 * Insert the opening anchor tag for categories in the loop.
	 *
	 * @param int|object|string $category Category ID, Object or String.
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_category_link_open( $category ) {
		echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '" class="' . psf_store_loop_product_link_classes() . '">';
	}
}

if ( ! function_exists( 'psf_store_template_loop_product_card_open' ) ) {
	/**
	 * Before shop loop item.
	 *
	 * Insert the opening div tag for product card.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_card_open() {
		if( is_front_page() && has_term( 'featured', 'product_visibility' ) ) {
			echo '<div class="card flex-grow-1 test--yy">';
		} else {
			echo '<div class="card flex-grow-1 test--xx">';
		}
	}
}


// Before Shop Loop Title
//---------------------------------------------------------------

if ( ! function_exists( 'psf_store_template_loop_before_product_thumbnail' ) ) {
	/**
	 * Before shop loop thumbnail.
	 *
	 * Insert the opening div tag for product card.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_before_product_thumbnail() {
		echo '<div class="card-img-top">';
	}
}

if ( ! function_exists( 'psf_store_template_loop_product_thumbnail' ) ) {
	/**
	 * Get the product thumbnail for the loop.
	 *
	 * Wrap the product thumbnail.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 * 
	 */
	function psf_store_template_loop_product_thumbnail() {
		psf_store_template_loop_before_product_thumbnail();

		/**
		 * Functions hooked in to psf_store_before_product_image
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 */
		do_action( 'psf_store_before_product_image' );

		echo woocommerce_get_product_thumbnail(); // WPCS: XSS ok.

		/**
		 * Functions hooked in to psf_store_after_product_image
		 */
		do_action( 'psf_store_after_product_image' );
		
		psf_store_template_loop_after_product_thumbnail();
	}
}

if ( ! function_exists( 'psf_store_template_loop_after_product_thumbnail' ) ) {
	/**
	 * Before shop loop thumbnail.
	 *
	 * Insert the closing div tag for product card.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_after_product_thumbnail() {
		echo '</div>';
	}
}

if ( ! function_exists( 'psf_store_template_loop_product_card_body_open' ) ) {
	
	/**
	 * Before shop item title
	 *
	 * Insert the opening div tag for product card body in the loop.
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_card_body_open() {
		echo '<div class="card-body text-center py-3">';
	}
}

// Shop Loop Title
//--------------------------------------------------------------
if ( ! function_exists( 'psf_store_template_loop_product_title' ) ) {
	/**
	 * Show the product title in the product loop. By default this is an H2.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_title() {
		echo '<h2 class="woocommerce-loop-product__title card-title text-body">' . get_the_title() . '</h2>';
	}
}

if ( ! function_exists( 'psf_store_template_loop_category_title' ) ) {
	/**
	 * Show the subcategory title in the product loop.
	 *
	 * @param object $category Category object.
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_category_title( $category ) {
		echo '<h2 class="woocommerce-loop-product__title card-title text-body mb-1 text-uppercase card-title text-body mb-1 text-uppercase">';

			echo esc_html( $category->name );

		echo '</h2>';
	}
}


// After Shop Loop Title
//--------------------------------------------------------------
if ( ! function_exists( 'psf_store_template_loop_product_card_body_close' ) ) {
	
	/**
	 * After shop item title
	 *
	 * Insert the closing div tag for product card body in the loop.
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_card_body_close() {
		echo '</div>';
	}
}

// After Shop Loop Item
//--------------------------------------------------------------

if ( ! function_exists( 'psf_store_template_loop_product_card_close' ) ) {
	/**
	 * After shop loop item.
	 *
	 * Insert the closing div tag for product card.
	 *
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_card_close() {
		echo '</div>';
	}
}


/**
 * Single Product Items.
 */

// Before Product Summary
//--------------------------------------------------------------

/**
 * Insert the opening div tag for the image wrapper.
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_product_image_wrapper_open() {
	echo '<div class="position-relative woocommerce-product-gallery--wrap">';
}

/**
 * Insert the closing div tag for the image wrapper.
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_product_image_wrapper_close() {
	echo '</div>';
}

// Product Summary
//--------------------------------------------------------------

/**
 * Insert the opening div tag for price and availability section.
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_price_availabilty_wrapper_open() {
	echo '<div class="col-12 product--price-availability">';
}

/**
 * Echo stock ammount
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_stock_html() {
	global $product;

	if ( ! $product->is_purchasable() ) {
		return;
	}

	echo wc_get_stock_html( $product ); // WPCS: XSS ok.
}

/**
 * Insert the closing div tag for price and availability section.
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_price_availabilty_wrapper_close() {
	echo '</div>';
}

/**
 * Insert hidden inputs into single product for ajax add to cart.
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_product_hidden_inputs() {
	global $product;
	
	$id = $product->get_id();

	echo '<input value="' . $id . '" id="product_id" type="hidden">';
	echo '<input value="1" id="product_quantity" type="hidden">';
}

/**
 * Insert the opening div tag for accordion (tabs).
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_tabs_wrapper_open() {
	echo '<div class="col-12">';
}

/**
 * Insert the closing div tag for accordion (tabs).
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_tabs_wrapper_close() {
	echo '</div>';
}

// Product Summary Footer
//--------------------------------------------------------------

/**
 * The sidebar containing the single product widget area.
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_single_product_widget_area() {
	get_sidebar( 'single-product' );
}


// After Product Summary
//--------------------------------------------------------------

/**
 * The sidebar used exclusively the Recently Viewed Products widget.
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_recently_viewed_product_widget_area() {
	get_sidebar( 'recently-viewed' );
}


/**
 * Cart
 */

// Cart Collaterals
//--------------------------------------------------------------

// Cart Totals
//--------------------------------------------------------------


/**
 * Checkout
 */

// Checkout Order Review
//--------------------------------------------------------------


// Review Order After Order
//--------------------------------------------------------------




// Possibly not used
//--------------------------------------------------------------
if ( ! function_exists( 'psf_store_template_loop_product_card_body_footer_open' ) ) {
	
	/**
	 * After shop loop item
	 *
	 * Insert the closing div tag for product card footer in the loop.
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_card_body_footer_open() {
		echo '<div class="card-footer text-center">';
	}
}

if ( ! function_exists( 'psf_store_template_loop_product_card_body_footer_close' ) ) {
	
	/**
	 * After shop loop item
	 *
	 * Insert the closing div tag for product card footer in the loop.
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_template_loop_product_card_body_footer_close() {
		echo '</div>';
	}
}