<?php 
    $kt_used_header = kt_get_post_meta( get_the_ID(), 'kt_page_header', '' );
    if( ! $kt_used_header ){
        $kt_used_header = kt_option( 'kt_used_header', 1 );
    } 
?>

<?php if( $kt_used_header == 2 || $kt_used_header == 5 || $kt_used_header == 6 ): ?>
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="box-search show-icon">
        <?php if( kt_is_wc() ): ?>
            <input type="hidden" name="post_type" value="product" />
        <?php endif; ?>
		<span class="icon"><span class="pe-7s-search"></span></span>
		<div class="inner">
			<input class="search" value="<?php echo esc_attr( get_search_query() );?>" type="text" name="s"  placeholder="<?php esc_attr_e( 'Search here...', 'kute-boutique' ); ?>" />
        	<button type="submit" class="button-search">
                <span class="pe-7s-search"></span>
            </button>
		</div>
	</form>
<?php elseif( $kt_used_header == 3 || $kt_used_header == 4 ): ?>
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="box-search">
        <?php if( kt_is_wc() ): ?>
            <input type="hidden" name="post_type" value="product" />
        <?php endif; ?>
		<div class="inner">
			<input class="search" value="<?php echo esc_attr( get_search_query() );?>" type="text" name="s"  placeholder="<?php esc_attr_e( 'Search here...', 'kute-boutique' ); ?>" />
        	<button type="submit" class="button-search">
                <span class="pe-7s-search"></span>
            </button>
		</div>
	</form>
<?php elseif( $kt_used_header == 7 ): ?>
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="box-search">
        <?php if( kt_is_wc() ): ?>
            <input type="hidden" name="post_type" value="product" />
        <?php endif; ?>
        <input class="search" value="<?php echo esc_attr( get_search_query() );?>" type="text" name="s"  placeholder="<?php esc_attr_e( 'Search here...', 'kute-boutique' ); ?>" />
        <button class="button-search"><span class="pe-7s-search"></span></button>
    </form>
<?php else: ?>
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="box-search">
        <?php if( kt_is_wc() ): ?>
            <input type="hidden" name="post_type" value="product" />
        <?php endif; ?>
        <input class="search" value="<?php echo esc_attr( get_search_query() );?>" type="text" name="s"  placeholder="<?php esc_attr_e( 'Search here...', 'kute-boutique' ); ?>" />
    	<button type="submit" class="button-search">
            <span class="pe-7s-search"></span>
        </button>
    </form>
<?php endif; ?>