<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="sidebar widget-area col-sm-4 col-md-3 col-lg-2 border-right border-light order-md-1">

	<?php dynamic_sidebar( 'sidebar-1' ); ?>

</aside>
