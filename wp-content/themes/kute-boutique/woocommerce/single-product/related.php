<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) === 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;
$loop = 'false'; 
$kt_related_products_title = kt_option('kt_related_products_title','Related Products');
$kt_related_products_columns = kt_option('kt_related_products_columns',3);

$item_desktop = $kt_related_products_columns;
$item_ipad = $kt_related_products_columns - 1;

if ( $products->have_posts() ) : ?>
	<?php
	if( $products->post_count > 1){
		$loop = 'true';
	}
	?>
	<div class="related products product-slide">
		<div class="section-title">
			<h3><?php echo esc_html( $kt_related_products_title); ?></h3>
		</div>
		<ul class="owl-carousel nav-style5" data-loop="<?php echo esc_attr($loop);?>" data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1,"nav":false},"600":{"items":<?php echo esc_attr($item_ipad);?>},"1000":{"items":<?php echo esc_attr($item_desktop);?>}}'>
		<?php while ( $products->have_posts() ) : $products->the_post(); ?>
			<?php wc_get_template_part( 'content', 'related-products' ); ?>
		<?php endwhile; // end of the loop. ?>
		</ul>
	</div>

<?php endif;

wp_reset_postdata();
