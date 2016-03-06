<?php
class Table_Nhanvien_Admin_View{
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'table_admin_menu') );
    }
    
    function table_admin_menu(){
        add_menu_page( __( 'Nhân Viên', 'manage_teamwork' ), __( 'Nhân Viên', 'manage_teamwork' ), 'activate_plugins', 'nhanvien', array( $this,'nhanvien_page_handler' ) );
        add_submenu_page( 'nhanvien', __( 'Nhân Viên', 'manage_teamwork' ), __( 'Nhân Viên', 'manage_teamwork' ), 'activate_plugins', 'nhanvien', array( $this, 'nhanvien_page_handler' ) );
        add_submenu_page( 'nhanvien', __( 'Thêm Mới Nhân Viên', 'manage_teamwork' ), __( 'Thêm Mới Nhân Viên', 'manage_teamwork' ), 'activate_plugins', 'nhanvien_form', array( $this,'nhanvien_form_page_handler') );
        
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
            <h2><?php _e( 'Nhân viên', 'manage_teamwork' ); ?><a class="add-new-h2" href="<?php echo get_admin_url( get_current_blog_id(), 'admin.php?page=nhanvien_form' ); ?>"><?php _e( 'Thêm Mới Nhân Viên', 'manage_teamwork' ); ?></a></h2>
            <?php echo $message; ?>
            
            <form id="nhanvien-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
                <?php $table->display(); ?>
            </form>
        </div>
        
 <?php       
    }//function nhanvien_page_handler()
    
    public function nhanvien_form_page_handler(){
        global $wpdb;
        $table_name = $wpdb->prefix . '_nhanvien';
        $message    = '';
        $notice     = '';
        
        //List cac truong du lieu mac dinh se them du lieu
        $default = array(
            'ID'        => 0,
            'hoten'     => '', 
            'namsinh'   => '',
            'gioitinh'  => '', 
            'quequan'   => '',
        );
        
        if( wp_verify_nonce( $_REQUEST['nonce'], basename( __FILE__ ) ) ){
            $item  = shortcode_atts( $default, $_REQUEST );
            $item_valid = $this->tt_validate_nhanvien( $item );
            if( $item_valid === true ){
                $item['namsinh'] = "YEAR(" . $item['namsinh'] . ")";
                if( $item['ID'] == 0 ){ //Them moi du lieu
                    $result = $wpdb->insert( $table_name, $item );
                    $item['ID'] = $wpdb->insert_id;
                    if( $result ){
                        $message = __( 'Thêm thành công', 'manage_teamwork' );
                    }else{
                        $message = __( 'Xảy ra lỗi trong quá trình thêm mới dữ liệu', 'manage_teamwork' );
                    }
                }else{//update du lieu
                    $result = $wpdb->update( $table_name, $item, array( 'ID' => $item['ID'] ));
                    if( $result ){
                        $message = __( 'Sửa thành công', 'manage_teamwork' );
                    }else{
                        $message = __( 'Xảy ra lỗi trong quá trình cập nhật dữ liệu', 'manage_teamwork' );
                    }
                }
            }else{//Dữ liệu không hợp lệ
                $notice = $item_valid;
            }
        }else{ //Khong co nonce
            $item = $default;
            if( isset( $_REQUEST['ID'] )){
                $item = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE ID = %d", $_REQUEST['ID'], ARRAY_A ));
                if( !$item ){
                    $item = $default;
                    $notice = __( "Không tìm thấy dữ liệu", "manage_teamwork" );
                }
            }
        }
        
        //Them metabox
        //add_meta_box( 'nhanvien_form_meta_box', 'Thông tin nhân viên', array( $this, 'nhanvien_form_meta_box_handler' ), 'nhanvien', 'normal', 'defaul' );
        
        ?>
        <div class="wrap">
            <div class="icon32 icon32-posts-post" id="icon-edit"><br /></div>
            <h2><?php _e( "Nhân viên", 'manage_teamwork'); ?>
                <a class="add-new-h2" href="<?php echo get_admin_url( get_current_blog_id(), 'admin.php?page=nhanvien') ?>"><?php _e( "Quay lại danh sách", "manage_teamwork"); ?></a>
            </h2>
            <?php if( !empty( $notice ) ) : ?>
                <div id="notice" class="error"><p><?php echo $message; ?></p></div>
            <?php endif; //empty $notice ?>
            <?php if( !empty( $message )) : ?>
                <div id="message" class="updated"><p><?php echo $message; ?></p></div>
            <?php endif; //empty $message ?>
            <form id="form" method="POST">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
                <input type="hidden" name="ID" value="<?php echo $item['ID'];//Để biết action là insert hay update dựa vào giá trị của ID :0-->insert, !=0 -->update ?>" />
                <div class="metabox-holder" id="poststuff">
                    <div id="post-body">
                        <div id="post-body-content">
                            <?php //echo do_meta_boxes( 'nhanvien', 'normal', $item ); ?>
                            <?php //thêm mới ?>
                                <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
                                    <tbody>
                                        <tr class="form-field">
                                            <th valign="top" scope="row">
                                                <label form="hoten"><?php _e( 'Họ Tên', 'manage_teamwork' ); ?></label>
                                            </th>
                                            <td>
                                                <input id="hoten" name="hoten" type="text" style="width: 65%" value="<?php echo esc_attr($item['hoten'])?>"
                                                       size="50" class="code" placeholder="<?php _e( 'Họ Tên', 'manage_teamwork' )?>" required>
                                            </td>
                                        </tr>
                                        <tr class="form-field">
                                            <th valign="top" scope="row">
                                                <label form="namsinh"><?php _e( 'Năm Sinh', 'manage_teamwork' ); ?></label>
                                            </th>
                                            <td>
                                                <input id="namsinh" name="namsinh" type="number" style="width: 65%" value="<?php echo esc_attr($item['namsinh'])?>" required>
                                            </td>
                                        </tr>
                                        <tr class="form-field">
                                            <th valign="top" scope="row">
                                                <label form="gioitinh"><?php _e( 'Giới Tính', 'manage_teamwork' ); ?></label>
                                            </th>
                                            <td>
                                                <input id="gioitinh" name="gioitinh" type="radio"  value="1" size="50"  placeholder="<?php _e( 'Nam', 'manage_teamwork' )?>" <?php if( $item['gioitinh'] === 1 ){ echo 'checked="checked"'; } ?>/>Nam
                                                <input id="gioitinh" name="gioitinh" type="radio"  value="2" size="50"  placeholder="<?php _e( 'Nữ', 'manage_teamwork' )?>" <?php if( $item['gioitinh'] === 2 ){ echo 'checked="checked"'; } ?> />Nữ
                                            </td>
                                        </tr>
                                        <tr class="form-field">
                                            <th valign="top" scope="row">
                                                <label form="quequan"><?php _e( 'Quê quán', 'manage_teamwork' ); ?></label>
                                            </th>
                                            <td>
                                                <input id="quequan" name="quequan" type="text" style="width: 65%" value="<?php echo esc_attr($item['quequan'])?>"
                                                       size="50" class="code" placeholder="<?php _e( 'Quê quán', 'manage_teamwork' )?>" required>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php //có thể xóa ?>
                            <input type="submit" value="<?php _e( 'Gủi dữ liệu', 'manage_teamwork' ); ?>" id="submit" class="button-primary" name="submit" />
                        </div>
                    </div>
                </div><!-- poststuff-->
            </form>
        </div><!-- wrap -->
        <?php
    }//end function
    
    public function nhanvien_form_meta_box_handler( $item ){
        ?>
        <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
                <tr class="form-field">
                    <th valign="top" scope="row">
                        <label form="hoten"><?php _e( 'Họ Tên', 'manage_teamwork' ); ?></label>
                    </th>
                    <td>
                        <input id="hoten" name="hoten" type="text" style="width: 95%" value="<?php echo esc_attr($item['hoten'])?>"
                               size="50" class="code" placeholder="<?php _e( 'Họ Tên', 'manage_teamwork' )?>" required>
                    </td>
                </tr>
                <tr class="form-field">
                    <th valign="top" scope="row">
                        <label form="namsinh"><?php _e( 'Năm Sinh', 'manage_teamwork' ); ?></label>
                    </th>
                    <td>
                        <input id="namsinh" name="namsinh" type="number" style="width: 95%" value="<?php echo esc_attr($item['namsinh'])?>"
                               size="50" class="code" placeholder="<?php _e( 'Năm sinh', 'manage_teamwork' )?>" required>
                    </td>
                </tr>
                <tr class="form-field">
                    <th valign="top" scope="row">
                        <label form="gioitinh"><?php _e( 'Giới Tính', 'manage_teamwork' ); ?></label>
                    </th>
                    <td>
                        <input id="gioitinh" name="gioitinh" type="radio" style="width: 95%" value="nam" size="50" class="code" placeholder="<?php _e( 'Nam', 'manage_teamwork' )?>" />Nam
                        <input id="gioitinh" name="gioitinh" type="radio" style="width: 95%" value="nu" size="50" class="code" placeholder="<?php _e( 'Nữ', 'manage_teamwork' )?>" />Nữ
                    </td>
                </tr>
                <tr class="form-field">
                    <th valign="top" scope="row">
                        <label form="quequan"><?php _e( 'Quê quán', 'manage_teamwork' ); ?></label>
                    </th>
                    <td>
                        <input id="quequan" name="quequan" type="text" style="width: 95%" value="<?php echo esc_attr($item['quequan'])?>"
                               size="50" class="code" placeholder="<?php _e( 'Quê quán', 'manage_teamwork' )?>" required>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
    }//end function
    
    public function tt_validate_nhanvien( $item ){
        $message = array();
        if( empty( $item['hoten'])){ $message[] = __( "Hãy nhập vào họ tên", "manage_teamwork" ); }
        if( empty( $item['namsinh'])){ $message[] = __( "Hãy nhập vào năm sinh", "manage_teamwork"); }
        if( empty( $item['gioitinh'])){ $message[] = __( "Hãy chọn giới tính", "manage_teamwork"); }
        if( empty( $item['quequan'])){ $message[] = __( "Hãy nhập vào quê quán", "manage_teamwork"); }
        
        if( empty( $message ) ){
            return true;
        }
        return implode( "<br/>", $message );
    }//end function
    
    
}

new Table_Nhanvien_Admin_View();