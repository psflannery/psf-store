<?php
/**
 * WooCommerce Template Functions.
 *
 * @package Store_test
 */

// Header Cart
//---------------------------------------------------------------

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'psf_store_woocommerce_header_cart' ) ) {
			psf_store_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'psf_store_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		psf_store_woocommerce_cart_link();
		//$fragments['a.cart-contents'] = ob_get_clean();
		$fragments['button.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'psf_store_woocommerce_cart_link_fragment' );

/**
 * Cart Link.
 *
 * Displayed a link to the cart including the number of items present and the cart total.
 *
 * @return void
 *
 * @since store_test 1.0.0
 */

function psf_store_woocommerce_cart_link() {
	if ( is_cart() || is_checkout() ) {
		$maybe_disabled = 'aria-disabled="true"';
	} else {
		$maybe_disabled = '';
	}
	?>
	<button class="cart-contents nav-link d-inline-flex btn btn-link border-0 xx" <?php echo $maybe_disabled ?> type="button">
		<?php
		$item_count_text = sprintf(
			// translators: number of items in the mini cart.
			_n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'psf-store' ),
			WC()->cart->get_cart_contents_count()
		);
		?>

		<?php echo psf_store_get_svg( array( 'icon' => 'basket' ) ); ?>
		
		<span class="count badge badge-pill badge-primary rounded-circle d-flex justify-content-center align-items-center"><?php echo esc_html( $item_count_text ); ?></span>
	</button>
	<?php
}


/**
 * Display Header Cart.
 *
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_woocommerce_header_cart() {
	if ( is_cart() || is_checkout() ) {
		$class = 'current-menu-item';
		$maybe_tooltip = '';
	} else {
		$class = '';
		$maybe_tooltip = 'data-toggle="tooltip" data-placement="bottom"';;
	}
	?>

	<ul id="site-header-cart" class="site-header-cart list-unstyled ml-2">
		<li class="nav-item <?php echo esc_attr( $class ); ?>" <?php echo $maybe_tooltip; ?> title="<?php esc_attr_e( 'View your shopping cart', 'psf-store' ); ?>">
			<?php psf_store_woocommerce_cart_link(); ?>
		</li>
		<li class="site-header-cart__cart">
			<button class="checkout__close checkout__cancel btn btn-link nav-link d-inline-flex" aria-label="<?php esc_html_e( 'Close Cart', 'psf-store' ); ?>" type="button">
				<?php echo psf_store_get_svg( array( 'icon' => 'close' ) ) ;?>
			</button>

			<?php
			$instance = array(
				'title' => '',
			);

			the_widget( 'WC_Widget_Cart', $instance );
			?>
		</li>
	</ul>
	<?php
}

// Short Description
//---------------------------------------------------------------

/**
 * Remove short description metabox
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function remove_short_description() {
	remove_meta_box( 'postexcerpt', 'product', 'normal' );
}
add_action( 'add_meta_boxes', 'remove_short_description', 999 );

/**
 * Remove short description display
 * 
 * @since store_test 1.0.0
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );


// Inputs
//---------------------------------------------------------------

/**
 * Add to cart loop button attributes
 * 
 * @param  array  $args     Default args.
 * @param  gloabl $product  Global product
 * @return array            Update button attributes.
 *
 * @since store_test 1.0.0
 */
function psf_store_foo( $defaults, $product ) {
	$defaults = array(
		'quantity'   => 1,
		'class'      => implode( ' ', array_filter( array(
			'btn',
			'btn-primary',
			is_singular( 'product' ) ? 'btn-block' : '',
			'button',
			'product_type_' . $product->get_type(),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
		) ) ),
		'attributes' => array(
			'data-product_id'  => $product->get_id(),
			'data-product_sku' => $product->get_sku(),
			'aria-label'       => $product->add_to_cart_description(),
			'rel'              => 'nofollow',
		),
	);

	return $defaults;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'psf_store_foo', 10, 2 );

/**
 * Filter attributes used for product variation dropdowns.
 * 
 * @param  array $args Accepted attributes for select dropdown.
 * @return array       Customised attributed for select dropdown.
 *
 * @since store_test 1.0.0
 */
function psf_store_dropdown_variation_attribute_options_args( $args ) {
	$args['class'] = 'custom-select custom-select-sm';

	return $args;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'psf_store_dropdown_variation_attribute_options_args' );


// Tabs
//---------------------------------------------------------------

/**
 * Remove default product tabs
 * 
 * @param  array $tabs Product tabs.
 * @return array       Filtered product tabs.
 *
 * @since store_test 1.0.0
 */
function psf_store_remove_product_tabs( $tabs ) {
    unset( $tabs['reviews'] );

    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'psf_store_remove_product_tabs', 98 );


// Breadcrumbs
//---------------------------------------------------------------

/**
 * Customise breadcrumb markup.
 * 
 * @return array customised breadcrumb settings.
 *
 * @since store_test 1.0.0
 */
function psf_store_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '',
        'wrap_before' => '<nav aria-label="breadcrumb" class="container"><ol class="breadcrumb border-bottom small mb-0 py-2 bg-white text-muted">',
        'wrap_after'  => '</ol></nav>',
        'before'      => '<li class="breadcrumb-item">',
        'after'       => '</li>',
        'home'        => _x( 'Home', 'breadcrumb', 'psf-store' ),
    );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'psf_store_woocommerce_breadcrumbs' );


