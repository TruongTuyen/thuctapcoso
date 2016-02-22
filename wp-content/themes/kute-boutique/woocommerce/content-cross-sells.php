<?php 
	$classes = array();
	$kt_woo_product_style = kt_option('kt_woo_product_style',1);
	$kt_woo_flash_style = kt_option('kt_woo_flash_style','flash1');

	$classes[] = 'product-item style'.$kt_woo_product_style;
	// Flash icon style
	$classes[] = $kt_woo_flash_style;
	$template_style = 'style-'.$kt_woo_product_style;
?>
<li <?php post_class($classes)?>>
<?php wc_get_template_part('content-product', $template_style );?>
</li>