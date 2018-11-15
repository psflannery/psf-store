<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

?>

	</div><!-- #content -->

	<?php get_sidebar( 'above-footer' ); ?>

	<footer id="colophon" class="site-footer container">
		<div class="row">
			<div class="col">
				<div class="border-top">

					<?php psf_store_footer_widgets(); ?>

				</div>
			</div>
		</div>
		<div class="site-info row">
			<div class="col-12">
				<div class="small border-top w-100 pt-3 text-muted d-flex justify-content-between">
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
	</footer>

	<?php do_action( 'psf_store_after_footer' ); ?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
