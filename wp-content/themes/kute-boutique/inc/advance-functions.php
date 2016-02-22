<?php

if ( ! function_exists( 'kt_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Boutique 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function kt_paging_nav() {
	global $wp_query, $wp_rewrite;
    // Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}
    echo get_the_posts_pagination( array(
        'prev_text'          => '<i class="fa fa-long-arrow-left"></i>',
        'next_text'          => '<i class="fa fa-long-arrow-right"></i>',
        'screen_reader_text' => '&nbsp;',
        'before_page_number' => '',
    ) );
    
}
endif;

if ( !function_exists( 'kt_resize_image' ) ) {

	/**
	 * @param int $attach_id
	 * @param string $img_url
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
     * @param bool $place_hold          Using place hold image if the image does not exist
     * @param bool $use_real_img_hold   Using real image for holder if the image does not exist
     * @param string $solid_img_color   Solid placehold image color (not text color). Random color if null
	 *
	 * @since 1.0
	 * @return array
	 */
	function kt_resize_image( $attach_id = null, $img_url = null, $width, $height, $crop = false, $place_hold = true, $use_real_img_hold = true, $solid_img_color = null ) {
        
        // If is singular and has post thumbnail and $attach_id is null, so we get post thumbnail id automatic
        if ( is_singular() && !$attach_id ) {
            if ( has_post_thumbnail() && !post_password_required() ) {
                $attach_id = get_post_thumbnail_id();
            }
        }
        
		// this is an attachment, so we have the ID
		$image_src = array();
        
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			$file_path = str_replace( get_site_url(), get_home_path(), $img_url );
            $actual_file_path = rtrim( $file_path, '/' );
            if ( !file_exists( $actual_file_path ) ) {
                $file_path = parse_url( $img_url );
                $actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
            } 
			if ( file_exists( $actual_file_path ) ) {
                $orig_size = getimagesize( $actual_file_path );
        		$image_src[0] = $img_url;
        		$image_src[1] = $orig_size[0];
        		$image_src[2] = $orig_size[1];
            }
            else{
                $image_src[0] = '';
        		$image_src[1] = 0;
        		$image_src[2] = 0;
            }
		}
		if ( ! empty( $actual_file_path ) && file_exists( $actual_file_path ) ) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info['extension'];

			// the image path without the extension
			$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

			// checking if the file size is larger than the target size
			// if it is smaller or the same size, stop right here and return
			if ( $image_src[1] > $width || $image_src[2] > $height ) {

				// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
					$vt_image = array(
						'url' => $cropped_img_url,
						'width' => $width,
						'height' => $height
					);

					return $vt_image;
				}

				// $crop = false
				if ( $crop == false ) {
					// calculate the size proportionaly
					$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
					$resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

					// checking if the file already exists
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

						$vt_image = array(
							'url' => $resized_img_url,
							'width' => $proportional_size[0],
							'height' => $proportional_size[1]
						);

						return $vt_image;
					}
				}

				// no cache files - let's finally resize it
				$img_editor = wp_get_image_editor( $actual_file_path );

				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => ''
					);
				}

				$new_img_path = $img_editor->generate_filename();

				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => ''
					);
				}
				if ( ! is_string( $new_img_path ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => ''
					);
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				// resized output
				$vt_image = array(
					'url' => $new_img,
					'width' => $new_img_size[0],
					'height' => $new_img_size[1]
				);

				return $vt_image;
			}

			// default output - without resizing
			$vt_image = array(
				'url' => $image_src[0],
				'width' => $image_src[1],
				'height' => $image_src[2]
			);

			return $vt_image;
		}
        else {
            if ( $place_hold ) {
                $width = intval( $width );
                $height = intval( $height );
                
                // Real image place hold (https://unsplash.it/)
                if ( $use_real_img_hold ) {
                    $random_time = time() + rand( 1, 100000 );
                    $vt_image = array(
        				'url' => 'https://unsplash.it/' . $width . '/' . $height . '?random&time=' . $random_time,
        				'width' => $width,
        				'height' => $height
        			); 
                }
                else{
                    $vt_image = array(
        				'url' => 'http://placehold.it/' . $width . 'x' . $height,
        				'width' => $width,
        				'height' => $height
        			);
                }
                return $vt_image;
            }
        }

		return false;
	}
}

