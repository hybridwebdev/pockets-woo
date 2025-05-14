<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
$renderer = new class {

	public function quantity( $product ) {

		ob_start();

		if ( ! $product->is_purchasable() || $product->has_options() || ! $product->is_in_stock() ) {
			woocommerce_template_loop_add_to_cart();
			return ob_get_clean();
		}

		if ( $product->is_sold_individually() ) {

			printf(
				<<<'HTML'
					<label class='d-flex align-items-center gap-2' role='button'>
						<input 
							class='wc-grouped-product-add-to-cart-checkbox m-0 form-check-input fs-26 rounded-0'
							id='quantity-%1$s'
							name='quantity[%1$s]' 
							type='checkbox'
							value='1'
						/>
						Add Item
					</label>
				HTML,
				esc_attr( $product->get_id() )
			);

			printf(
				<<<'HTML'
					<label 
						class='screen-reader-text'
						for='quantity-%1$s'
					>
						%2$s
					</label>
				HTML,
				esc_attr( $product->get_id() ),
				esc_html__( 'Buy one of this item', 'woocommerce' )
			);

			return ob_get_clean();
			
		}

		do_action( 'woocommerce_before_add_to_cart_quantity' );

			$id = $product->get_id();

			printf(
				<<<'HTML'
					<pockets-fancy-input
						name='quantity[%1$s]'
						:min='%2$s'
						:max='%3$s'					
						:value='%4$s'
					></pockets-fancy-input>
				HTML,
				$id,
				apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
				apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				isset( $_POST['quantity'][ $id ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $id ] ) ) ) : 1
			);

		do_action( 'woocommerce_after_add_to_cart_quantity' );

		return ob_get_clean();

	}

	public function label( $product ) {

		$a = fn() => sprintf(
			<<<HTML
				<a href='%s' class='fs-20 text-primary-dk fw-8'>%s</a>
			HTML,
			esc_url( apply_filters( 'woocommerce_grouped_product_list_link', $product->get_permalink(), $product->get_id() ) ),
			$product->get_name() 
		);

		return sprintf(
			<<<HTML
				<label for='product-%s'>
				%s
				</label>
			HTML,
			esc_attr( $product->get_id() ),
			$product->is_visible()
				? $a()
				: $product->get_name()
		);
		
	}

	public function price( $product ) {
		return sprintf(
			"<label for='quantity-%s'>%s%s</label>",
			esc_attr( $product->get_id() ),
			$product->get_price_html(), 
			wc_get_stock_html( $product )
		);
	}

};

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' ); 

$quantites_required      = false;
$previous_post           = $post;
$grouped_product_columns = apply_filters(
	'woocommerce_grouped_product_columns',
	[
		'label',
		'quantity',
		'price',
	],
	$product
);

$show_add_to_cart_button = false;
 
$formAction = esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) );

?>
<form 
	class="cart grouped_form grid columns-1 gap-2 loading-container" 
	action="<?php echo $formAction ?>" 
	method="post" 
	enctype='multipart/form-data'
	v-pockets-woo-form-handler='{
		action: "cart.add.grouped",
		success: "Item added to cart."
	}'
	:loading='$pockets.woo.cart.busy'
>
	<div class="woocommerce-grouped-product-list-table">
		<?php

		do_action( 'woocommerce_grouped_product_list_before', $grouped_product_columns, $quantites_required, $product );

		foreach ( $grouped_products as $grouped_product_child ) {

			$post_object        = get_post( $grouped_product_child->get_id() );
			$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
			$post               = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );

			if ( $grouped_product_child->is_in_stock() ) {
				$show_add_to_cart_button = true;
			}

			printf(
				<<<HTML
					<div id='product-%s' class="woocommerce-grouped-product-list-item %s">
				HTML,
				esc_attr( $grouped_product_child->get_id() ),
				esc_attr( implode( ' ', wc_get_product_class( '', $grouped_product_child ) ) )
			);

				foreach ( $grouped_product_columns as $column_id ) {

					do_action( 
						hook_name: sprintf( 'woocommerce_grouped_product_list_before_%s', $column_id ), 
						arg: $grouped_product_child 
					);

					$value = match ( $column_id ) {
						'quantity' => $renderer->quantity( $grouped_product_child ),
						'label'    => $renderer->label( $grouped_product_child ),
						'price'    => $renderer->price( $grouped_product_child ),
						default    => '',
					};

					printf(
						<<<HTML
							<div class='woocommerce-grouped-product-list-item__%s'>
							%s
							</div>
						HTML,
						esc_attr( $column_id ),
						apply_filters( 
							sprintf( 'woocommerce_grouped_product_list_column_%s', $column_id ), 
							$value, 
							$grouped_product_child 
						)
					);

					do_action( 
						hook_name: sprintf( 'woocommerce_grouped_product_list_after_%s', $column_id ), 
						arg: $grouped_product_child 
					);

				}

			printf(
				<<<HTML
					</div>
				HTML
			);

		}

		$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

		setup_postdata( $post );

		do_action( 'woocommerce_grouped_product_list_after', $grouped_product_columns, $quantites_required, $product );
		?>
	</div>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo esc_attr( $product->get_id() ); ?>" />
	
	<div class='d-flex'>
		<?php if ( $quantites_required && $show_add_to_cart_button ) {  
		
			do_action( 'woocommerce_before_add_to_cart_button' ); 
	
			printf(
				<<<HTML
					<button
						type='submit'
						class='single_add_to_cart_button btn btn-outline-confirm %s text-uppercase d-flex align-items-center gap-1 justify-content-center ms-auto px-2 p-1'
					>
					<i class='fa fa-shopping-cart'></i>
					%s
					</button>
				HTML,
				esc_attr( 
					wc_wp_theme_get_element_class_name( 'button' ) 
						? ' ' . wc_wp_theme_get_element_class_name( 'button' ) 
						: '' 
				),
				esc_html( $product->single_add_to_cart_text() )
			);
		
			do_action( 'woocommerce_after_add_to_cart_button' ); 
		
		} ?>
	</div>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