// Sale Flash
//---------------------------------------------------------------

/**
 * Filter the Sale flash Html.
 * 
 * @return string Filtered sale flash html.
 *
 * @since store_test 1.0.0
 */
function psf_store_sale_flash() {
	return '<span class="onsale badge badge-danger rounded">' . esc_html__( 'Sale', 'psf-store' ) . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'psf_store_sale_flash' );


// Product Archives
//---------------------------------------------------------------

/**
 * Toggle archive titles
 * 
 * @return bool
 *
 * @since store_test 1.0.0
 */
function psf_store_toggle_archive_titles() {
	$maybe_show_title = get_theme_mod( 'psf_store_category_titles' );

	return $maybe_show_title ? true : false;
}
add_filter( 'woocommerce_show_page_title', 'psf_store_toggle_archive_titles' );

/**
 * Show an archive description on taxonomy archives.
 *
 * @see   https://github.com/woocommerce/woocommerce/blob/f311ad0d12ef7efdb1bb5ae0980fbb70d3ab91f7/includes/wc-template-functions.php#L1133
 * @since store_test 1.0.0
 */
function woocommerce_taxonomy_archive_description() {
	if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
		$term = get_queried_object();
		
		if ( $term && ! empty( $term->description ) ) {
			echo '<div class="term-description text-center">' . wc_format_content( $term->description ) . '</div>'; // WPCS: XSS ok.
		}
	}
}

/**
 * Filter classes used in the Product list.
 * 
 * @return string Filtered classes applied to the product list.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_product_list_classes( $classes ) {
	if( is_product() ) {
		$classes .= 'carousel-wrap px-sm-5 px-md-3 px-lg-0';
	} else {
		$classes .= 'row';
	}

	return esc_attr_e( $classes );
}
add_filter( 'psf_store_product_list_classes', 'psf_store_filter_product_list_classes', 10 );

/**
 * Filter classes used in the Product list items.
 * 
 * @return string Filtered classes applied to the product list items.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_product_list_item_classes() {
	$product_list_item_class = '';

	if( is_product() ) {
		$product_list_item_class = 'col-6 col-md-4 col-lg-2 d-flex';
	}

	return esc_attr( $product_list_item_class );
}
add_filter( 'psf_store_product_list_item_classes', 'psf_store_filter_product_list_item_classes', 10 );


// Product Cards
//---------------------------------------------------------------

/**
 * Set the classes for the card product links.
 * 
 * @return string Card product link classes.
 *
 * @since store_test 1.0.0
 */
function psf_store_loop_product_link_classes() {
	return 'woocommerce-LoopProduct-link woocommerce-loop-product__link flex-grow-1 text-decoration-none text-capitalize';
}


// Product Gallery
//---------------------------------------------------------------

/**
 * Change Gallery Columns on Single Product Page - overrides Woocommerce default
 * 
 * @return mixed         The filtered number of product thumbnails to return.
 * 
 * @since store_test 1.0.0
 */
function psf_store_change_gallery_columns() {
	return 1; 
}
add_filter( 'woocommerce_product_thumbnails_columns', 'psf_store_change_gallery_columns' );

