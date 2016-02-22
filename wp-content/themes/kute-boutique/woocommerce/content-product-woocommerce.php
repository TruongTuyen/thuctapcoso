<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product-woocommerce.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
$classes[] = 'product-inner';
?>
<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
<div <?php post_class( $classes ); ?>>
	<div class="product-thumb">
		<a href="<?php the_permalink(); ?>">
            <?php
    			/**
    			 * woocommerce_before_shop_loop_item_title hook
    			 *
    			 * @hooked woocommerce_show_product_loop_sale_flash - 10
    			 * @hooked woocommerce_template_loop_product_thumbnail - 10
    			 */
    			do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>
        </a>
		<div class="gorup-button">
			<div class="wishlist">
                <?php
        			/**
        			 * kt_function_shop_loop_item_wishlist hook
                     * 
        			 * @hooked create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ) - 5
        			 */
        			do_action( 'kt_function_shop_loop_item_wishlist' );
                ?>
            </div>
            <?php
    			/**
    			 * kt_function_shop_loop_item_compare hook
                 * 
    			 * @hooked create_function( '', 'echo do_shortcode( "[yith_compare_button]" );' ) - 5
    			 */
    			do_action( 'kt_function_shop_loop_item_compare' );
            ?>
            <?php
    			/**
    			 * kt_function_shop_loop_item_quickview hook
                 * 
    			 * @hooked kt_add_quick_view_button - 5
    			 */
    			do_action( 'kt_function_shop_loop_item_quickview' );
            ?>
		</div>
	</div>
	<div class="product-info">
		<h3 class="product-name">
            <a href="<?php the_permalink(); ?>">
                <?php 
                    /**
        			 * woocommerce_shop_loop_item_title hook
        			 *
        			 * @hooked woocommerce_template_loop_product_title - 10
        			 */
        			do_action( 'woocommerce_shop_loop_item_title' );
                ?>
            </a>
        </h3>
        <?php 
            /**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );

    		/**
    		 * woocommerce_after_shop_loop_item hook
    		 *
    		 * @hooked woocommerce_template_loop_add_to_cart - 10
    		 */
    		do_action( 'woocommerce_after_shop_loop_item' );
    	?>
	</div>
</div>