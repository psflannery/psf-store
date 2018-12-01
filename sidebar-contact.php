<?php
/**
 * The sidebar containing the contact page widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

if ( ! is_active_sidebar( 'contact' ) ) {
	return;
}
?>

<aside id="sidebar-contact" class="widget-area widget-area--contact col-sm-6 my-5 pl-5">

	<?php dynamic_sidebar( 'contact' ); ?>

</aside>
