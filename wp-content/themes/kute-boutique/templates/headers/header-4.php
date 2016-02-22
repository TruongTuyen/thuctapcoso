<header id="header" class="header style5 is-sticky">
	<div class="top-header">
		<div class="container">
			<div class="logo">
				<?php kt_get_logo(); ?>
			</div>
		</div>
	</div>
	<div class="main-header">
		<div class="container">
			<div class="main-menu-wapper">
				<div class="row">
					<div class="col-xs-2 col-sm-8 col-md-8">
						<a href="#" class="mobile-navigation"><i class="fa fa-bars"></i></a>
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
					<div class="col-xs-10 col-sm-4 col-md-4">
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
				</div>
			</div>
		</div>
	</div>
</header>