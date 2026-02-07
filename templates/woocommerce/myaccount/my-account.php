<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
?>
<div class='d-flex gap-2 gap-lg-6 flex-wrap flex-lg-nowrap my-account'>
	<div class='bg-grey-700 p-0 col-12 col-lg-auto'>
		<?php do_action( 'woocommerce_account_navigation' ); ?>
	</div>
	<div class="my-account-content flex-grow-1">
		<?php
			do_action( 'woocommerce_account_content' );
		?>
	</div>
</div>
