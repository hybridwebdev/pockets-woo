<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

$product = wc_get_product ( get_queried_object_id() );

if ( ! $product->is_purchasable() ) {
	return;
}

if ( $product->is_in_stock() ) : ?>

	<?php 
		do_action( 'woocommerce_before_add_to_cart_form' ); 
	?>
	
	<form 
		class="d-flex gap-2 loading-container" 
		method="post" 
		@submit.prevent = "(e) => $pockets.woo.cart.addUsingForm(e).then( () => {
			$pockets.toast.success('Item added');
		}).catch(() => $pockets.toast.error('Error adding item') )"
		:loading='$pockets.woo.cart.busy'
	>
		<input 
			name='product_id'
			value='<?php echo esc_attr( $product->get_id() ); ?>'
			type='hidden'
		>

		<?php
			
			do_action( 'woocommerce_before_add_to_cart_button' );
			do_action( 'woocommerce_before_add_to_cart_quantity' );

		printf(
			<<<HTML
				<pockets-fancy-input
					name='quantity'
					:value='1'
				>
				</pockets-fancy-input>
			HTML,
			apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			$product->get_min_purchase_quantity()
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
		
		<button 
			type="submit" 
			value="<?php echo esc_attr( $product->get_id() ); ?>" 
			class="text-uppercase rounded-0 align-items-center d-flex gap-1 btn btn-outline-confirm<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
		>
			<i class='fa fa-shopping-cart'></i>
			<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
		</button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
