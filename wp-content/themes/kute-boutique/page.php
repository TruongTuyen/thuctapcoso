<?php get_header();?>
<?php
// Default  layout
$kt_blog_layout = kt_option('kt_blog_layout','left');

// Page options
$kt_page_extra_class = kt_get_post_meta(get_the_ID(),'kt_page_extra_class','');
$kt_page_layout = kt_get_post_meta(get_the_ID(),'kt_page_layout','');
$kt_show_page_title = kt_get_post_meta(get_the_ID(),'kt_show_page_title','show');

if( $kt_page_layout !=""){
    $kt_blog_layout = $kt_page_layout;
}

// Main container class
$main_container_class = array();
$main_container_class[] = $kt_page_extra_class;
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
            if( have_posts()){
                while( have_posts()){
                    the_post();
                    ?>
                    <?php if( $kt_show_page_title == "show"):?>
                    <div class="page-title">
                        <h3><?php the_title(); ?></h3>
                    </div>
                <?php endif;?>
                    <div class="page-main-content">
                        <?php 
                        the_content();
                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kute-boutique' ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kute-boutique' ) . ' </span>%',
                            'separator'   => '<span class="screen-reader-text">, </span>',
                        ) );
                        ?>
                    </div>
                    <?php
                }
            }
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
<?php get_footer();?>