<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 * @see     https://bjornjohansen.no/wordpress-menu-cache
 */

?>

	</div><!-- #content -->

	<?php get_sidebar( 'above-footer' ); ?>

	<footer id="colophon" class="site-footer bg-light border-top">
		<div class="container">

			<?php psf_store_footer_widgets(); ?>

		</div>

		<?php if ( function_exists( 'jetpack_social_menu' ) && has_nav_menu( 'jetpack-social-menu' ) ) : ?>

			<div class="container">
				<div class="border-top py-4">

					<?php jetpack_social_menu(); ?>

				</div>
			</div>

		<?php endif; ?>

		<div class="container">
			<div class="border-top pt-3">
				<div class="site-info row">
					<div class="col small text-muted d-flex justify-content-between">
						<p>
						<?php 
							esc_html_e( '&copy;', 'psf-store' );
							echo date(' Y ');
							bloginfo( 'name' ); 
						?>
						</p>

						<?php 
						$footer_text = get_theme_mod( 'psf_store_footer_text' );

						if ( '' != $footer_text ) : 
						?>

						<p id="footer-text"><?php echo $footer_text ?></p>

						<?php
						endif; ?>

					</div>
				</div>
			</div>
		</div>
	</footer>

	<?php do_action( 'psf_store_after_footer' ); ?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
