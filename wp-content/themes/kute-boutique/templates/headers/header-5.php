<header id="header" class="header sidebar style6">
	<span class="close-header-sidebar"><span class="icon pe-7s-close"></span></span>
	<span class="open-header-sidebar"><i class="fa fa-angle-double-right"></i></span>
	<div class="header-top sidebar-menu">
		<div class="logo">
			<?php kt_get_logo(); ?>
		</div>
        <?php wp_nav_menu( array(
	            'menu'              => 'header_sidebar_menu',
	            'theme_location'    => 'header_sidebar_menu',
	            'container'         => '',
	            'container_class'   => '',
	            'container_id'      => '',
	            'menu_class'        => 'boutique-nav main-menu menu-sidebar',
	            'fallback_cb'       => 'kt_bootstrap_navwalker::fallback',
	            'walker'            => new kt_bootstrap_navwalker()
            )
	     );// ?>
		<div class="box-control">
			<?php kt_search_form(); ?>
			<?php woocommerce_mini_cart(); ?>
            <div class="box-settings">
                <a href="#" class="icon pe-7s-config"></a>
                <div class="settings-wrapper ">
                    <div class="setting-content">
                        <?php kt_wpml(); ?>
                        <?php kt_woocs(); ?>
                        <?php kt_topmenu(); ?>
                    </div>
                </div>
            </div>
		</div>
		<div class="line-header"></div>
        <?php 
            $facebook   = kt_option('kt_facebook_link_id');
            $twitter    = kt_option('kt_twitter_link_id');
            $pinterest  = kt_option('kt_pinterest_link_id');
            $dribbble   = kt_option('kt_dribbble_link_id');
            $vimeo      = kt_option('kt_vimeo_link_id');
            $tumblr     = kt_option('kt_tumblr_link_id');
            $skype      = kt_option('kt_skype_link_id');
            $linkedin   = kt_option('kt_linkedIn_link_id');
            $vk         = kt_option('kt_vk_link_id');
            $googleplus = kt_option('kt_google_plus_link_id');
            $youtube    = kt_option('kt_youtube_link_id');
            $instagram  = kt_option('kt_instagram_link_id');
        ?>
		<div class="social">
	        <?php 
                if ($facebook) {
                   echo '<a href="'.esc_url($facebook).'" title ="'.esc_html__( 'Facebook', 'kute-boutique' ).'" ><i class="fa fa-facebook"></i></a>';
                }
                if ($twitter) {
                    echo '<a href="http://www.twitter.com/'.esc_attr($twitter).'" title = "'.esc_html__( 'Twitter', 'kute-boutique' ).'" ><i class="fa fa-twitter"></i></a>';
                }
                if ($dribbble) {
                    echo '<a href="http://www.dribbble.com/'.esc_attr($dribbble).'" title ="'.esc_html__( 'Dribbble', 'kute-boutique' ).'" ><i class="fa fa-dribbble"></i></a>';
                }
                if ($vimeo) {
                    echo '<a href="http://www.vimeo.com/'.esc_attr($vimeo).'" title ="'.esc_html__( 'Vimeo', 'kute-boutique' ).'" ><i class="fa fa-vimeo-square"></i></a>';
                }
                if ($tumblr) {
                    echo '<a href="http://'.esc_attr($tumblr).'.tumblr.com/" title ="'.esc_html__( 'Tumblr', 'kute-boutique' ).'" ><i class="fa fa-tumblr"></i></a>';
                } 
                if ($skype) {
                    echo '<a href="skype:'.esc_attr($skype).'" title ="'.esc_html__( 'Skype', 'kute-boutique' ).'" ><i class="fa fa-skype"></i></a>';
                }
                if ($linkedin) {
                    echo '<a href="'.esc_attr($linkedin).'" title ="'.esc_html__( 'Linkedin', 'kute-boutique' ).'" ><i class="fa fa-linkedin"></i></a>';
                }
                if ($googleplus) {
                    echo '<a href="'.esc_url( $googleplus ).'" title ="'.esc_html__( 'Google Plus', 'kute-boutique' ).'" ><i class="fa fa-google-plus"></i></a>';
                }
                if ($youtube) {
                    echo '<a href="http://www.youtube.com/user/'.esc_attr( $youtube ).'" title ="'.esc_html__( 'Youtube', 'kute-boutique' ).'"><i class="fa fa-youtube"></i></a>';
                }
                if ($pinterest) {
                    echo '<a href="http://www.pinterest.com/'.esc_attr( $pinterest ).'/" title ="'.esc_html__( 'Pinterest', 'kute-boutique' ).'" ><i class="fa fa-pinterest-p"></i></a>';
                }
                if ($instagram) {
                    echo '<a href="http://instagram.com/'.esc_attr( $instagram ).'" title ="'.esc_html__( 'Instagram', 'kute-boutique' ).'" ><i class="fa fa-instagram"></i></a>';
                }
                
                if ($vk) {
                    echo '<a href="https://vk.com/'.esc_attr( $vk ).'" title ="'.esc_html__( 'Vk', 'kute-boutique' ).'" ><i class="fa fa-vk"></i></a>';
                }
            ?>
	    </div>
        <?php $copyright  = kt_option('kt_copyrights'); ?>
        <?php if( $copyright ): ?>
	    <div class="sidebar-footer">
	        <div class="coppyright"><?php echo balanceTags( $copyright ); ?></div>
		</div>
        <?php endif; ?>
	</div>
</header>
<?php $menu_cate_menu5 = kt_option( 'kt_header_5_menu_cate', '' ); ?>
<?php if( $menu_cate_menu5 ) : ?>
    <?php 
        $banner_url = kt_option( 'kt_header_5_menu_bg', '' );
        $title      = kt_option( 'kt_header_5_menu_title', '' );
        $sub_title  = kt_option( 'kt_header_5_menu_subtitle', '' );
        $depth      = kt_option( 'kt_header_5_menu_depth', '' );
    ?>
    <div class="header-categoy-menu style-4" <?php if( $banner_url ) : ?>style="background-image: url('<?php echo esc_url( $banner_url ) ?>');"<?php endif; ?>>
    	<span class="close-header-sidebar"><span class="icon pe-7s-close"></span></span>
    	<span class="open-header-sidebar"><i class="fa fa-angle-double-left"></i></span>
    	<div class="inner">
    		<div class="block-category-carousel">
                <?php if( $title ): ?>
    			     <h3 class="title"><?php echo esc_html( $title ) ?></h3>
                <?php endif; ?>
                <?php if( $sub_title ): ?>
    			     <span class="sub-title"><?php echo esc_html( $sub_title ) ?></span>
                <?php endif; ?>
    			<div class="block-inner">
    				<?php 
                        wp_nav_menu( array(
            				'menu'        => $menu_cate_menu5,
            				'fallback_cb' => '',
            				'menu_class'  => 'list-cat',
            				'container'   => false,
                            'depth'       => $depth,
                            'walker'      => new kt_bootstrap_navwalker()
            			) );
                    ?>
    			</div>
    		</div>
    	</div>
    </div>
<?php endif;  ?>
