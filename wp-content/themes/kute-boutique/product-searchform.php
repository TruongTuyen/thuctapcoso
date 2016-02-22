<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'kute-boutique' ); ?></label>
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'kute-boutique' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'kute-boutique' ); ?>" />
	<button class="button-submit"><?php echo esc_attr_x( 'Search', 'submit button', 'kute-boutique' ); ?></button>
	<input type="hidden" name="post_type" value="product" />
</form>