<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form 

	v-pockets-woo-variation-form-init
	
	v-pockets-woo-form-handler='{
		action: "cart.addItem",
		error: "Item could not be added.",
		success: "Item added to cart."
	}'
	 
	:loading='$pockets.woo.cart.busy'

	class="variations_form cart loading-container" 

	action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" 
	method="post" 
	enctype='multipart/form-data' 
	data-product_id="<?php echo absint( $product->get_id() ); ?>" 
	data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>"

>
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<div class="variations grid columns-1 gap-1" role="presentation">
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<label class='grid-info'>
					<span class="label">
						<?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?>
					</span>
					<div class="value">
						<?php
							wc_dropdown_variation_attribute_options(
								array(
									'class' => 'form-control rounded-0',
									'options'   => $options,
									'attribute' => $attribute_name,
									'product'   => $product,
								)
							);
							
						?>
					</div>
				</label>
				<?php 
					/**
						* Filters the reset variation button.
						*
						* @since 2.5.0
						*
						* @param string  $button The reset variation button HTML.
					*/
					echo end( $attribute_keys ) === $attribute_name 
						? wp_kses_post( 
							apply_filters( 'woocommerce_reset_variations_link', 
								'<a class="px-2 py-half text-white rounded-0 btn btn-danger ms-auto reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'woocommerce' ) . '">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' 
							) 
						) 
						: '';
				?>
			<?php endforeach; ?>
		</div>

		<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>

		<?php do_action( 'woocommerce_after_variations_table' ); ?>

		<div class="single_variation_wrap grid columns-1 gap-1">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
