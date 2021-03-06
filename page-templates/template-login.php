<?php
/**
 * The template for displaying login pages.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. 
 *
 * Template name: Login
 *
 * @package Store_test
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container">
			<div class="pb-5 my-5 ">

			<?php 
			do_action( 'before-login-page' );

				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

				endwhile;

			do_action( 'after-login-page' );
			?>
		
			</div>
		</main>
	</div>

<?php
get_footer();