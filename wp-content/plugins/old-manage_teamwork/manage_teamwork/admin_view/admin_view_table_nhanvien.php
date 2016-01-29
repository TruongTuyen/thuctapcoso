<?php
class Table_Nhanvien_Admin_View{
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'table_admin_menu') );
    }
    
    function table_admin_menu(){
        add_menu_page( __( 'Nhân Viên', 'manage_teamwork' ), __( 'Nhân Viên', 'manage_teamwork' ), 'activate_plugins', 'nhanvien', array( $this,'nhanvien_page_handler' ) );
        add_submenu_page( 'nhanvien', __( 'Nhân Viên', 'manage_teamwork' ), __( 'Nhân Viên', 'manage_teamwork' ), 'activate_plugins', 'nhanvien', array( $this, 'nhanvien_page_handler' ) );
        add_submenu_page( 'nhanvien', __( 'Thêm Mới', 'manage_teamwork' ), __( 'Thêm Mới', 'manage_teamwork' ), 'activate_plugins', 'nhanvien_form', array( $this,'nhanvien_form_page_handler') );
        
    }
    
    public function nhanvien_page_handler(){
        global $wpdb;
        $table = new TT_List_Table_Nhanvien();
        $table->prepare_items();
        
        $message = '';
        
        if( 'delete' === $table->current_action() ){
            $message = '<div class="updated bellow-h2" id="message"><p>'. sprintf( __( 'Đã xóa: %d', 'manage_teamwork' ), count( $_REQUEST['id'] ) ) .'</p></div>';
        }
        ?>
        <div class="wrap">
            <div class="icon32 icon32-posts-post" id="icon-edit"><br /></div>
            <h2><?php _e( 'Nhân viên', 'manage_teamwork' ); ?><a class="add-new-h2" href="<?php echo get_admin_url( get_current_blog_id(), 'admin.php?page=nhanvien_form' ); ?>"><?php _e( 'Thêm Mới', 'manage_teamwork' ); ?></a></h2>
            <?php echo $message; ?>
            
            <form id="nhanvien-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
                <?php $table->display(); ?>
            </form>
        </div>
        
 <?php       
    }//function nhanvien_page_handler()
    
    
    
}

new Table_Nhanvien_Admin_View();