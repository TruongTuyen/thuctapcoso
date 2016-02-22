
<?php
add_action('init', 'kt_StartSession', 1);
function kt_StartSession() {
    if(!session_id()) {
        session_start();
    }
}
// Remove woocommerce_template_loop_product_link_open 
remove_action('woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10);
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
// Remove star 
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );
// Custom product thumb
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
add_action('woocommerce_before_shop_loop_item_title','kt_template_loop_product_thumbnail',10);

if( !function_exists('kt_template_loop_product_thumbnail')){

	function kt_template_loop_product_thumbnail(){
		global $product;  
		$thumb_inner_class = array('thumb-inner');
		$kt_using_two_image = kt_option('kt_using_two_image','yes');
		$back_image = '';
		if( $kt_using_two_image =="yes"){

			$attachment_ids = $product->get_gallery_attachment_ids();
	        if( $attachment_ids ){
	            $back_image = wp_get_attachment_image( $attachment_ids[0], 'shop_catalog' );
	        }
	        if( $back_image ){
	        	$thumb_inner_class[] = 'has-back-image';
	        }
		}
		ob_start();
		?>
		<div class="<?php echo esc_attr( implode(' ', $thumb_inner_class) );?>">
			<a href="<?php the_permalink();?>">
			<?php if( $back_image ):?>
			<span class="back-image"><?php echo $back_image; ?></span>
			<?php endif;?>
			<?php echo woocommerce_template_loop_product_thumbnail();?>
			</a>
		</div>
		
		<?php
		echo ob_get_clean();
	}
}

// Custom product name
remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title');
add_action('woocommerce_shop_loop_item_title','kt_template_loop_product_title',10);

if( !function_exists('kt_template_loop_product_title')){
	function kt_template_loop_product_title(){
		$title_class = array('product-name'); 
		$kt_short_product_name = kt_option('kt_short_product_name','yes');
		if( $kt_short_product_name == 'yes' ){
			$title_class[] = 'short';
		}
		?>
		<h3 class="<?php echo esc_attr( implode(' ', $title_class) );?>"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
		<?php
	}
}

// Custom shop top control
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action('woocommerce_before_shop_loop','kt_shop_top_control',1);
if(!function_exists( 'kt_shop_top_control')){
	function kt_shop_top_control(){
		?>
		<div class="shop-top">
			<div class="shop-top-left">
				<h1 class="shop-title"><?php woocommerce_page_title();?></h1>
			</div>
			<div class="shop-top-right">
				<?php woocommerce_result_count();?>
				<div class="orderby-wapper">
					<?php woocommerce_catalog_ordering();?>
				</div>
				<?php kt_shop_view_more();?>
			</div>
		</div>
		<?php
	}
}
// Custom shop view more
if( !function_exists( 'kt_shop_view_more')){
	function kt_shop_view_more(){
		$shop_display_mode = 'grid';
		if( isset($_SESSION['shop_display_mode'])){
			$shop_display_mode = $_SESSION['shop_display_mode'];
		}
		?>
		<div class="show-grid-list">
            <span class="label-filter"><?php esc_html_e('VIEW:','kute-boutique');?></span>
            <a data-mode="grid" class="show-grid display-mode <?php if($shop_display_mode =="grid"):?>active<?php endif;?>" href="#"><i class="fa fa-th"></i></a>
            <a data-mode="list" class="show-list display-mode <?php if($shop_display_mode =="list"):?>active<?php endif;?>" href="#"><i class="fa fa-list"></i></a>
        </div>
		<?php
	}
}

// Custom product per page
// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page','kt_loop_shop_per_page', 20 );
if(!function_exists( 'kt_loop_shop_per_page')){
	function kt_loop_shop_per_page(){
		$kt_woo_products_perpage = kt_option('kt_woo_products_perpage','12');
		return $kt_woo_products_perpage;
	}
}

/*----------------------
Product view style
----------------------*/
if( ! function_exists( 'wp_ajax_fronted_set_products_view_style_callback' ) ){
    function  wp_ajax_fronted_set_products_view_style_callback(){
        check_ajax_referer( 'kt_ajax_fontend', 'security' );
        $mode = $_POST['mode'];
        $_SESSION['shop_display_mode'] = $mode;
        die();
    }
}

