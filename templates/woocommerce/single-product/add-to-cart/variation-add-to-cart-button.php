<?php
/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="woocommerce-variation-add-to-cart variations_button d-flex gap-2">

	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	$range = [
		'max' => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'min' => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product )
	];

	printf(
		<<<HTML
			<pockets-fancy-input
				name='quantity'
				:min='%s'
				:max='%s'					
				:value='%d'
			>
			</pockets-fancy-input>
		HTML,
		$range['min'],
		$range['max'],
		$range['min']
	);
	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

	<button 
		type="submit" 
		class="text-uppercase rounded-0 align-items-center d-flex gap-1 btn btn-outline-confirm single_add_to_cart_button <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
		:disabled='!$pockets.woo.variation_form.selected'
	>
		<i class='fa fa-shopping-cart'></i>
		<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
	</button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
	
</div>
