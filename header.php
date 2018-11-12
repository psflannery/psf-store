<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'before-page' ); ?>

<div id="page" class="site m-lg-2">
	<a class="skip-link sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'psf-store' ); ?></a>

	<?php do_action('before_header'); ?>

	<header id="masthead" class="site-header d-flex flex-column mt-5">
		<div class="navbar navbar-light bg-white flex-row justify-content-start">
			<div class="container">
				<div class="site-branding order-md-2">

					<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-dark" rel="home navbar-brand"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title mb-0 h1"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-dark navbar-brand" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;

					$psf_store_description = get_bloginfo( 'description', 'display' );

					if ( $psf_store_description || is_customize_preview() ) :
						?>
						<p class="site-description small mb-0"><?php echo $psf_store_description; /* WPCS: xss ok. */ ?></p>
					<?php 
					endif;
					?>

				</div>
				<div class="d-flex align-items-center order-md-1 site-header__nav-top-container">

					<?php
					wp_nav_menu( array(
						'theme_location' => 'info',
						'container'      => '',
						'menu_class'     => 'menu-info navbar-nav flex-row small d-none d-md-flex',
					) );

					wp_nav_menu( array(
						'theme_location' => 'customer',
						'container'      => '',
						'menu_id'        => 'customer-menu',
						'menu_class'     => 'navbar-nav flex-row ml-auto',
						'link_before'    => '<span class="sr-only">',
						'link_after'     => '</span>' . psf_store_get_svg( array( 'icon' => 'chain' ) ),
					) );

					if ( function_exists( 'psf_store_woocommerce_header_cart' ) ) {
						echo psf_store_woocommerce_header_cart();
					}
					?>

				</div>
			</div>
		</div>
		<div class="container">
			<div class="product-navigation">
				<div id="offcanvas-navigation" class="navbar navbar-expand-md navbar-light navbar-offcanvas bg-white py-0">
					<nav id="site-navigation" class="site-navigation d-flex flex-column flex-md-row" role="navigation">
						<button class="btn btn-link px-0 py-4 border-0 align-self-end d-md-none" aria-expanded="false" aria-label="Close menu" data-toggle="offcanvas" data-target="#offcanvas-navigation" type="button">

							<?php echo psf_store_get_svg( array( 'icon' => 'close' ) ) ;?>

						</button>

						<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container'      => '',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'navigation-menu navbar-nav text-uppercase'
						) );
						?>

						<div class="menu-mask rounded-bottom"></div>
					</nav>
				</div>
				<div id="product-search" class="product-navigation__search">
					
					<?php psf_store_product_search(); ?>

					<button class="nav-link btn btn-link px-2 border-0 product-navigation__search-btn" type="button" data-toggle="search" data-target="#product-search" aria-expanded="false" aria-controls="product-search">
						<span class="sr-only"><?php esc_html_e( 'Toggle search', 'psf-store' ) ;?></span>
						<?php echo psf_store_get_svg( array( 'icon' => 'search' ) ) ;?>
						<?php echo psf_store_get_svg( array( 'icon' => 'close' ) ) ;?>
					</button>
				</div>
				<button aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_html_e( 'Toggle Menu', 'psf-store' ); ?>" class="navbar-toggler d-md-none hamburger" data-toggle="offcanvas" data-target="#offcanvas-navigation" type="button">
					<span class="hamburger__line mt-0"></span>
					<span class="hamburger__line"></span>
					<span class="hamburger__line mb-0"></span>
				</button>
			</div>
		</div>
	</header>

	<?php 
	/**
	 * Functions hooked in to psf_store_before_content
	 *
	 * @hooked psf_store_get_header_promotions_text - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action('before_content'); ?>

	<div id="content" class="site-content <?php echo apply_filters( 'psf_store_container_class', '' ); ?>">
