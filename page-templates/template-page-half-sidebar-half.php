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

	<div class="row">
		<div id="primary" class="content-area col-sm-6 border-right my-5 pr-5">
			<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile;
			?>

			</main>
		</div>

		<?php get_sidebar( 'contact' ); ?>

	</div>

<?php
get_footer();