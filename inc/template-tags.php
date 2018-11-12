<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Store_test
 */

if ( ! function_exists( 'psf_store_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function psf_store_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		$posted_on = sprintf(
			// translators: %s: post date.
			esc_html_x( 'Posted on %s', 'post date', 'psf-store' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'psf_store_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function psf_store_posted_by() {
		$byline = sprintf(
			// translators: %s: post author.
			esc_html_x( 'by %s', 'post author', 'psf-store' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'psf_store_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function psf_store_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			// translators: used between list items, there is a space after the comma
			$categories_list = get_the_category_list( esc_html__( ', ', 'psf-store' ) );
			if ( $categories_list ) {
				// translators: 1: list of categories.
				printf( '<span class="cat-links d-block">' . esc_html__( 'Posted in %1$s', 'psf-store' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			// translators: used between list items, there is a space after the comma
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'psf-store' ) );
			if ( $tags_list ) {
				// translators: 1: list of tags.
				printf( '<span class="tags-links d-block">' . esc_html__( 'Tagged %1$s', 'psf-store' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						// translators: %s: post title
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'psf-store' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					// translators: %s: Name of current post. Only visible to screen readers
					__( 'Edit <span class="screen-reader-text">%s</span>', 'psf-store' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'psf_store_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function psf_store_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif;
	}
endif;

if ( ! function_exists( 'psf_store_address' ) ) :
	/**
	 * Store address.
	 *
	 * @param  array  $args Query string of address attributes.
	 * @param  bool   $echo Echo the address if true, return if false.
	 *
	 * @return string       HTML for address.
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_address( $args = '', $echo = true, $before = '', $after = '' ) {
		$defaults = array(
			'title'     => '',
			'address'   => array(
				'streetAddress'   => get_theme_mod( 'psf_store_address_1' ),
				'addressLocality' => get_theme_mod( 'psf_store_address_2' ),
				'addressRegion'   => get_theme_mod( 'psf_store_address_city' ),
				'postalCode'      => get_theme_mod( 'psf_store_address_postcode' ),
			),
			//'phone'     => get_theme_mod( 'psf_store_address_phone' ),
			//'email'     => get_theme_mod( 'psf_store_address_email' ),
		);
		$atts = wp_parse_args( $args, $defaults );

		// Bail if no address.
		if ( '' == $atts ) {
			return;
		}

		do_action( 'psf_store_before_address' );

		$address = '';

		//$address .= '<div itemscope itemtype="http://schema.org/LocalBusiness">';

		if ( '' != $atts['title'] ) {
			$address .= sprintf(
				'<div class="confit-title" itemprop="name">%1$s</div>',
				esc_html( $atts['title'] )
			);
		}

		if ( '' != $atts['address'] ) {
			$line = '';

			foreach ( (array) $atts['address'] as $name => $value ) {
				if ( ! empty( $value ) ) {
					$line .= '<span class="d-block" itemprop="' . $name . '">' . esc_html( $value ) . '</span>';
				}
			};

			$address .= sprintf(
				'<div class="confit-address" itemscope itemtype="http://schema.org/PostalAddress" itemprop="address">%1$s</div>',
				$line
			);
		}
		/*
		if ( '' != $atts['phone'] ) {
			$is_mobile = defined( 'JETPACK__VERSION' ) ? jetpack_is_mobile() : wp_is_mobile();

			if ( $is_mobile ) {
				$address .= '<div class="confit-phone"><span itemprop="telephone"><a href="' . esc_url( 'tel:' . $atts['phone'] ) . '">' . esc_html( $atts['phone'] ) . "</a></span></div>";
			}
			else {
				$address .= '<div class="confit-phone"><span itemprop="telephone" content="+18005551234">' . esc_html( $atts['phone'] ) . '</span></div>';
			}
		}

		if ( is_email( trim( $atts['email'] ) ) ) {
			$address .= sprintf(
				'<div class="confit-email"><a href="mailto:%1$s" itemprop="email">%1$s</a></div>',
				antispambot( $atts['email'] )
			);
		}*/

		//$address .= '</div>';

		do_action( 'psf_store__after_address' );

		$address = $before . $address . $after;

		if ( $echo ) {
			echo $address;
		} else {
			return $address; 
		}
	}
	add_shortcode( 'store-address', 'psf_store_address' );
endif;

if ( ! function_exists( 'psf_store_phone_number' ) ) :
	/**
	 * Store phone number
	 * 
	 * @param  string  $args Query string of phone number attributes.
	 * @param  boolean $echo Echo the phone number if true, return if false.
	 * @return string        HTML for phone number.
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_phone_number( $args = '', $echo = true ) {
		$defaults = array(
			'title' => '',
			'phone' => get_theme_mod( 'psf_store_address_phone' ),
		);
		$atts = wp_parse_args( $args, $defaults );

		// Bail if no phone number.
		if ( '' == $atts ) {
			return;
		}

		do_action( 'psf_store_before_phone_number' );

		$phone = '';

		if ( '' != $atts['title'] ) {
			$phone .= sprintf(
				'<div class="confit-title" itemprop="name">%1$s</div>',
				esc_html( $atts['title'] )
			);
		}

		if ( '' != $atts['phone'] ) {
			$is_mobile = defined( 'JETPACK__VERSION' ) ? jetpack_is_mobile() : wp_is_mobile();

			if ( $is_mobile ) {
				$phone .= '<div class="confit-phone"><span class="text-muted pr-2 small">' . esc_html__( 'Phone:', 'psf-store' ) .'</span><span itemprop="telephone"><a href="' . esc_url( 'tel:' . $atts['phone'] ) . '">' . esc_html( $atts['phone'] ) . "</a></span></div>";
			}
			else {
				$phone .= '<div class="confit-phone"><span class="text-muted pr-2 small">' . esc_html__( 'Phone:', 'psf-store' ) .'</span><span itemprop="telephone" content="+18005551234">' . esc_html( $atts['phone'] ) . '</span></div>';
			}
		}

		do_action( 'psf_store_after_phone_number' );

		if ( $echo ) {
			echo $phone;
		} else {
			return $phone; 
		}
	}
	add_shortcode( 'store-phone', 'psf_store_phone_number' );
endif;

if ( ! function_exists( 'psf_store_email_address' ) ) :
	/**
	 * Store email address
	 * 
	 * @param  string  $args Query string of email address attributes.
	 * @param  boolean $echo Echo the email address if true, return if false.
	 * @return string        HTML for email address.
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_email_address( $args = '', $echo = true ) {
		$defaults = array(
			'title' => '',
			'email' => get_theme_mod( 'psf_store_address_email' ),
		);
		$atts = wp_parse_args( $args, $defaults );

		// Bail if no email address.
		if ( '' == $atts ) {
			return;
		}

		do_action( 'psf_store_before_email_address' );

		$email = '';

		if ( '' != $atts['title'] ) {
			$email .= sprintf(
				'<div class="confit-title" itemprop="name">%1$s</div>',
				esc_html( $atts['title'] )
			);
		}

		if ( is_email( trim( $atts['email'] ) ) ) {
			$email .= sprintf(
				'<div class="confit-email"><span class="text-muted pr-2 small">' . esc_html__( 'Email:', 'psf-store' ) .'</span><a href="mailto:%1$s" itemprop="email">%1$s</a></div>',
				antispambot( $atts['email'] )
			);
		}

		do_action( 'psf_store_after_email_address' );

		if ( $echo ) {
			echo $email;
		} else {
			return $email; 
		}
	}
	add_shortcode( 'store-email', 'psf_store_email_address' );
endif;

if ( ! function_exists( 'psf_store_contact_details' ) ) :
	/**
	 * Store contact details
	 * 
	 * @param  string  $args Query string of contact details attributes.
	 * @param  boolean $echo Echo the contact details if true, return if false.
	 * @return string        HTML for contact details.
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_contact_details( $args = '', $echo = true ) {
		$defaults = array(
			'title'   => '',
			'address' => psf_store_address( '', false ),
			'phone'   => psf_store_phone_number( '', false ),
			'email'   => psf_store_email_address( '', false ),
		);
		$atts = wp_parse_args( $args, $defaults );

		// Bail if no contact details.
		if ( '' == $atts ) {
			return;
		}

		do_action( 'psf_store_before_contact_details' );

		$contact = '';

		if ( '' != $atts['title'] ) {
			$contact .= sprintf(
				'<div class="confit-title" itemprop="name">%1$s</div>',
				esc_html( $atts['title'] )
			);
		}

		$contact .= '<div itemscope itemtype="http://schema.org/LocalBusiness">';

		if ( '' != $atts['address'] ) {
			$contact .= $atts['address'];
		}

		if ( '' != $atts['phone'] ) {
			$contact .= $atts['phone'];
		}

		if ( '' != $atts['email'] ) {
			$contact .= $atts['email'];
		}

		$contact .= '</div>';

		do_action( 'psf_store_after_contact_details' );

		if ( $echo ) {
			echo $contact;
		} else {
			return $contact; 
		}
	}
	add_shortcode( 'store-contact-details', 'psf_store_contact_details' );
endif;

if ( ! function_exists( 'psf_store_product_search' ) ) :
	/**
	 * Product Search Form
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_product_search() {
		if ( function_exists( 'get_product_search_form' ) ) {
			wc_get_template( 'product-searchform.php', array(
				'button' => false,
			) );
		} else {
			get_search_form();
		}
	}
endif;

if ( ! function_exists( 'psf_store_product_archive_sidebar' ) ) :
	/**
	 * Product archive sidebar
	 * 
	 * @return void
	 *
	 * @since store_test 1.0.0
	 */
	function psf_store_product_archive_sidebar() {
		get_sidebar( 'archive-product' );
	}
endif;
