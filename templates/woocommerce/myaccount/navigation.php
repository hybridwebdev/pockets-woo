<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="my-account-navigation col-12" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
	<ul class='list-unstyled p-0 m-0 grid columns-1 columns-sm-3 columns-lg-1 gap-0'>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : 
			$class = wc_is_current_account_menu_item( $endpoint ) ? "btn-grey-800" : "btn-grey-700";
			if ( $endpoint == 'dashboard' && ! WC()->query->get_current_endpoint() ) {
				$class='btn-grey-800';
			}
		?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a 
					href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" 
					<?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>
					class='btn p-1 col-12 text-center px-2 <?= $class ?>'
				>
					<?php echo esc_html( $label ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
