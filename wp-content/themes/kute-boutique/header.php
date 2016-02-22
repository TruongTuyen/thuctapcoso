<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package Boutique
 * @subpackage Boutique
 * @since boutique 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="box-mobile-menu" class="box-mobile-menu full-height full-width">
    <div class="box-inner">
        <a href="#" class="close-menu"><span class="icon pe-7s-close"></span></a>
    </div>
</div>
<?php $kt_enable_sticky_header = kt_option('kt_enable_sticky_header','yes');?>
<?php if( $kt_enable_sticky_header =="yes" ):?>
<div id="header-ontop" class="is-sticky"></div>
<?php endif;?>
<?php
	if( is_plugin_active( 'boutique-toolkit/boutique-toolkit.php' ) ){
		do_shortcode( '[kt_header]' );
	}else{
		get_template_part( 'templates/headers/header',1);
	}
?>