add_action( 'wp_ajax_fronted_set_products_view_style', 'wp_ajax_fronted_set_products_view_style_callback' );
add_action( 'wp_ajax_nopriv_fronted_set_products_view_style', 'wp_ajax_fronted_set_products_view_style_callback' );


// Short Product descript
add_action('woocommerce_after_shop_loop_item_title','kt_product_short_descript',15);
if( !function_exists('kt_product_short_descript')){
	function kt_product_short_descript(){
		global $post;
		$shop_display_mode = 'grid';
		if( isset($_SESSION['shop_display_mode'])){
			$shop_display_mode = $_SESSION['shop_display_mode'];
		}
		if(is_shop() || is_product_category() || is_product_tag()){
			if ( ! $post->post_excerpt ) return;
			if( $shop_display_mode =="grid") return;
			?>
			<div class="short-descript">
				<?php the_excerpt(); ?>
			</div>
			<?php
		}
	}
}
// Custom rating_html
add_filter("woocommerce_product_get_rating_html", "kt_get_rating_html", 10, 2);
if( !function_exists( 'kt_get_rating_html ')){
	function kt_get_rating_html($rating_html, $rating){
	    $rating_html = '';
	    global $product;
	    if ( ! is_numeric( $rating ) ) {
	        $rating = $product->get_average_rating();
	    }
	    //if($rating <=0) return'';
	    $rating_html  = '<div class="rating" title="' . sprintf( esc_attr__( 'Rated %s out of 5', 'kute-boutique' ), $rating > 0 ? $rating : 0  ) . '">';
	    for($i = 0; $i < 5 ; $i++){
	        if($rating > $i && $rating > 0 ){
	            if( ( $rating - $i ) > 0 && ( $rating - $i ) < 1 ){
	                $rating_html .= '<i class="fa fa-star-half-o"></i>';    
	            }else{
	                $rating_html .= '<i class="fa fa-star"></i>';
	            }
	        }else{
	            $rating_html .= '<i class="fa fa-star-o"></i>';
	        }
	    }
	    $rating_html .= '</div>';
	    return $rating_html;
	}
}

