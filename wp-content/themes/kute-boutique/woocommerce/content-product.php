<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
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



// Custom columns
$kt_woo_grid_column = kt_option('kt_woo_grid_column',3);
$kt_woo_ipad_grid_column = kt_option('kt_woo_ipad_grid_column',2);
$kt_woo_mobile_grid_column = kt_option('kt_woo_mobile_grid_column',1);
$kt_woo_product_style = kt_option('kt_woo_product_style',1);

// SETTING DEMO
if( isset($_GET['columns']) && in_array($_GET['columns'],array(2,3,4))){
	$kt_woo_grid_column = $_GET['columns'];
}
if( isset($_GET['tablet_columns']) && in_array($_GET['tablet_columns'],array(2,3,4))){
	$kt_woo_ipad_grid_column = $_GET['tablet_columns'];
}
if( isset($_GET['mobile_columns']) && in_array($_GET['mobile_columns'],array(2,3,4))){
	$kt_woo_mobile_grid_column = $_GET['mobile_columns'];
}

if( isset($_GET['style']) && in_array($_GET['style'],array(1,2,3,4,5))){
	$kt_woo_product_style = $_GET['style'];
}
// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $kt_woo_grid_column || 1 == $kt_woo_grid_column ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $kt_woo_grid_column) {
	$classes[] = 'last';
}

$bootstrapColumn = round( 12 / $kt_woo_grid_column );
$kt_woo_shop_layout = kt_option('kt_woo_shop_layout','left');
$kt_woo_flash_style = kt_option('kt_woo_flash_style','flash1');


$shop_display_mode = 'grid';
if( isset($_SESSION['shop_display_mode'])){
	$shop_display_mode = $_SESSION['shop_display_mode'];
}
$classes[] = 'product-item';
// Flash icon style
$classes[] = $kt_woo_flash_style;
$classes[] = 'style'.$kt_woo_product_style;

if( $shop_display_mode == "grid"){
	// Set columns
    $boostrap_columns_destop = round( 12 / $kt_woo_grid_column );

    $classes[] = 'col-md-'.$boostrap_columns_destop;
    
    $kt_woo_ipad_grid_column = round( 12 / $kt_woo_ipad_grid_column );
    $classes[] = 'col-sm-'.$kt_woo_ipad_grid_column;

    $kt_woo_mobile_grid_column = round( 12 / $kt_woo_mobile_grid_column );

    $classes[] = 'col-xs-'.$kt_woo_mobile_grid_column;

}else{
	$classes[] = 'list';
}
$template_style = 'style-'.$kt_woo_product_style;
?>
<li <?php post_class( $classes ); ?>>
	<?php if( $shop_display_mode == "grid"):?>
	<?php wc_get_template_part('content-product', $template_style );?>
	<?php else:?>
	<?php wc_get_template_part('content-product', 'list' );?>
	<?php endif;?>
</li>
