<?php
$kt_blog_list_style = kt_option('kt_blog_list_style','list');
?>
<div <?php post_class('blog-item');?>>                           
	<?php kt_post_thumbnail( );?>
	<h3 class="blog-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
	<div class="entry-meta">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', __( 'Featured', 'kute-boutique' ) );
		}
		?>
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
		<?php if( $kt_blog_list_style =="list"):?>
		<span class="tags"><?php the_tags();?></span> 
		<?php endif;?>                                
	</div>
	<div class="blog-short-desc excerpt">
	    <?php the_excerpt();?>
	</div>
	<a class="readmore" href="<?php the_permalink();?>"><?php esc_html_e('Readmore','kute-boutique')?></a>
</div>