// Custom flash icon
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10);
if(!function_exists( 'kt_group_flash')){
	function kt_group_flash(){
		?>
		<div class="status">
			<?php 
			kt_show_product_loop_new_flash();
			woocommerce_show_product_loop_sale_flash();
			?>
		</div>
		<?php
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'kt_group_flash', 5 );

// New flash
if ( ! function_exists( 'kt_show_product_loop_new_flash' ) ) {
	/**
	 * Get the sale flash for the loop.
	 *
	 * @subpackage	Loop
	 */
	function kt_show_product_loop_new_flash() {
		wc_get_template( 'loop/new-flash.php' );
	}
}

// REMOVE DEFAULT TITLE
add_filter( 'woocommerce_show_page_title' , 'kt_woo_hide_page_title' );
function kt_woo_hide_page_title() {
	return false;
}

// Custom shop banner
add_action( 'woocommerce_before_main_content', 'kt_shop_banner', 1 );
if( !function_exists('kt_shop_banner')){
	function kt_shop_banner(){
		$banners = array();
		if( is_shop() ){
			$kt_shop_banner = kt_option('kt_shop_banner','');
			if( $kt_shop_banner ){
				foreach( $kt_shop_banner as $b){
					array_push($banners, $b);
				}
			}
		}elseif( is_product_category() ){
			if ( !is_plugin_active( 'boutique-toolkit/boutique-toolkit.php' ) ) {
	          //plugin is activated
	            return false;
	        } 
	        $cate = get_queried_object();
	        
	        $cateID = $cate->term_id;
	        
	        $category_slider = get_tax_meta( $cateID, 'kt_category_slider' );

	        if( $category_slider){
	        	$banners = explode( '|', $category_slider['url'] );
	        }
		}elseif( is_product() ){
			$kt_shop_banner = kt_option('kt_shop_single_banner','');
			if( $kt_shop_banner ){
				foreach( $kt_shop_banner as $b){
					array_push($banners, $b);
				}
			}
		}
		?>
		<?php if( $banners ):?>
		<div class="shop-banner">
			<?php if(count($banners) > 1):?>
				<div class="owl-carousel nav-center-center nav-style5" data-loop="true" data-autoplay="true" data-nav="true" data-dots="false" data-animateout="fadeOut" data-animatein="fadeIn" data-responsive='{"0":{"items":1,"nav":false},"600":{"items":1,"nav":false},"1000":{"items":1}}'>
					<?php foreach( $banners as $b):?>
						<img src="<?php echo esc_url( $b );?>" alt="">
					<?php endforeach;?>
				</div>
			<?php else:?>
				<?php foreach( $banners as $b):?>
					<img src="<?php echo esc_url( $b );?>" alt="">
				<?php endforeach;?>
			<?php endif;?>
		</div>
		<?php endif;?>
		<?php
	}
}

// Custom woocommerce_placeholder_img_src
add_filter('woocommerce_placeholder_img_src', 'kt_woocommerce_placeholder_img_src');
   
function kt_woocommerce_placeholder_img_src( $src ) {
	$width = 600;
	$height = 600;
	$name = get_bloginfo('name');
	$name = ($name == "") ? '' : $name;
	$name = strtoupper ($name);
	$shop_image_size = get_option('shop_single_image_size');
	if( $shop_image_size){
		$width = $shop_image_size['width'];
		$height = $shop_image_size['height'];
	}
	$src = 'https://placeholdit.imgix.net/~text?txtsize=30&bg=fafafa&txtclr=ccc&txt='.$name.'&w='.$width.'&h='.$height.'&txttrack=0';
	return $src;
}

/**
 * WooCommerce Extra Feature
 * --------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */ 

add_filter( 'woocommerce_output_related_products_args', 'kt_related_products_args' );
 function kt_related_products_args( $args ) {
 	$kt_related_products_perpage = kt_option('kt_related_products_perpage',4);
 	$kt_related_products_columns = kt_option('kt_related_products_columns',3);

	$args['posts_per_page'] = $kt_related_products_perpage;
	$args['columns'] = $kt_related_products_columns;

	return $args;
}

// Product single meta 
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
add_action('woocommerce_single_product_summary','woocommerce_template_single_meta',11);

// Utilities
if( ! function_exists( 'kt_utilities_single_product' ) ){
    function kt_utilities_single_product(){
        ?>
        <div class="share">
        	<a href="javascript:print();"><i class="fa fa-print"></i> <?php esc_html_e( 'Print', 'kute-boutique' );?></a>
        	<a href="<?php echo esc_url('mailto:?subject='. esc_html( get_the_title() ) );?>"><i class="fa fa-envelope-o"></i> <?php esc_html_e( 'Send to a friend', 'kute-boutique' );?></a>
        </div>
        <?php
    }   
}

add_filter( 'woocommerce_single_product_summary', 'kt_utilities_single_product', 51);


// Custom cart page
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 ); 
add_action( 'kt_cart_right', 'woocommerce_cart_totals', 1 ); 


// Checkout page
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 1 );



add_action('woocommerce_before_shop_loop','kt_before_shop_loop',1);

function kt_before_shop_loop(){

	$kt_woo_grid_column = kt_option('kt_woo_grid_column',3);
	$kt_woo_ipad_grid_column = kt_option('kt_woo_ipad_grid_column',2);
	$kt_woo_mobile_grid_column = kt_option('kt_woo_mobile_grid_column',1);

	if( isset($_GET['columns']) && in_array($_GET['columns'],array(2,3,4))){
		$kt_woo_grid_column = $_GET['columns'];
	}
	if( isset($_GET['tablet_columns']) && in_array($_GET['tablet_columns'],array(2,3,4))){
		$kt_woo_ipad_grid_column = $_GET['tablet_columns'];
	}
	if( isset($_GET['mobile_columns']) && in_array($_GET['mobile_columns'],array(2,3,4))){
		$kt_woo_mobile_grid_column = $_GET['mobile_columns'];
	}
	
	$class = array('product-list-grid');
	$class[] ='desktop-columns-'.$kt_woo_grid_column;
	$class[] ='tablet-columns-'.$kt_woo_ipad_grid_column;
	$class[] ='mobile-columns-'.$kt_woo_mobile_grid_column;
	?>
	<div class="<?php echo esc_attr( implode(' ', $class) );?>">
	<?php
}
add_action('woocommerce_after_shop_loop','kt_after_shop_loop',1);
function kt_after_shop_loop(){
	echo "</div>";
}


add_filter( 'woocommerce_breadcrumb_defaults', 'kt_woocommerce_breadcrumbs' );
function kt_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' &#47; ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'kute-boutique' ),
    );
}