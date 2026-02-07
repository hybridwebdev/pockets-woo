<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
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

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<pockets-app-guard>

	<div class="woocommerce-form-coupon-toggle">
		<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'woocommerce' ) . ' <a target="self" href="#" class="showcoupon ms-auto btn btn-accent-dk">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
	</div>

	<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">
		
		<div class='grid columns-1 gap-1'>
		
			<p>
				<?php esc_html_e( 'If you have a coupon code, please apply it below.', 'woocommerce' ); ?>
			</p>

			<div class='d-flex gap-1'>
				<label for="coupon_code" class="screen-reader-text">
					<?php esc_html_e( 'Coupon:', 'woocommerce' ); ?>
				</label>
				<div class='flex-grow-1'>
					<input type="text" name="coupon_code" class="form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
				</div>
				<button type="submit" class="btn btn-outline-confirm <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
			</div>
		</div>

	</form>

</pockets-app-guard>
