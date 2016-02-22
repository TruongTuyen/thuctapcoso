<h3 class="page-title"><?php esc_html_e( 'Nothing Found', 'kute-boutique' ); ?></h3>
<div class="no-results not-found">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<p><?php printf( '%2$s <a href="%1$s">%3$s</a>.', esc_url( admin_url( 'post-new.php' ) ), esc_html__( 'Ready to publish your first post?', 'kute-boutique' ), esc_html__( 'Get started here', 'kute-boutique' ) ); ?></p>
	<?php elseif ( is_search() ) : ?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kute-boutique' ); ?></p>
		<?php get_search_form(); ?>

	<?php else : ?>

		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kute-boutique' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>
</div><!-- .no-results -->