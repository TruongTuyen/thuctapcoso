<?php
/* GET HTML */
if( !function_exists( 'kt_get_html' )){
    function kt_get_html( $html ){
        return balanceTags( $html );
    }
}

// GET OPTION
if ( ! function_exists( 'kt_option' ) ){
    function kt_option( $option = false, $default = false ){
        if($option === FALSE){
            return FALSE;
        }

        $option_name = apply_filters('theme_option_name', 'kt_options' );
        
        $kt_options  = wp_cache_get( $option_name );
        if(  ! $kt_options ){
            $kt_options = get_option( $option_name );
            if( empty($kt_options)  ){
                // get default theme option
                if( defined( 'ICL_LANGUAGE_CODE' ) ){
                    $kt_options = get_option( 'kt_options' );
                }
            }
            wp_cache_delete( $option_name );
            wp_cache_add( $option_name, $kt_options );
        }
        if(isset($kt_options[$option]) && $kt_options[$option] !== ''){
            return $kt_options[$option];
        }else{
            return $default;
        }
    }
}

// GET LOGO
if( ! function_exists( 'kt_get_logo') ){
    function kt_get_logo(){
        $default = kt_get_post_meta( get_the_ID(), 'kt_page_logo', '' );
        
        if( ! $default ){
            $default = kt_option("kt_logo" , apply_filters( 'kt_site_logo_default', get_template_directory_uri() . '/images/logo.png' ));
        }
        
        $html = '<a href="'.esc_url( get_home_url() ).'"><img alt="'.esc_attr( get_bloginfo('name') ).'" src="'.esc_url($default).'" class="_rw" /></a>';
        
        echo apply_filters( 'kt_site_logo', $html );
    }
}

// POST THUMBNAIL
if( !function_exists( 'kt_post_thumbnail' )){
    function kt_post_thumbnail(){
        
        $thumb_class = array();

        global $kt_blog_layout, $kt_blog_list_style, $kt_blog_list_columns;

        $kt_blog_placehold = kt_option('kt_blog_placehold','no');

        if( $kt_blog_placehold == 'no' && !has_post_thumbnail()){
            return false;
        }
        $crop    = false;

        if( $kt_blog_layout == 'full'){
            $thumb_w = 1170;
            $thumb_h = 820;
            $crop    = false;
        }else{
            $thumb_w = 870;
            $thumb_h = 609;
            $crop    = false;
        } 

        if( ($kt_blog_list_style == 'grid' || $kt_blog_list_style == 'masonry') && $kt_blog_layout=='full'){
            if( $kt_blog_list_columns == 5){
                $thumb_w = 234;
                $thumb_h = 177;
            }
            if( $kt_blog_list_columns == 4){
                $thumb_w = 292;
                $thumb_h = 221;
            }
            if( $kt_blog_list_columns == 3){
                $thumb_w = 370;
                $thumb_h = 280;
            }
            if( $kt_blog_list_columns == 2){
                $thumb_w = 585;
                $thumb_h = 443;
            }
            if( $kt_blog_list_style == 'grid' )
            $crop    = true;

        }elseif( ($kt_blog_layout == 'left' || $kt_blog_layout == 'right') && ($kt_blog_list_style == 'grid' || $kt_blog_list_style == 'masonry')){

            if( $kt_blog_list_columns == 5){
                $thumb_w = 292;
                $thumb_h = 221;
            }
            if( $kt_blog_list_columns == 4){
                $thumb_w = 292;
                $thumb_h = 221;
            }
            if( $kt_blog_list_columns == 3){
                $thumb_w = 292;
                $thumb_h = 221;
            }
            if( $kt_blog_list_columns == 2){
                $thumb_w = 435;
                $thumb_h = 329;
            }
            $crop    = true;
        }

        if( $kt_blog_list_style == 'masonry'){
            $crop = false;
        }

        if( is_single()){
            if( $kt_blog_layout == 'full'){
                $thumb_w = 1170;
                $thumb_h = 820;
                $crop    = false;
            }else{
                $thumb_w = 870;
                $thumb_h = 610;
                $crop    = false;
            } 
        }

        if( $kt_blog_list_style == 'grid' || $kt_blog_list_style =="masonry" || is_single()){
            $thumb_class[]='banner-opacity';
        }else{
            $thumb_class[]= 'gray';
        }
        if( is_single()){
            $thumb_class = array('gray');
        }

        $image = kt_resize_image( get_post_thumbnail_id(), null, $thumb_w, $thumb_h, $crop, true, false );
        ?>
        <div class="post-thumbnail">
            <a class="<?php echo esc_attr( implode(' ', $thumb_class) );?>" href="<?php the_permalink(); ?>">
                <img width="<?php echo esc_attr( $image['width'] ); ?>" height="<?php echo esc_attr( $image['height'] ); ?>" class="attachment-post-thumbnail wp-post-image" src="<?php echo esc_attr( $image['url'] ) ?>" alt="<?php the_title(); ?>" />
            </a>
        </div>
        
        <?php
    }
}
if ( ! function_exists( 'kt_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Twenty Fifteen 1.0
 */
function kt_comment_nav() {
    // Are there comments to navigate through?
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    ?>
    <nav class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'kute-boutique' ); ?></h2>
        <div class="nav-links">
            <?php
                if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'kute-boutique' ) ) ) :
                    printf( '<div class="nav-previous">%s</div>', $prev_link );
                endif;

                if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'kute-boutique' ) ) ) :
                    printf( '<div class="nav-next">%s</div>', $next_link );
                endif;
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .comment-navigation -->
    <?php
    endif;
}
endif;

