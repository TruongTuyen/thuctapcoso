<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) === 0 ) {
	return;
}

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

$loop = 'false'; 
$kt_upsell_products_title = kt_option('kt_upsell_products_title','You may also like&hellip;');
$kt_upsell_products_columns = kt_option('kt_upsell_products_columns',3);

$item_desktop = $kt_upsell_products_columns;
$item_ipad = $kt_upsell_products_columns - 1;

if ( $products->have_posts() ) : ?>
	<?php
	if( $products->post_count > 1){
		$loop = 'true';
	}
	?>
	<div class="upsells products product-slide">
		<div class="section-title style3">
			<h3><?php echo esc_html( $kt_upsell_products_title ); ?></h3>
		</div>
		<ul class="owl-carousel nav-style5" data-loop="<?php echo esc_attr($loop);?>" data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1,"nav":"false"},"600":{"items":<?php echo esc_attr($item_ipad);?>},"1000":{"items":<?php echo esc_attr($item_desktop);?>}}'>
		<?php while ( $products->have_posts() ) : $products->the_post(); ?>

			<?php wc_get_template_part( 'content', 'up-sells' ); ?>

		<?php endwhile; // end of the loop. ?>
		</ul>
	</div>
<?php endif;

wp_reset_postdata();
