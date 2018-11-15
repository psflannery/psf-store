<?php
/**
 * Store_test WooCommerce hooks
 *
 * @package Store_test
 */

/**
 * Homepage
 *
 * @see  psf_store_homepage_content()
 * @see  psf_store_product_categories()
 * @see  psf_store_recent_products()
 * @see  psf_store_featured_products()
 * @see  psf_store_featured_products_slideshow()
 * @see  psf_store_on_sale_products()
 *
 * @see  psf_store_homepage_header()
 * @see  psf_store_page_content()
 */
add_action( 'homepage', 'psf_store_homepage_content', 10 );
add_action( 'homepage', 'psf_store_product_categories', 20 );
add_action( 'homepage', 'psf_store_recent_products', 30 );
add_action( 'homepage', 'psf_store_featured_products', 40 );
add_action( 'homepage', 'psf_store_featured_products_slideshow', 50 );
add_action( 'homepage', 'psf_store_on_sale_products', 60 );


/**
 * Products
 *
 * @see psf_store_sticky_single_add_to_cart()
 */
add_action( 'psf_store_after_footer', 'psf_store_sticky_single_add_to_cart', 999 );


// Post Content
//---------------------------------------------------------------
add_action( 'psf_store_homepage', 'psf_store_homepage_header', 10 );
add_action( 'psf_store_homepage', 'psf_store_page_content', 20 );


/**
 * Sale flashes.
 *
 * @see woocommerce_show_product_loop_sale_flash()
 * @see woocommerce_show_product_sale_flash()
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

add_action( 'psf_store_before_product_image', 'woocommerce_show_product_loop_sale_flash', 10 );

/**
 * Archive descriptions.
 *
 * @see woocommerce_taxonomy_archive_description()
 * @see woocommerce_product_archive_description()
 * @see psf_store_product_archive_sidebar()
 */
add_action( 'woocommerce_archive_description', 'psf_store_product_archive_sidebar', 20 );

/**
 * Layout
 *
 */

// Before Content
//---------------------------------------------------------------
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

add_action( 'before_content', 'woocommerce_breadcrumb', 10 );
add_action( 'woocommerce_before_main_content', 'psf_store_woocommerce_wrapper_before' );


// After Content
//---------------------------------------------------------------
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_after_main_content', 'psf_store_woocommerce_wrapper_after' );


// Sidebar
//---------------------------------------------------------------
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
//add_action( 'woocommerce_sidebar', 'psf_store_woocommerce_wrapper_after_sidebar', 15 );


/**
 * Product Loop Items.
 *
 * @see psf_store_sorting_wrapper_open()
 * @see psf_store_product_filter_wrap_open()
 * @see psf_store_product_filter_wrap_close()
 * @see psf_store_sorting_wrapper_close()
 * @see psf_store_template_loop_product_link_open()
 * @see psf_store_template_loop_product_card_open()
 * @see psf_store_template_loop_product_thumbnail()
 * @see psf_store_template_loop_product_card_body_open()
 * @see psf_store_template_loop_product_title()
 * @see psf_store_template_loop_product_card_body_close()
 * @see psf_store_template_loop_product_card_close()
 *
 * @see psf_store_template_loop_category_link_open
 */

// Shop Loop
//---------------------------------------------------------------
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop', 'psf_store_sorting_wrapper_open', 5 );
add_action( 'woocommerce_before_shop_loop', 'psf_store_product_filter_wrap_open', 9 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
add_action( 'woocommerce_before_shop_loop', 'psf_store_product_filter_wrap_close', 11 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'psf_store_sorting_wrapper_close', 25 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 30 );


// Before Shop Loop Items
//---------------------------------------------------------------
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );

add_action( 'woocommerce_before_shop_loop_item', 'psf_store_template_loop_product_link_open', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'psf_store_template_loop_product_card_open', 5 );
add_action( 'woocommerce_before_subcategory', 'psf_store_template_loop_product_card_open', 5 );
add_action( 'woocommerce_before_subcategory', 'psf_store_template_loop_category_link_open', 10 );


// Before Shop Loop Title
//---------------------------------------------------------------
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