if( ! function_exists( 'kt_get_post_meta' ) ) {
    /**
     * Function get post meta
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_get_post_meta( $post_id, $key, $default = "" ){
        $meta = get_post_meta( $post_id, $key, true );
        if($meta){
            return $meta;
        }
        return $default;
    }
}
if( ! function_exists('kt_search_form') ){
    /**
     * Function get the search form template
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_search_form() {
        get_template_part('templates/search', 'form' );
    }
}
if( ! function_exists( 'kt_is_wc' ) ){
    /**
     * Function check if WC Plugin installed
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_is_wc(){
        return function_exists( 'is_woocommerce' );
    }
}
if( ! function_exists( 'kt_is_woocs' ) ){
    /**
     * Function check if WOOCOMMERCE CURRENCY
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_is_woocs(){
        return class_exists( 'WOOCS' );
    }
}
if( ! function_exists( 'kt_is_wpml' ) ){
    /**
     * Function check if WPML
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_is_wpml(){
        return class_exists( 'SitePress' );
    }
}
if( ! function_exists( 'kt_woocs' ) ){
    /**
     * Function selector currency
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_woocs(){
        if( class_exists( 'WOOCS_STORAGE' ) ){
            $default = array(
                'USD' => array(
                    'name' => 'USD',
                    'rate' => 1,
                    'symbol' => '&#36;',
                    'position' => 'right',
                    'is_etalon' => 1,
                    'description' => 'USA dollar',
                    'hide_cents' => 0,
                    'flag' => '',
                ),
                'EUR' => array(
                    'name' => 'EUR',
                    'rate' => 0.89,
                    'symbol' => '&euro;',
                    'position' => 'left_space',
                    'is_etalon' => 0,
                    'description' => 'Europian Euro',
                    'hide_cents' => 0,
                    'flag' => '',
                )
            );
            $current_currency = 'USD';
            
            $storage = new WOOCS_STORAGE(get_option('woocs_storage', 'session'));
            $current_currency = $storage->get_val('woocs_current_currency');
            $currencies = get_option('woocs', $default);?>
            <div class="select-currency">
                <div class="currency-title"><?php esc_html_e( 'Select currency', 'kute-boutique' ) ?></div>
                <div class="currency-topbar">                                                
                    <div class="currency-list">
                        <ul class="clearfix">
                            <?php foreach ($currencies as $key => $currency) : ?>
                                <li <?php if( $key == $current_currency ): ?>class="active"<?php endif; ?>>
                                    <a class="woocs_flag_view_item<?php if( $key == $current_currency ): ?> woocs_flag_view_item_current<?php endif; ?>" data-currency="<?php echo esc_attr( $key ) ?>" href="#"><span class="sym"><?php echo esc_attr( $currency['symbol'] ) ?></span></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        }
    }
}

if( ! function_exists( 'kt_wpml' ) ){
    /**
     * Function selector lan
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_wpml() { ?>
        <?php if( kt_is_wpml() ): global $sitepress; $active_languages = $sitepress->get_ls_languages(); ?>
            <div class="select-language">
                <div class="language-title"><?php esc_html_e( 'Select language', 'kute-boutique' ) ?></div>
                <div class="language-topbar">                                                
                    <div class="lang-list">
                        <ul class="clearfix">
                            <?php 
                            /**
                			 * @var $main_language bool|string
                			 * @used_by menu/language-selector.php
                			 */
                			foreach ( $active_languages as $k => $al ) :?>
                                <li <?php if ( $al[ 'active' ] == 1 ) : ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo esc_url( $al['url'] ) ?>"> 
                                        <img title="<?php echo esc_attr( $al['native_name'] ) ?>" src="<?php echo esc_attr( $al['country_flag_url'] ) ?>" alt="<?php echo esc_attr( $al['language_code'] ) ?>" /> 
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php }
}
if( ! function_exists( 'kt_topmenu' ) ){
    /**
     * Function show top menu
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_topmenu() { ?>
        <div class="setting-option">
            <?php 
                wp_nav_menu( array(
    	            'menu'              => 'top-menu',
    	            'theme_location'    => 'top-menu',
    	            'container'         => false,
    	            'menu_class'        => '',
    	            'fallback_cb'       => 'kt_bootstrap_navwalker::fallback',
    	            'walker'            => new kt_bootstrap_navwalker()
                )
    	     );//
            ?>
        </div>
    <?php }
}

if( ! function_exists( 'kt_catmenu' ) ){
    /**
     * Function show category menu
     * 
     * @since boutique 1.0
     * @author AngelsIT
     */
    function kt_catmenu( $menu_class = 'category-menu' ) { 
        wp_nav_menu( array(
	            'menu'              => 'menu-category',
	            'theme_location'    => 'category',
	            'container'         => false,
	            'menu_class'        => $menu_class,
	            'fallback_cb'       => 'kt_bootstrap_navwalker::fallback',
	            'walker'            => new kt_bootstrap_navwalker()
            )
	     );//
    }
}


if( !function_exists( 'kt_write_custom_css_js ' )){
    function kt_write_custom_css_js(){
        $kt_custom_css = kt_option('kt_custom_css','');
        $kt_custom_js = kt_option('kt_custom_js','');
        ?>
        <style type="text/css">
            <?php echo apply_filters( 'kt_theme_customize_css', $kt_custom_css );?>
        </style>
        <script type="text/javascript">
            <?php echo apply_filters( 'kt_theme_customize_js', $kt_custom_js );?>
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'kt_write_custom_css_js',100 );


add_action( 'tgmpa_register', 'kt_register_required_plugins' );

if( ! function_exists( 'kt_register_required_plugins' ) ):
    function kt_register_required_plugins() {
        $plugins = array(
            array(
                'name'                  => 'Boutique toolkit', // The plugin name
                'slug'                  => 'boutique-toolkit', // The plugin slug (typically the folder name)
                'source'                => get_stylesheet_directory() . '/recommend-plugins/boutique-toolkit.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => 'Revolution Slider', // The plugin name
                'slug'                  => 'revslider', // The plugin slug (typically the folder name)
                'source'                => get_stylesheet_directory() . '/recommend-plugins/revslider.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => 'WPBakery Visual Composer', // The plugin name
                'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
                'source'                => get_stylesheet_directory() . '/recommend-plugins/js_composer.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'      => 'WooCommerce',
                'slug'      => 'woocommerce',
                'required'  => false,
            ),
            array(
                'name'      => 'YITH WooCommerce Compare',
                'slug'      => 'yith-woocommerce-compare',
                'required'  => false,
            ),
            array(
                'name' => 'YITH WooCommerce Wishlist', // The plugin name
                'slug' => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name' => 'YITH WooCommerce Ajax Product Filter', // The plugin name
                'slug' => 'yith-woocommerce-ajax-navigation', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name' => 'YITH WooCommerce Quick View', // The plugin name
                'slug' => 'yith-woocommerce-quick-view', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
        );
    
        $config = array(
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => true,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        );
    
        tgmpa( $plugins, $config );
    }
endif;