<?php
/**
 * Action hooks and filters.
 *
 * A place to put hooks and filters that aren't necessarily template tags.
 *
 * @package Store_test
 */

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the posts.
 * 
 * @param  array        $classes  Classes for the posts.
 * @param  string|array $class    One or more classes to add to the class list.
 * @param  object       $category object Optional.
 * @return array                  Additional classes for the posts.
 *
 * @since store_test 1.0.0
 *
 */
function psf_store_post_classes( $classes, $class, $post_id ) {
    if ( psf_store_is_product_archive() ) {
    	$classes[] = 'col-sm-6 col-md-4 col-lg-3 mb-5';
    }

    if ( is_front_page() && 'product' === get_post_type() ) {
    	$classes[] = 'col-sm-6 col-lg-3 mb-5';
    }

    if ( is_page_template( 'page-templates/template-login.php' ) && ! is_user_logged_in() ) {
    	$classes[] = 'card-body py-0';
    }
        
    return $classes;
}
add_filter( 'post_class', 'psf_store_post_classes', 10, 3 );

/**
 * Adds custom classes to the array of product category post classes.
 * 
 * @param  array        $classes  Classes for the posts.
 * @param  string|array $class    One or more classes to add to the class list.
 * @param  object       $category object Optional.
 * @return array                  Additional classes for the posts.
 *
 * @since store_test 1.0.0
 */
function psf_store_product_category_classes( $classes, $class, $category ) {
	if ( is_front_page() ) {
		$classes[] = 'col-sm-6 col-lg-4 mb-5';
	}

	return $classes;
}
add_filter( 'product_cat_class', 'psf_store_product_category_classes', 10, 3 );

/**
 * Adds custom classes to the array of menu classes.
 *
 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
 * @param WP_Post  $item    The current menu item.
 * @param stdClass $args    An object of wp_nav_menu() arguments.
 * 
 * @return array
 *
 * @since store_test 1.0.0
 */
function psf_store_menu_classes( $classes, $item, $args ) {
	if( $args->theme_location == 'primary' || $args->theme_location == 'customer' || $args->theme_location == 'info' ) {
		$classes[] = 'nav-item';
	}

	if ( in_array( 'current-menu-item', $classes ) ){
        $classes[] = 'active ';
    }

	return $classes;
}
add_filter( 'nav_menu_css_class', 'psf_store_menu_classes', 10, 3 );


/**
 * Add attributes to specified menu items.
 *
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 *
 * @param array $atts {
 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *
 *     @type string $title  Title attribute.
 *     @type string $target Target attribute.
 *     @type string $rel    The rel attribute.
 *     @type string $href   The href attribute.
 * }
 * @param WP_Post  $item  The current menu item.
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 *
 * @since store_test 1.0.0
 */
