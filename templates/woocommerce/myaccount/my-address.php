<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$addressWrapperClass = 'columns-1';

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ){ 
	$addressWrapperClass = 'columns-lg-2 columns-1';
}

?>
<div class='grid columns-1 gap-2'>
	<p class='alert alert-primary-dk'>
		<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</p>
	<div class="grid <?= $addressWrapperClass ?>">

		<?php 
		

		foreach ( $get_addresses as $name => $address_title ) : ?>
			<?php
				$address = wc_get_account_formatted_address( $name );
			?>

			<div class="woocommerce-address grid columns-1 gap-1">

				<header class="woocommerce-Address-title title grid columns-1 gap-1">
					
					<h2 class='fw-8 fs-24 text-accent-dk m-0'><?php echo esc_html( $address_title ); ?></h2>

					<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit">
						<?php
							printf(
								/* translators: %s: Address title */
								$address ? esc_html__( 'Edit %s', 'woocommerce' ) : esc_html__( 'Add %s', 'woocommerce' ),
								esc_html( $address_title )
							);
						?>
					</a>

				</header>
				<address>
					<?php
						echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );

						/**
						* Used to output content after core address fields.
						*
						* @param string $name Address type.
						* @since 8.7.0
						*/
						do_action( 'woocommerce_my_account_after_my_address', $name );
					?>
				</address>
			</div>

		<?php endforeach; ?>
	</div>
</div>