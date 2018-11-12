<?php
/**
 * Template part for displaying slides
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Store_test
 */

?>

<li class="carousel-cell">
	<div class="position-relative">

	<?php 
		the_title('<h2>', '</h2>');
		psf_store_post_thumbnail();
	?>

	</div>
</li>