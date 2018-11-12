<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Store_test
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main mb-5">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				do_action( 'before-comments' );

				comments_template();

				do_action( 'after-comments' );
			endif;

		endwhile;
		?>

		</main>
	</div>

<?php
//get_sidebar();
get_footer();