/**
 * Filter classes used in Product image gallery.
 * 
 * @param  array $wrapper_classes Classes applied to product gallery
 * @return array                  Filtered classes applied to product gallery
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_single_product_image_gallery_classes( $wrapper_classes ) {
	$wrapper_classes = array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
		'images',
	);

	return $wrapper_classes;
}
add_filter( 'woocommerce_single_product_image_gallery_classes', 'psf_store_filter_single_product_image_gallery_classes' );

/**
 * Filter Produxt Gallery Image Size
 * 
 * @return void
 *
 * @since store_test 1.0.0
 */
function psf_store_gallery_image_size() {
	return 'woocommerce_single';
}
add_filter( 'woocommerce_gallery_image_size', 'psf_store_gallery_image_size' );


// Product Summary
//---------------------------------------------------------------

/**
 * Get availability classname based on stock status.
 * 
 * @param  string $class Classnames
 * @param  obj    $this  Product
 * @return string        Additional classnames
 *
 * @since store_test 1.0.0
 */
function psf_store_availabilty_classes( $class, $this ) {
	$class .= ' small d-inline-block pl-4';

	return $class;
}
add_filter( 'woocommerce_get_availability_class', 'psf_store_availabilty_classes', 10, 2 );


// Recently Viewd Products
//---------------------------------------------------------------

/**
 * Check to see if we have any recently viewed products
 * 
 * @return int The number of recently viewed products.
 * @see https://wordpress.stackexchange.com/questions/288942/assign-a-minimum-result-count-for-woocommerce-query-shortcodes
 *
 * @since store_test 1.0.0
 */
function psf_store_get_recently_viewed_products_count() {   
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();  
    
    return count( $viewed_products );
}


// Notices
//---------------------------------------------------------------

/**
 * Filter demo store notice.
 * 
 * @param  string $notice Demo store text.
 * @return string         Custom html for demo store notice.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_woocommerce_demo_store_notice( $notice ) {
	$text = get_option( 'woocommerce_demo_store_notice' );

	if ( empty( $text ) ) {
		$text = __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'psf-store' );
	}

    $notice = '<div class="alert alert-info alert-dismissible fade show demo_store fixed-bottom mb-0" role="alert">' . wp_kses_post( $text ) . ' <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">' . psf_store_get_svg( array( 'icon' => 'close' ) ) . '</span></button></div>';

    return $notice;
}
add_filter( 'woocommerce_demo_store', 'psf_store_filter_woocommerce_demo_store_notice' );


// Checkout
//---------------------------------------------------------------

/**
 * Filter Paypal gateway icon
 * 
 * @param  string $icon_html Html for paypal icon.
 * @return string            Custom html for paypal icon.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_paypal_icon( $icon_html ) {
	$icon_html = '';

	return $icon_html;
}
add_filter( 'woocommerce_gateway_icon', 'psf_store_filter_paypal_icon' );

/**
 * Filter checkout field attributes.
 * 
 * @param  array $fields Field attributes
 * @return mixed         The filtered checkout field attributes.
 *
 * @since store_test 1.0.0
 */
function psf_store_override_checkout_fields( $fields ) {
    //$fields['billing']['billing_address_2']['placeholder'] = 'Optional';
    $fields['order']['order_comments']['placeholder'] = esc_html__( 'Notes about your order, e.g. special notes for delivery.', 'psf-store' );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'psf_store_override_checkout_fields' );

/**
 * Filter checkoutform form classes
 * 
 * @see https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
 *
 * @param string $args  Form attributes.
 * @param string $key   Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 *
 * @since store_test 1.0.0
 */ 
function psf_store_form_field_args( $args, $key, $value ) { 
	$args['class'][] = 'form-group mx-0';
	$args['input_class'][] = 'form-control';

	return $args; 
}
add_filter('woocommerce_form_field_args','psf_store_form_field_args', 10, 3);


// Widgets
//---------------------------------------------------------------

/**
 * Filter layered nav html
 * 
 * @param  int    $count Product count.
 * @return string        Custom html for product layered nav count.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_sidebar_count_html( $count, $term ) {
	return '<span class="count badge">' . $term . '</span>';
}
add_filter( 'woocommerce_layered_nav_count', 'psf_store_filter_sidebar_count_html', 10, 2 );
