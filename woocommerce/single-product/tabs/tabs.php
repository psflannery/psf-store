<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

$count = 0;

// start collapse
if ( ! empty( $tabs ) ) : ?>

	<div id="accordion-details" class="accordion woocommerce-tabs wc-tabs-wrapper">
		<?php 
			foreach ( $tabs as $key => $tab ) : 
				
				$maybe_show = $tab['title'] == 'Description' ? 'show' : '';
				$maybe_true = $count == 0 ? 'true' : 'false';
		?>

		<div class="card border-0">
			<div class="card-header border-top small px-0 text-muted text-uppercase d-flex justify-content-between" id="heading-<?php echo $count; ?>" data-toggle="collapse" data-target="#collapse-<?php echo $count; ?>" aria-expanded="<?php echo $maybe_true ?>" aria-controls="collapse-<?php echo $count; ?>">
				
				<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>

				<?php echo psf_store_get_svg( array( 'icon' => 'arrow-right' ) ); ?>

			</div>
			<div id="collapse-<?php echo $count; ?>" class="collapse <?php echo $maybe_show; ?>" aria-labelledby="heading-<?php echo $count; ?>" data-parent="#accordion-details">
				<div class="card-body px-0 pt-2 small">

					<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>

				</div>
			</div>
		</div>

		<?php
			$count ++;
			endforeach;
		?>
	</div>

<?php endif; ?>
