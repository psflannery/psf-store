<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Store_test
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row mt-5">

		<?php psf_store_post_thumbnail(); ?>

		<header class="entry-header py-5 col-md-4 offset-md-1">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title mb-4 display-4">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title mb-4 display-4"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) : ?>
				<div class="standfirst small text-muted border-top py-3">

					<?php the_excerpt(); ?>

				</div>
				<div class="entry-meta small text-muted border-top py-3">
					<?php
					psf_store_posted_on();
					psf_store_posted_by();
					psf_store_entry_footer();
					?>
				</div>
			<?php endif; ?>
		</header>
		<div class="entry-content col-md-6 py-5">
			<?php
			the_content( sprintf(
				wp_kses(
					// translators: %s: Name of current post. Only visible to screen readers
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'psf-store' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'psf-store' ),
				'after'  => '</div>',
			) );
			?>
		</div>
	</div>
</article>
