<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package KuteTheme
 * @subpackage Boutique
 * @since Boutique 1.0
 */

get_header(); 
?>
<?php
// Blog layout
$kt_blog_layout = kt_option('kt_blog_layout','left');

// Blog setting
$kt_blog_list_style = kt_option('kt_blog_list_style','list');
$kt_blog_list_columns = kt_option('kt_blog_list_columns',3);

// GET SETTINGS DEMO
if( isset( $_GET['layout'])){
    $kt_blog_layout = $_GET['layout'];
}

if( isset( $_GET['liststyle'])){
    $kt_blog_list_style = $_GET['liststyle'];
}


// Main container class
$main_container_class = array();
$main_container_class[] = 'main-container';
if( $kt_blog_layout == 'full'){
    $main_container_class[] = 'no-sidebar';
}else{
    $main_container_class[] = $kt_blog_layout.'-slidebar';
}


$main_content_class = array();
$main_content_class[] = 'main-content';
if( $kt_blog_layout == 'full' ){
    $main_content_class[] ='col-sm-12';
}else{
    $main_content_class[] = 'col-md-9 col-sm-8';
}

$slidebar_class = array();
$slidebar_class[] = 'sidebar';
if( $kt_blog_layout != 'full'){
    $slidebar_class[] = 'col-md-3 col-sm-4';
}
?>
<div class="<?php echo esc_attr( implode(' ', $main_container_class) );?>">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr( implode(' ', $main_content_class) );?>">
                <?php
                while (have_posts()): the_post();
                get_template_part( 'templates/blogs/blog','single' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                endwhile;
                ?>
            </div>
            <?php if( $kt_blog_layout != "full" ):?>
            <div class="<?php echo esc_attr( implode(' ', $slidebar_class) );?>">
                <?php get_sidebar();?>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<?php get_footer(); ?>