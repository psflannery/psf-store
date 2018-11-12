<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

if ( ! is_active_sidebar( 'above-footer-1' ) ) {
	return;
}
?>

<aside id="sidebar-above-footer" class="widget-area widget-area--above-footer container">
	<div class="row">
		<div class="col">
			<div class="border-top py-5">
				<div class="row">

					<?php dynamic_sidebar( 'above-footer-1' ); ?>

				</div>
			</div>
		</div>
	</div>
</aside>
