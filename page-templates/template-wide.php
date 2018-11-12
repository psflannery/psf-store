<?php
/**
 * Template Name: Page Wide
 *
 * @package Store_test
 *
 * @since store_test 1.0.0
 */

get_header(); 
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main pb-5 my-5">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile;
		?>

		</main>
	</div>

<?php
get_footer();