function psf_store_menu_atts( $atts, $item, $args, $depth ) {
	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
	}

	if( $args->theme_location == 'primary' || $args->theme_location == 'info' ) {
		$class = 'nav-link';

		// Make sure not to overwrite any existing classes
		$atts['class'] = ( !empty( $atts['class'] ) ) ? $atts['class'] .' '. $class : $class;
	}

	if( $args->theme_location == 'customer' ) {
		$class = 'd-inline-flex nav-link';

		// Make sure not to overwrite any existing classes
		$atts['class'] = ( !empty( $atts['class'] ) ) ? $atts['class'] .' '. $class : $class;

		if ( !empty($atts['title']) ) {
			$atts['data-toggle'] = 'tooltip';
			$atts['data-placement'] = 'bottom';
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'psf_store_menu_atts', 10, 4 );


/**
 * Add items to the menu list.
 * 
 * @param string   $items The HTML list content for the menu items.
 * @param stdClass $args  An object containing wp_nav_menu() arguments.
 *
 * @since store_test 1.0.0
 *
function psf_add_menu_list_items( $items, $args ) {
	if( $args->theme_location == 'customer' ) {

		return '<li class="nav-item d-md-none-x"><button class="nav-link btn btn-link px-2 border-0 d-inline-flex" type="button" data-toggle="collapse" data-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch"><span class="sr-only">' . esc_html__( 'Toggle search', 'psf-store' ) . '</span>' . psf_store_get_svg( array( 'icon' => 'search' ) ) . '</button></li>' . $items;
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'psf_add_menu_list_items', 10, 2 );
*/

/**
 * Filter thumbnail atts
 * 
 * @param  array $attr Attributes for the image markup. 
 * @return array       Filtered attributes for the image markup.
 *
 * @since store_test 1.0.0
 *
 * this seems to dupliacte imgage in the cart.
 */
function psf_store_filter_thumbnails_atts( $attr ) {
	if( is_cart() ) {
		$attr['class'] .= ' skip-lazy';
	}

	return $attr;
}
//add_filter( 'wp_get_attachment_image_attributes', 'psf_store_filter_thumbnails_atts' ); 

/**
 * Return the header promotions text saved in the Customizer.
 * 
 * @return string
 *
 * @since store_test 1.0.0
 */
function psf_store_get_header_promotions_text() {

	// Grab our customizer settings.
	$header_promotions_text = get_theme_mod( 'psf_store_promotions_text' );

	// Stop if there's nothing to display.
	if ( ! $header_promotions_text ) {
		return false;
	}

	$promo = sprintf(
		'<div class="container header-promo"><div class="text-center py-2 px-4 border-bottom small text-muted">%1$s</div></div>',
		$header_promotions_text
	);

	// Echo the text.
	echo $promo;
}
add_action( 'before_content', 'psf_store_get_header_promotions_text', 10 );


/**
 * Filter markup of defualt review fields.
 * 
 * @param  array $comment_form The default review fields.
 * @return array               The filtered review fields.
 *
 * @since store_test 1.0.0
 */
function psf_store_product_review_comment_form_args( $comment_form ){
	$commenter = wp_get_current_commenter();

	if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
		$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'psf-store' ) . '</label><select name="rating" id="rating" aria-required="true" required>
			<option value="">' . esc_html__( 'Rate&hellip;', 'psf-store' ) . '</option>
			<option value="5">' . esc_html__( 'Perfect', 'psf-store' ) . '</option>
			<option value="4">' . esc_html__( 'Good', 'psf-store' ) . '</option>
			<option value="3">' . esc_html__( 'Average', 'psf-store' ) . '</option>
			<option value="2">' . esc_html__( 'Not that bad', 'psf-store' ) . '</option>
			<option value="1">' . esc_html__( 'Very poor', 'psf-store' ) . '</option>
		</select></div>';
	}
	$comment_form['comment_field'] .= '<div class="comment-form-comment form-group"><label for="comment">' . esc_html__( 'Your review', 'psf-store' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true" required></textarea></div>';
	$comment_form['fields']['author'] = '<div class="comment-form-author form-group">' . '<label for="author">' . esc_html__( 'Name', 'psf-store' ) . '&nbsp;<span class="required">*</span></label> ' . '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></div>';
	$comment_form['fields']['email'] = '<div class="comment-form-email form-group"><label for="email">' . esc_html__( 'Email', 'psf-store' ) . '&nbsp;<span class="required">*</span></label> ' . '<input id="email" class="form-control" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></div>';

	return $comment_form;
}
add_filter( 'woocommerce_product_review_comment_form_args', 'psf_store_product_review_comment_form_args' );

/**
 * Filter markup of defualt comment fields.
 * 
 * @param  array $fields The default comment fields.
 * @return array         The filtered comment fields.
 *
 * @since store_test 1.0.0
 */
