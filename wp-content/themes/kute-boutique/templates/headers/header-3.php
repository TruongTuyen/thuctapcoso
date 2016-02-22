<header id="header" class="header style3 is-sticky">
	<div class="container">
		<div class="main-menu-wapper">
		<div class="row">
			<div class="col-sm-12 col-md-3 logo-wapper">
				<div class="logo">
					<?php kt_get_logo(); ?>
				</div>
			</div>
			<div class="col-sm-12 col-md-9 menu-wapper">
				<div class="top-header">
					<a href="#" class="mobile-navigation"><i class="fa fa-bars"></i></a>
                    <?php $slogan = kt_option( 'kt_header_slogan', false ); ?>
                    <?php if( $slogan ): ?>
					   <div class="slogan"><?php echo esc_html( $slogan ) ?></div>
                    <?php endif; ?>
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
				</div>
				<?php wp_nav_menu( array(
    		            'menu'              => 'primary',
    		            'theme_location'    => 'primary',
    		            'container'         => '',
    		            'container_class'   => '',
    		            'container_id'      => '',
    		            'menu_class'        => 'boutique-nav main-menu clone-main-menu',
    		            'fallback_cb'       => 'kt_bootstrap_navwalker::fallback',
    		            'walker'            => new kt_bootstrap_navwalker()
                    )
    		     );// ?>
			</div>
		</div>
		</div>
	</div>
</header>