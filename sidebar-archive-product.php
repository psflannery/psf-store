<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_test
 */

if ( ! is_active_sidebar( 'archive-product-1' ) ) {
	return;
}
?>

<aside id="filter" class="sidebar sidebar-filter widget-area">
	<div class="accordion-filter py-3 mb-3" id="accordion-filter">
		
		<?php
			// https://wordpress.stackexchange.com/questions/170619/how-to-retrive-widget-title-data
			// https://stackoverflow.com/questions/33229238/woocommerce-check-if-filtering-products
			// https://www.skyverge.com/blog/overriddin-woocommerce-widgets/	
			$sidebar_id = 'archive-product-1';
			$sidebars_widgets = wp_get_sidebars_widgets();
			$widget_ids = $sidebars_widgets[$sidebar_id];

			$count = 0;

			echo '<div class="btn-group d-flex justify-content-center" role="group" aria-label="Product Filters">';
			
			foreach( $widget_ids as $id ) {
				$wdgtvar = 'widget_' . _get_widget_id_base( $id );
				$idvar = _get_widget_id_base( $id );
				$instance = get_option( $wdgtvar );
				$idbs = str_replace( $idvar . '-', '', $id );

				$maybe_true = $count == 0 ? 'true' : 'false';
				
				echo '<button class="btn btn-outline-secondary nav-link d-flex align-items-center" type="button" data-toggle="collapse" data-target="#'. $id .'" aria-expanded="false" aria-controls="'. $id .'">' . $instance[$idbs]['title'] . psf_store_get_svg( array( 'icon' => 'arrow-right' ) ) . '</button>';

				$count ++;
			}

			echo '</div>';
		?>

		<div class="accordion-filter__content" id="accordion-filter-content">

			<?php dynamic_sidebar( 'archive-product-1' ); ?>

		</div>
	</div>
</aside>