// Comment Layout
function kt_custom_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    } 
    ?>
    <<?php echo esc_attr($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-item">
    <?php endif; ?>
        <div class="comment-author">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        </div>
        <div class="comment-body">
            <h5 class="author">
                <?php get_comment_author_link(); ?>
            </h5>
            <span class="date-comment">
                <?php printf( esc_html__('%1$s at %2$s', 'kute-boutique'), get_comment_date(),  get_comment_time() ); ?>
            </span>
            
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'kute-boutique' ); ?></em>
                <br />
            <?php endif; ?>
            <div class="comment-content"><?php comment_text(); ?></div>
            <div class="reply">
                <?php edit_comment_link( esc_html__( '(Edit)', 'kute-boutique' ), '  ', '' );?>
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
        </div>  
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
}

// Author Social Links
add_filter( 'user_contactmethods', 'kt_author_social_links' );
function kt_author_social_links()
{
    $contactmethods              = array();
    $contactmethods['twitter']   = 'Twitter Username';
    $contactmethods['facebook']  = 'Facebook Username';
    $contactmethods['google']    = 'Google Plus Username';
    $contactmethods['tumblr']    = 'Tumblr Username';
    $contactmethods['instagram'] = 'Instagram Username';
    $contactmethods['pinterest'] = 'Pinterest Username';
    return $contactmethods;
}


