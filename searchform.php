<?php
/**
 * Template for displaying search forms
 *
 * @package Store_test
 */

$classes = 'input-group mb-3 mb-sm-0';
$classes = apply_filters( 'psf_search_form_class', $classes );
?>

<form class="<?php echo $classes; ?>" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
	    <input class="form-control" type="search" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'psf-store' ); ?>" aria-label="<?php echo esc_attr_x( 'Search', 'label', 'psf-store' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	    <div class="input-group-append">
	    	<button class="btn btn-primary" type="submit">
	    		<?php echo _x( 'Search', 'submit button', 'psf-store' ); ?>
	    	</button>
		</div>
	</div>
</form>
