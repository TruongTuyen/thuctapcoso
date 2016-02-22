<div class="blog-detail">
	<article class="blog-item">
		<h1 class="blog-title"><?php the_title();?></h1>
		<div class="entry-meta">
		    <span class="post-date"><?php echo get_the_date('F j, Y');?></span>
			<span class="blog-comment">
				<i class="fa fa-comment"></i>
				<span class="count-comment">
					<?php comments_number(
				        esc_html__('0', 'kute-boutique'),
				        esc_html__('1', 'kute-boutique'),
				        esc_html__('%', 'kute-boutique')
				    ); 
			    	?>
				</span>
			</span>                                   
		</div>
		<?php kt_post_thumbnail( );?>
		<div class="blog-short-desc">
			<?php the_content();?>
		</div>
	</article>
	<?php
	wp_link_pages( array(
		'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'kute-boutique' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'kute-boutique' ) . ' </span>%',
		'separator'   => '<span class="screen-reader-text">, </span>',
	) );
	?>
</div>
<?php
$kt_display_about_author = kt_option('kt_display_about_author','yes');
$kt_enable_related_post = kt_option('kt_enable_related_post','yes');
if( $kt_display_about_author =="yes"){
	get_template_part( 'templates/blogs/single','post-author' );
}
if( $kt_enable_related_post =="yes"){
	get_template_part( 'templates/blogs/single','post-related' );	
}
?>