function kt_themne_color(){
    $main_color = kt_option('kt_main_color','#c99947');
    if( isset($_GET['theme_color']) && $_GET['theme_color']!="" ){
        $main_color = "#".$_GET['theme_color'];
    }
    /* Main color */
    $css = '
    body a,
    body .text-primary,
    .topbar-menu li>a:hover,
    .main-menu>li>a:hover,
    .main-menu .sub-menu>li>a:hover,
    .megamenu .widget_nav_menu ul>li>a:hover,
    .category-menu li>a:hover,
    .show-shopping-cart .list-product .product-name a:hover,
    .setting-option ul li a:hover,
    .header.style3 .main-menu>li>a:hover,
    .header.style3 .main-menu>li.active>a,
    .header.style5 .main-menu>li>a:hover,
    .header.style5 .main-menu>li.active>a,
    .header.style14 .main-menu>li>a:hover,
    .header.style14 .main-menu>li.active>a,
    .header.style15 .main-menu>li>a:hover,
    .header.style15 .main-menu>li.active>a,
    .header.sidebar .main-menu>li>a:hover,
    .header.sidebar .main-menu>li.active>a,
    .header-bottom-sidebar-menu .sub-menu>li>a:hover,
    .header.style9 .main-menu>li>a:hover,
    .header.style9 .main-menu>li.active>a,
    .product-item .product-name a:hover,
    .product-item.style2 .add_to_cart_button,
    .product-item.style2 .product_type_external,
    .product-item.style2 .product_type_simple,
    .product-item.style2 .product_type_grouped,
    .product-item.list .available span,
    .product-item.style5 .price,
    .product-item.style5 .yith-wcwl-add-to-wishlist>div a,
    .product-item.style5 .wishlist,
    .loadmore-link:hover,
    .breadcrumbs a:hover,
    .woocommerce-breadcrumb a:hover,
    .shop-top .show-grid-list a:hover,
    .shop-top .show-grid-list a.active,
    .widget_product_categories li a:hover,
    .widget_product_categories li.current-cat>a,
    .widget_layered_nav li a:hover,
    .widget_product_top_sale .p-name a:hover,
    .widget_recent_product .product-name a:hover,
    .element-icon.style2:hover,
    .element-icon.style2:hover .title,
    .element-icon.style3 .icon,
    .element-icon.style3 .subtite,
    .element-icon.style3:hover .title,
    .element-icon.plus:after,
    .footer .custom-menu  a:hover,
    .footer .our-service ul li a:hover,
    .footer .widget_social .social a:hover,
    .footer.style5 .widget_social .social a:hover,
    .footer .footer-menu li>a:hover,
    .lastest-blog .blog-title a:hover,
    .lastest-blog .meta .fa,
    .lastest-blog.style3 .blog-title a:hover,
    .banner-text.style3 .title,
    .banner-text.style3 .box-link:hover,
    .banner-text.style4 .subtitle,
    .block-category-carousel .list-cat li>a:hover,
    .block-single-product .product-name a:hover,
    .block-single-product .addtocart:hover,
    .product-details-right.style2 .share a:hover,
    table.group-product a:hover,
    .blog-item  .blog-title a:hover,
    .blog-item .readmore:hover,
    .blog-item  .more-link:hover,
    .blog-item .blog-comment .fa-comment,
    .product_list_widget a:hover .product-title,
    .widget_layered_nav_filters .chosen a:hover,
    .widget_categories li>a:hover,
    .widget_archive li>a:hover,
    .widget_pages li>a:hover,
    .widget_meta li>a:hover,
    .widget_nav_menu li>a:hover,
    .post-social a:hover,
    .product-item.style5 .yith-wcwl-add-to-wishlist>div a:hover,
    .product-item.style2 .added_to_cart,
    .element-icon.style3 .text{
        color: '.$main_color.';
    }

    .button:hover, input[type="submit"]:hover,
    .button.btn-primary,
    .owl-carousel.nav-style4 .owl-next:hover,
    .owl-carousel.nav-style4 .owl-prev:hover,
    .owl-carousel.nav-style6 .owl-next:hover,
    .owl-carousel.nav-style6 .owl-prev:hover,
    .owl-carousel.nav-style7 .owl-next:hover,
    .owl-carousel.nav-style7 .owl-prev:hover,
    .kt-tabs .kt-tabs-list .kt-tab a:after,
    .main-menu>li>a:before,
    .mini-cart .count,
    .mini-cart .group-button .check-out:hover,
    .header.sidebar .social a:hover,
    .product-item .yith-wcwl-add-to-wishlist>div a:hover,
    .product-item .compare-button a:hover,
    .product-item .button.quick-view:hover,
    .product-item.style5 .add_to_cart_button:hover,
    .product-item.style5 .product_type_external:hover,
    .product-item.style5 .product_type_grouped:hover,
    .product-item.style5 .product_type_simple:hover,
    .product-item.list .yith-wcwl-add-to-wishlist>div a:hover,
    .product-item.style5 .compare:hover, 
    .product-item.style5 .quick-view:hover,
    .tagcloud a:hover,
    .widget_price_filter .ui-slider-handle:last-child,
    .footer .widget_social .social a:hover,
    .section-title h3:before,
    .section-title.style4 h3:before,
    .section-title.style4 h3:after,
    .section-title.style6 .sub-title:after,
    .lastest-blog.style2 .blog-date,
    .banner-text .button,
    .block-category-carousel .title:after,
    .product-details-right .yith-wcwl-add-to-wishlist>div a:hover,
    .product-details-right.style2 .compare.button:hover,
    .sticky-post,
    .social a:hover,
    .blog-slidebar .widget .widget-title:after,
    body .shop-banner .owl-carousel .owl-next:hover, 
    body .shop-banner .owl-carousel .owl-prev:hover,
    .product-item .added_to_cart:hover,
    .product-item.style5 .added_to_cart:hover,
    .scroll_top:hover, .scroll_top:focus, .scroll_top:active{
        background-color: '.$main_color.';
    }
    body blockquote,
    .owl-carousel.nav-style6 .owl-next:hover,
    .owl-carousel.nav-style6 .owl-prev:hover,
    .owl-carousel.nav-style7 .owl-next:hover,
    .owl-carousel.nav-style7 .owl-prev:hover,
    .category-menu li>a:hover,
    .category-menu.style2 li:hover .icon,
    .mini-cart .group-button .check-out:hover,
    .product-item .button.quick-view:hover,
    .product-item.style5 .add_to_cart_button:hover,
    .product-item.style5 .product_type_external:hover,
    .product-item.style5 .product_type_grouped:hover,
    .product-item.style5 .product_type_simple:hover,
    .product-item.list .yith-wcwl-add-to-wishlist>div a:hover,
    .product-item.style5 .compare:hover, 
    .product-item.style5 .quick-view:hover,
    body .element-icon.style2:before,
    body .element-icon.style2:after,
    .element-icon.style3 .icon,
    .footer .widget_social .social a:hover,
    .newsletter:after,
    .newsletter.style2,
    .product-details-right .yith-wcwl-add-to-wishlist>div a:hover,
    .product-details-right.style2 .compare.button:hover,
    body .shop-banner .owl-carousel .owl-next:hover, 
    body .shop-banner .owl-carousel .owl-prev:hover,
    .product-item.style5 .compare:hover, 
    .product-item.style5 .quick-view:hover, 
    .product-item.style5.list .yith-wcwl-add-to-wishlist>div a:hover,
    .product-item.list.style5 .button.quick-view:hover,
    .product-item.list.style5 .compare-button a:hover,
    .product-item.style5 .added_to_cart:hover{
        border-color: '.$main_color.';
    }
    ';
?>
    <style id="kt-theme-color" type="text/css">
        <?php echo apply_filters( 'kt_customize_css', $css );?>
    </style>
<?php
}

add_action( 'wp_footer', 'kt_themne_color',100 );