<?php 
$orig_post = $post;
global $post;
// Setting 
$kt_related_posts_per_page = kt_option('kt_related_posts_per_page',3);
$kt_related_colums = kt_option('kt_related_colums',3);
$kt_blog_layout = kt_option('kt_blog_layout','left');
$kt_blog_placehold = kt_option('kt_blog_placehold','no');
// Thumb
$thumb_w = 370;
$thumb_h = 281;
$crop = true;
// Columns
$bootstrapColumn = round( 12 / $kt_related_colums );
$item_class = array('blog-item');
$item_class[] ='col-md-'.$bootstrapColumn;

if( $kt_blog_layout =="full"){
	$item_class[] = 'col-sm-4';
	if( $kt_related_colums == 4){
		$thumb_w = 270;
		$thumb_h = 205;
	}
	if( $kt_related_colums == "2"){
		$thumb_w = 570;
		$thumb_h = 534;
	}
}else{
	$item_class[] = 'col-sm-6';
	if( $kt_related_colums == 4){
		$thumb_w = 250;
		$thumb_h = 190;
	}
	if( $kt_related_colums == 2){
		$thumb_w = 420;
		$thumb_h = 309;
	}
}

$item_class[] ='col-xs-12';


$categories = get_the_category($post->ID);
if ($categories) :
	$category_ids = array();
	foreach($categories as $individual_category) {
        $category_ids[] = $individual_category->term_id;
	}
	$args = array(
		'category__in'        => $category_ids,
		'post__not_in'        => array($post->ID),
		'posts_per_page'      => $kt_related_posts_per_page,
		'ignore_sticky_posts' => 1,
		'orderby'             => 'rand'
	);
	$new_query = new wp_query( $args );
?>
    <?php if( $new_query->have_posts() ) : ?>
    <div class="related-wrap">
    	<h4 class="related-title"><?php esc_html_e('YOU MAY ALSO LIKE','kute-boutique'); ?></h4>
    	<ul class="blog-related row <?php echo esc_attr('columns-'.$kt_related_colums." layout-".$kt_blog_layout)?>">
    		<?php while( $new_query->have_posts()): $new_query->the_post();?>
    			<li class="<?php echo esc_attr( implode(' ', $item_class) );?>">
    				<?php if( $kt_blog_placehold == "yes" || has_post_thumbnail()):?>
    				<?php
    				$thumb = kt_resize_image( get_post_thumbnail_id(), wp_get_attachment_thumb_url(), $thumb_w, $thumb_h, $crop, true, false );
    				?>
    				<?php if( $thumb['url']):?>
                    <div class="post-thumbnail">                               
                        <a class="banner-opacity" href="<?php the_permalink();?>">
                        	<img src="<?php echo esc_url($thumb['url']); ?>" alt=""/>
                        </a>
                    </div> 
                	<?php endif;?>
                	<?php endif;?>
                    <h3 class="blog-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                    <div class="entry-meta">
					    <span class="post-date"><?php echo get_the_date('F j, Y');?></span>
						<span class="blog-comment">
							<i class="fa fa-comment"></i>
							<span class="count-comment">
								<?php 
								comments_number(
							        esc_html__('0', 'kute-boutique'),
							        esc_html__('1', 'kute-boutique'),
							        esc_html__('%', 'kute-boutique')
							    ); 
						    	?>
							</span>
						</span>                                   
					</div>
                </li>
    		<?php endwhile; ?>
    	</ul>
    </div>
    <?php endif; ?>
<?php endif;
$post = $orig_post;
wp_reset_query();