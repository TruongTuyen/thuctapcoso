<?php
if ( ! isset( $content_width ) ) $content_width = 1170;

if( !function_exists( 'kt_setup')){

	function kt_setup(){
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on boutique, use a find and replace
		 * to change 'kute-boutique' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'kute-boutique', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 825, 510, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'             => esc_html__( 'Primary Menu',  'kute-boutique' ),
			'category'            => esc_html__( 'Category Menu', 'kute-boutique' ),
			'top-menu'            => esc_html__( 'Menu Top Right', 'kute-boutique' ),
			'header_sidebar_menu' => esc_html__( 'Header Sidebar menu', 'kute-boutique' )
		) );
        add_image_size ( 'kt-post-270x270', 270, 270, true );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		//Support woocommerce
        add_theme_support( 'woocommerce' );
	}
}

add_action( 'after_setup_theme', 'kt_setup' );


/**
 * Register widget area.
 *
 * @since Boutique 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function kt_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Widget Area', 'kute-boutique' ),
		'id'            => 'widget-area',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'kute-boutique' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Widget Area', 'kute-boutique' ),
		'id'            => 'shop-widget-area',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'kute-boutique' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'kt_widgets_init' );

// Load Google fonts
function kt_google_fonts_url()
{
    $fonts_url = '';
    $font_families = array();
    $font_families[] = 'Roboto:300,100,100italic,300italic,400,400italic,500,500italic,700,700italic,900,900italic'; 
    $font_families[] = 'Montserrat:400,700';
    $font_families[] = 'Playfair+Display:400,400italic,700,700italic,900,900italic';
    $font_families[] = 'Great+Vibes';
    $query_args = array(
        'family' => urlencode(implode('|', $font_families )),
        'subset' => urlencode('latin,latin-ext')
    );
    $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    return esc_url_raw($fonts_url);
}

/**
 * Enqueue scripts and styles.
 *
 * @since Boutique 1.0
 */
function kt_scripts() {
	// Load fonts
	wp_enqueue_style( 'kt-googlefonts', kt_google_fonts_url(), array(), null );
	
	// Load lib
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '20160105' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '20160105' );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), '20160105' );
	wp_enqueue_style( 'chosen', get_template_directory_uri() . '/css/chosen.css', array(), '20160105' );
	wp_enqueue_style( 'lightbox', get_template_directory_uri() . '/css/lightbox.min.css', array(), '20160105' );
	wp_enqueue_style( 'pe-icon-7-stroke', get_template_directory_uri() . '/css/pe-icon-7-stroke.css', array(), '20160105' );
	wp_enqueue_style( 'query-mCustomScrollbar', get_template_directory_uri() . '/css/jquery.mCustomScrollbar.css', array(), '20160105' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '20160105' );
	// Load our main stylesheet.
	wp_enqueue_style( 'kt-main-style', get_stylesheet_uri() );

	// Load theme stylesheet.
	wp_enqueue_style( 'kt-style', get_template_directory_uri() . '/css/style.css', array(), '20160105' );
	wp_enqueue_style( 'kt-woo', get_template_directory_uri() . '/css/woocommerce.css', array(), '20160105' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load lib js
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'chosen-jquery', get_template_directory_uri() . '/js/chosen.jquery.min.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'Modernizr', get_template_directory_uri() . '/js/Modernizr.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/js/lightbox.min.js', array( 'jquery' ), '20160105', true );

	wp_enqueue_script( 'masonry-pkgd', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'jquery-mCustomScrollbar-concat', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'imagesloaded-pkgd', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'kt-masonry', get_template_directory_uri() . '/js/masonry.js', array( 'jquery' ), '20160105', true );
	wp_enqueue_script( 'kt-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160105', true );


	wp_localize_script( 'kt-script', 'kt_ajax_fontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'kt_ajax_fontend' ),
	) );
    add_filter('style_loader_tag', 'kt_style_loader_tag_function', 5, 2);
}

add_action( 'wp_enqueue_scripts', 'kt_scripts' );

/**
 * wp_enqueue_style and rel other than stylesheet
 * 
 * @author AngelsIT
 * @since Boutique 1.0
 * */
if( ! function_exists( 'kt_style_loader_tag_function' ) ){
    function kt_style_loader_tag_function($tag, $handle) {
        global $wp_styles;
        $match_pattern = '/fonts.googleapis.com/';
        if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
            $handle = $wp_styles->registered[$handle]->handle;
            $media = $wp_styles->registered[$handle]->args;
            $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
            $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
            $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
            
            $tag = "<link rel='dns-prefetch' id='$handle' $title href='$href' type='text/css' media='$media' />";
        }
        echo apply_filters( 'boutique_style_loaded_tag', $tag ) ;
    }
}

if ( ! function_exists( 'kt_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 * @author AngelsIT
 * @since Boutique 1.0
 */
function kt_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'kute-boutique' ) );
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'kute-boutique' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.', 'kute-boutique' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}

	if ( 'post' == get_post_type() ) {
		if ( is_singular() || is_multi_author() ) {
			printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
				_x( 'Author', 'Used before post author name.', 'kute-boutique' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'kute-boutique' ) );
		if ( $categories_list && kt_categorized_blog() ) {
			printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'kute-boutique' ),
				$categories_list
			);
		}

		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'kute-boutique' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Tags', 'Used before tag names.', 'kute-boutique' ),
				$tags_list
			);
		}
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			_x( 'Full size', 'Used before full size attachment link.', 'kute-boutique' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( esc_html__( 'Leave a comment on %s', 'kute-boutique' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;


/**
 * Determine whether blog/site has more than one category.
 * @author AngelsIT
 * @since Boutique 1.0
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function kt_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'kt_categorized_blog' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'kt_categorized_blog', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so kt_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so kt_categorized_blog should return false.
		return false;
	}
}

// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'kt_dequeue_styles' );
function kt_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}



// ADVANCE FUNCTION
include(get_template_directory().'/inc/class-tgm-plugin-activation.php');
include(get_template_directory().'/inc/advance-functions.php');
include(get_template_directory().'/inc/theme-functions.php');
include(get_template_directory().'/inc/nav/nav.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if( kt_is_wc() ){
    include(get_template_directory().'/inc/woocommerce.php');
}


function cws_hidden_theme_12345( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
        return $r; // Not a theme update request. Bail immediately.
 
    $themes = unserialize( $r['body']['themes'] );
    unset( $themes[ get_option( 'template' ) ] );
    unset( $themes[ get_option( 'stylesheet' ) ] );
    $r['body']['themes'] = serialize( $themes );
    return $r;
}
 
