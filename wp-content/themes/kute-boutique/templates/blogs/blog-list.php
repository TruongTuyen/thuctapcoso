<?php


if( have_posts()){
	?>
	<div class="blog-list">
	<?php
	while( have_posts()){
		the_post();
		get_template_part( 'templates/blogs/blog','loop' );
	}
	?>
	</div>
	<?php
	kt_paging_nav();
}else{
	get_template_part( 'content', 'none' );
}
	
?>