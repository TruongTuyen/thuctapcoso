<div <?php post_class('blog-item');?>>     
	<h3 class="blog-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
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
	<div class="blog-short-desc">
	    <?php the_excerpt();?>
	</div>
	<a class="readmore" href="<?php the_permalink();?>"><?php esc_html_e('Readmore','kute-boutique')?></a>
</div>