<header id="header" class="header style3 style4 is-sticky">
    <div class="top-header">
        <div class="inner">
            <div class="main-menu-wapper">
                <div class="row">
                    <div class="col-md-12 col-lg-3 logo-wapper">
                        <div class="logo">
                            <?php kt_get_logo(); ?>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-3 col-md-6 col-lg-6">
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
                        <a href="#" class="mobile-navigation"><i class="fa fa-bars"></i></a>
                    </div>
                    <div class="col-xs-10 col-sm-9 col-md-6 col-lg-3 control-wapper">
                        <div class="box-control">
                            <?php kt_search_form(); ?>
                            <?php woocommerce_mini_cart(); ?>
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
            <?php kt_catmenu( 'category-menu style2' ); ?>
        </div>
    </div>
</header>