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
		<main id="main" class="site-main container">
			<div class="row pb-5 my-5">
				<div class="col-12">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

				endwhile;
				?>

				</div>
			</div>
		</main>
	</div>
	
<?php
get_footer();