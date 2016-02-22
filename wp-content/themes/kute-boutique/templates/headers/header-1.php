<header id="header" class="header style1 is-sticky">
	<div class="container">
		<div class="top-header">
			<div class="inner">
				<div class="main-menu-wapper">
					<div class="row">
						<div class="col-sm-8">
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
						<div class="col-sm-4">
							<a href="#" class="mobile-navigation"><i class="fa fa-bars"></i></a>
							<div class="box-control">
								<?php kt_search_form(); ?>
								<div class="box-settings">
	                                <a href="#" class="icon pe-7s-config"></a>
	                                <div class="settings-wrapper " style="none">
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
	<div class="main-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-3">
                    <div class="logo">
						<?php kt_get_logo(); ?>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-9">
					<?php kt_catmenu(); ?>
				</div>
			</div>
		</div>
	</div>
	</div>
</header>