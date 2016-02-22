<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
<div class="product-inner">
	<div class="product-thumb">
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<div class="gorup-button">
		<?php
		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );

		/**
		 * kt_function_shop_loop_item_quickview hook
         * 
		 * @hooked kt_add_quick_view_button - 5
		 */
		do_action( 'kt_function_shop_loop_item_quickview' );
		
		/**
		 * kt_function_shop_loop_item_compare hook
         * 
		 * @hooked create_function( '', 'echo do_shortcode( "[yith_compare_button]" );' ) - 5
		 */
		do_action( 'kt_function_shop_loop_item_compare' );
		
		?>
		</div>
	</div>
	<div class="product-info">

		<?php
		/**
		 * woocommerce_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		/**
		 * kt_function_shop_loop_item_wishlist hook
         * 
		 * @hooked create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ) - 5
		 */
		do_action( 'kt_function_shop_loop_item_wishlist' );
		?>
	</div>
</div>