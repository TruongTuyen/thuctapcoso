<?php
/**
 * The sidebar containing the main widget area
 *
 */
?>
<?php
$kt_blog_used_sidebar = kt_option( 'kt_blog_used_sidebar', 'widget-area' );
if(is_page( )){
	$kt_page_used_sidebar = kt_get_post_meta( get_the_ID(),'kt_page_used_sidebar','');
	if( $kt_page_used_sidebar !=""){
		$kt_blog_used_sidebar = $kt_page_used_sidebar;
	}
}
?>

<?php if ( is_active_sidebar( $kt_blog_used_sidebar ) ) : ?>
<div id="widget-area" class="widget-area">
	<?php dynamic_sidebar( $kt_blog_used_sidebar ); ?>
</div><!-- .widget-area -->
<?php endif; ?>
