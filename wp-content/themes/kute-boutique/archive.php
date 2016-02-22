<?php get_header();?>
<?php
// Blog layout
$kt_blog_layout = kt_option('kt_blog_layout','left');

// Blog setting
$kt_blog_list_style = kt_option('kt_blog_list_style','list');
$kt_blog_list_columns = kt_option('kt_blog_list_columns',3);

// GET SETTINGS DEMO
if( isset( $_GET['layout'])){
	$kt_blog_layout = $_GET['layout'];
}

if( isset( $_GET['liststyle'])){
	$kt_blog_list_style = $_GET['liststyle'];
}


// Main container class
$main_container_class = array();
$main_container_class[] = 'main-container';
if( $kt_blog_layout == 'full'){
	$main_container_class[] = 'no-sidebar';
}else{
	$main_container_class[] = $kt_blog_layout.'-slidebar';
}


$main_content_class = array();
$main_content_class[] = 'main-content';
if( $kt_blog_layout == 'full' ){
	$main_content_class[] ='col-sm-12';
}else{
	$main_content_class[] = 'col-md-9 col-sm-8';
}

$slidebar_class = array();
$slidebar_class[] = 'sidebar';
if( $kt_blog_layout != 'full'){
	$slidebar_class[] = 'col-md-3 col-sm-4';
}

// Setting grid list style
?>
<div class="<?php echo esc_attr( implode(' ', $main_container_class) );?>">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( implode(' ', $main_content_class) );?>">
				<?php 
				if ( have_posts()){
					?>
					<div class="page-title">
						<?php
						the_archive_title( '<h3>','</h3>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</div>
					<?php
				}
				?>
				<!-- Main content -->
				<?php
				if( $kt_blog_list_style == "grid" || $kt_blog_list_style == "masonry"){
					get_template_part( 'templates/blogs/blog','grid' );
				}else{
					get_template_part( 'templates/blogs/blog','list' );
				}
				?>
				<!-- ./Main content -->
			</div>
			<?php if( $kt_blog_layout != "full" ):?>
			<div class="<?php echo esc_attr( implode(' ', $slidebar_class) );?>">
				<?php get_sidebar();?>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>
<?php get_footer();?>