add_action( 'woocommerce_before_shop_loop_item_title', 'psf_store_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'psf_store_template_loop_product_card_body_open', 15 );
add_action( 'woocommerce_before_subcategory_title', 'psf_store_template_loop_before_product_thumbnail', 9 );
add_action( 'woocommerce_before_subcategory_title', 'psf_store_template_loop_after_product_thumbnail', 11 );
add_action( 'woocommerce_before_subcategory_title', 'psf_store_template_loop_product_card_body_open', 15 );


// Shop Loop Title
//---------------------------------------------------------------
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

add_action( 'woocommerce_shop_loop_item_title', 'psf_store_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_subcategory_title', 'psf_store_template_loop_category_title', 10 );

// After Shop Loop Title
//--------------------------------------------------------------
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );
add_action( 'woocommerce_after_shop_loop_item_title', 'psf_store_template_loop_product_card_body_close', 90 );
add_action( 'woocommerce_after_subcategory_title', 'psf_store_template_loop_product_card_body_close', 90 );


// After Shop Loop Item
//--------------------------------------------------------------
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_after_shop_loop_item', 'psf_store_template_loop_product_card_close', 25 );
add_action( 'woocommerce_after_subcategory', 'psf_store_template_loop_product_card_close', 25 );


/**
 * Single Product Items.
 *
 * @see   psf_store_product_image_wrapper_open()
 * @see   psf_store_product_image_wrapper_close()
 * @see   psf_store_price_availabilty_wrapper_open()
 * @see   psf_store_stock_html()
 * @see   psf_store_price_availabilty_wrapper_close()
 * @see   woocommerce_template_single_rating()
 * @see   psf_store_product_hidden_inputs()
 * @see   woocommerce_template_single_sharing()
 * @see   psf_store_tabs_wrapper_open()
 * @see   woocommerce_output_product_data_tabs()
 * @see   psf_store_tabs_wrapper_close()
 * @see   psf_store_single_product_summary_footer()
 * @see   woocommerce_upsell_display()
 * @see   woocommerce_output_related_products()
 */

// Before Product Summary
//--------------------------------------------------------------
add_action( 'woocommerce_before_single_product_summary', 'psf_store_product_image_wrapper_open', 9 );
add_action( 'woocommerce_before_single_product_summary', 'psf_store_product_image_wrapper_close', 21 );


// Product Summary
//--------------------------------------------------------------
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

add_action( 'woocommerce_single_product_summary', 'psf_store_price_availabilty_wrapper_open', 9 );
add_action( 'woocommerce_single_product_summary', 'psf_store_stock_html', 10 );
add_action( 'woocommerce_single_product_summary', 'psf_store_price_availabilty_wrapper_close', 11 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 25 );
add_action( 'woocommerce_single_product_summary', 'psf_store_product_hidden_inputs', 29 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 35 );
add_action( 'woocommerce_single_product_summary', 'psf_store_tabs_wrapper_open', 39 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 40 );
add_action( 'woocommerce_single_product_summary', 'psf_store_tabs_wrapper_close', 41 );


// Product Summary Footer
//--------------------------------------------------------------
add_action( 'psf_store_single_product_summary_footer', 'psf_store_single_product_widget_area', 10 );


// After Product Summary
//--------------------------------------------------------------
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 5 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 6 );
add_action( 'woocommerce_after_single_product_summary', 'psf_store_recently_viewed_product_widget_area', 8 );


/**
 * Cart
 *
 * @see woocommerce_cross_sell_display();
 * @see woocommerce_cart_totals();
 */

// Cart Collaterals
//--------------------------------------------------------------
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );


// Cart Totals
//--------------------------------------------------------------
add_action( 'psf_store_cart_totals', 'woocommerce_cart_totals' );


/**
 * Checkout
 *
 * @see woocommerce_checkout_coupon_form()
 * @see woocommerce_checkout_payment()
 */

// Checkout Order Review
//--------------------------------------------------------------
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );


// Review Order After Order
//--------------------------------------------------------------
add_action( 'woocommerce_review_order_after_order_total', 'woocommerce_checkout_payment', 20 );