function psf_store_comment_form_default_fields( $fields ) {
	$commenter     = wp_get_current_commenter();
    $user          = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';
	$req           = get_option( 'require_name_email' );
    $aria_req      = ( $req ? " aria-required='true'" : '' );
    $html_req      = ( $req ? " required='required'" : '' );
	$fields        =  array(
		'comment_field' => '<div class="comment-form-comment form-group"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true" class="form-control" cols="45" rows="8"></textarea></div>',
		'author' => '<div class="comment-form-author form-group"><label for="author">' . __( 'Name', 'psf-store' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
		'email' => '<div class="comment-form-email form-group"><label for="email">' . __( 'Email', 'psf-store' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
		'url' => '<div class="comment-form-url form-group"><label for="url">' . __( 'Website', 'psf-store' ) . '</label>' . '<input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
	);

	return $fields;
}
add_filter( 'comment_form_default_fields', 'psf_store_comment_form_default_fields' );

/**
 * Filter the comment form default arguments.
 * 
 * Remove the original comment field because we've added it to the default fields
 * using psf_store_comment_form_default_fields(). If we don't do this, the comment
 * field will appear twice.
 *
 * @param  array $defaults The default comment form arguments.
 * @return array           the filtered comment form arguments.
 *
 * @since store_test 1.0.0
 */
function psf_store_comment_form_defaults( $defaults ) {
    $req = get_option( 'require_name_email' );
    $required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );

    $defaults[ 'comment_notes_before' ] = '<p class="comment-notes small text-muted"><span id="email-notes">' . __( 'Your email address will not be published.' ) . '</span>'. ( $req ? $required_text : '' ) . '</p>';

    if ( isset( $defaults[ 'comment_field' ] ) ) {	
        $defaults[ 'comment_field' ] = '';
    }

	$defaults[ 'class_submit' ]  = 'btn btn-primary';
	$defaults[ 'submit_field' ]  = '<div class="form-submit mb-3">%1$s %2$s</div>';

    return $defaults;
}
add_filter( 'comment_form_defaults', 'psf_store_comment_form_defaults', 10, 1 );


// Widget Areas
/**
 * Filter HTML before the widget list
 * 
 * @return string Filtered HTML before widget list
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_before_widget_product_list() {
	$before_list = '<ul class="product_list_widget list-unstyled carousel-wrap px-sm-5 px-md-3 px-lg-0">';

	return $before_list;
}
add_filter( 'woocommerce_before_widget_product_list', 'psf_store_filter_before_widget_product_list', 10 );

/**
 * Filter arguments for widgets in Recently Viewed Items sidebar.
 * 
 * @param  array $widget_tags Array or string of arguments for the sidebar being registered.
 * @return array              Filtered arguments of the sidebar being registered.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_single_product_2_widget_tags( $widget_tags ) {
	$widget_tags['before_title'] = '<h2 class="py-3 text-center">';

	return $widget_tags;
}
add_filter( 'psf_store_single-product-2_widget_tags', 'psf_store_filter_single_product_2_widget_tags', 10 );

/**
 * Filter classes for Footer widget regions. Created dynamically. 
 * Filter widget number refers to specified region.
 * 
 * @param  string $classes widget classes.
 * @return string          filtered widget classes.
 *
 * @since store_test 1.0.0
 *
function psf_store_filter_footer_widget_class( $classes ) {
	$classes = 'col col-md-6';

	return $classes;
}
add_filter( 'psf_store_footer_widget_4_class', 'psf_store_filter_footer_widget_class', 10 );
*/

/**
 * Filter arguments for above footer and single product sidebar.
 * 
 * @param  array $widget_tags Array or string of arguments for the sidebar being registered.
 * @return array              Filtered arguments of the sidebar being registered.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_above_footer_widget_tags( $widget_tags ) {
	$widget_tags['before_widget'] = '<div id="%1$s" class="col-sm small px-sm-5 widget--col widget %2$s">';
	$widget_tags['before_title'] = '<h2 class="widget-title text-center h4">';

	return $widget_tags;
}
add_filter( 'psf_store_footer-top_widget_tags', 'psf_store_filter_above_footer_widget_tags', 10 );
add_filter( 'psf_store_single-product_widget_tags', 'psf_store_filter_above_footer_widget_tags', 10 );

/**
 * Filter arguments for the product archive sidebar.
 * 
 * @param  array $widget_tags Array or string of arguments for the sidebar being registered.
 * @return array              Filtered arguments of the sidebar being registered.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_archive_product_widget_tags( $widget_tags ) {
	$widget_tags['before_widget'] = '<div id="%1$s" class="collapse filter-collapse %2$s" data-parent="#accordion-filter"><div class="py-5 accordion-filter__content-inner">';
	$widget_tags['before_title'] = '<h2 class="sr-only">';
	$widget_tags['after_widget'] = '</div></div>';

	return $widget_tags;
}
add_filter( 'psf_store_archive-product_widget_tags', 'psf_store_filter_archive_product_widget_tags', 10 );


// Pages
/**
 * Filter title for pages
 * 
 * @return string Filtered page title classes.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_page_title( $classes ) {
	if( is_page_template( 'page-templates/full--sidebar-half.php' ) ) {
		$classes = 'entry-title mb-0 h4 text-uppercase';
	}

	return $classes;
}
add_filter( 'psf_store_page_title', 'psf_store_filter_page_title' );


// Inputs
/**
 * Filter the classes for quantity input label
 * 
 * @param  string $classes Classes applied to the input label.
 * @return string          Flitered classes applied to the input label.
 *
 * @since store_test 1.0.0
 */
function psf_store_filter_quantity_label( $classes ) {
	if( is_cart() ) {
		$classes = 'sr-only';
	}

	return $classes;
}
add_filter( 'psf_store_quantity_label', 'psf_store_filter_quantity_label' );