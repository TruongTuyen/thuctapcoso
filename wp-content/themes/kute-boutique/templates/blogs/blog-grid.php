<?php
$kt_blog_list_style = kt_option('kt_blog_list_style','list');
$kt_blog_list_columns = kt_option('kt_blog_list_columns',3);
if( isset( $_GET['columns'])){
	$kt_blog_list_columns = $_GET['columns'];
}
if( isset( $_GET['liststyle'])){
	$kt_blog_list_style = $_GET['liststyle'];
}

$layoutmode = 'masonry';
if( $kt_blog_list_style == 'grid'){
	$layoutmode ='fitRows';
}

if( have_posts()){
	?>
	<div class="blog-grid butique-masonry">
		<div class="masonry-grid" data-layoutmode="<?php echo esc_attr( $layoutmode );?>" data-cols="<?php echo esc_attr( $kt_blog_list_columns );?>">
		<?php
		while( have_posts()){
			?>
			<div class="grid-item masonry-item">
			<?php
			the_post();
			get_template_part( 'templates/blogs/blog','loop' );
			?>
			</div>
			<?php
		}
		?>
		</div>
	</div>
	<?php
	kt_paging_nav();
}else{
	get_template_part( 'content', 'none' );
}
	
?>