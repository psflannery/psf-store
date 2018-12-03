<?php
/**
 * Template Name: Page half, Sidebar half
 *
 * @package Store_test
 *
 * @since store_test 1.0.0
 */

get_header(); 
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main container">
			<div class="row my-5">
				<div class="col-md-6 border-right pr-md-5">

					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'page' );

					endwhile;
					?>

				</div>

				<?php get_sidebar( 'contact' ); ?>

			</div>
		</main>
	</div>

<?php
get_footer();