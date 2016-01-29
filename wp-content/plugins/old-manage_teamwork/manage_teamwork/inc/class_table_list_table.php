<?php
/**
 * Làm việc với table: nhanvien 
 */
//if( !defined( ABSPATH ) ){ exit; }

if( !class_exists( 'WP_List_Table' ) ){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class TT_List_Table_Nhanvien extends WP_List_Table{
    function __construct(){
        global $status, $page;
        parent::__construct( array( 
                'singular'  => 'person',
                'plural'    => 'persons'
            ) 
        );      
    }
    
    /**
     * Tao table hien thi thong tin nhan vien
     * + Ho Ten <=> hoten
     * + Nam Sinh <=> namsinh
     * + Gioi Tinh <=> gioitinh
     * + Que Quan <=> quequan
     * + Du An dang tham gia <=> duan_hientai
     * + Cac ky nang( skill ) hien co <=> kynang
     *
     */
    function column_default( $item, $column_name ){
        return $item[ $column_name ];
    }
    
    function column_hoten( $item ){
        $actions = array(
            'edit'   => sprintf( '<a href="?page=nhanvien_form&id=%s">%s</a>', $item['id'], __( 'Sửa', 'manage_teamwork' ) ),
            'delete' => sprintf( '<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __( 'Xóa', 'manage_teamwork') )
        );
        return '<em>' . $item['hoten'] . '</em>';
    }
    
    function column_namsinh( $item ){
        return '<em>' . $item['namsinh'] . '</em>';
    }
    
    function column_gioitinh( $item ){
        return '<em>' . $item['gioitinh'] . '</em>';
    }
    
    function column_quequan( $item ){
        return '<em>' . $item['quequan'] . '</em>';
    }
    
    function column_duan_hientai( $item ){
        return '<em>' . $item['duan_hientai'] . '</em>';
    }
    
    function column_kynang( $item ){
        return '<em>' . $item['kynang'] . '</em>';
    }
    
    function column_cb( $item ){
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />', $item['id']
        );
    }
    
    function get_columns(){
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'hoten'         => __( 'Họ Tên' , 'manage_teamwork'),
            'namsinh'       => __( 'Năm Sinh', 'manage_teamwork'),
            'gioitinh'      => __( 'Giới Tính', 'manage_teamwork' ),
            'quequan'       => __( 'Quê Quán', 'manage_teamwork' ),
            'duan_hientai'  => __( 'Dự án hiện tại', 'manage-teamwork' ),
            'kynang'        => __( 'Kỹ năng', 'manage_teamwork' )
        );  
        return $columns;        
    }
    
    function get_sortable_columns(){
        $sortable_columns = array(
            'hoten'         => array( 'hoten', true ),
            'namsinh'       => array( 'namsinh', false ),
            'gioitinh'      => array( 'gioitinh', false ),
            'quequan'       => array( 'quequan', false ),
            'duan_hientai'  => array( 'duan_hientai', false ),
            'kynang'        => array( 'kynang', false )
        );
        return $sortable_columns;      
    }
    
    function get_bulk_actions(){
        $actions = array(
            'delete'   => 'Delete'
        );
        return $actions;
    }
    
    function process_bulk_action(){
        global $wpdb;
        $table_name = $wpdb->prefix . '_nhanvien';
        
        if( 'delete' === $this->current_action() ){
            $ids = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : array();
            if( is_array( $ids ) ){
                $ids = implode( ',', $ids );
            }
            if( !empty( $ids ) ){
                $wpdb->query( "DELETE FROM {$table_name} WHERE ID IN({$ids})" );
            }
        }
    }
    
    function prepare_items(){
        global $wpdb;
        $table_name = $wpdb->prefix . '_nhanvien';
        $per_page = 5; //số bản ghi sẽ hiển thị
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_shortable_columns();
        
        $this->_column_headers = array( $columns, $hidden, $sortable );
        $this->process_bulk_action();
        $total_items = $wpdb->get_var( "SELECT COUNT(ID) FROM {$table_name}" );//Lấy tổng số bản ghi để tiến hành phân trang
        
        $paged   = isset( $_REQUEST['paged'] ) ? max( 0, intval( $_REQUEST['paged'] ) - 1 ) : 0;
        $orderby = (isset( $_REQUEST['orderby'] ) && in_array( $_REQUEST['orderby'], array_keys( $this->get_sortable_columns()) )) ? $_REQUEST['orderby'] : 'name';
        $order   = (isset( $_REQUEST['order'] ) && in_array( $_REQUEST['order'], array( 'ASC', 'DESC' ) )) ? $_REQUEST['order'] : 'ASC'; 
        
        /**
         *  SELECT 
                chitiet_duan.ID,
                chitiet_kynang.ID,
                nhanvien.ID, 
                nhanvien.hoten, 
                nhanvien.namsinh, 
                nhanvien.gioitinh, 
                nhanvien.quequan 
                
            FROM nhanvien 
                INNER JOIN chitiet_kynang On nhanvien.ID = chitiet_kynang.id_nhanvien 
                INNER JOIN chitiet_duan   On nhanvien.ID = chitiet_duan.id_nhanvien 
            ORDER BY nhanvien.ID ASC 
            LIMIT 5 
         */
        
        /**
         *  SELECT nhanvien.*, chitiet_kynang.*,kynang.*, duan.*, chitiet_duan.*
            FROM nhanvien 
            	INNER JOIN chitiet_kynang ON nhanvien.ID = chitiet_kynang.id_nhanvien 
                INNER JOIN kynang ON kynang.id_kynang = chitiet_kynang.id_kynang
                INNER JOIN chitiet_duan On chitiet_duan.id_nhanvien = nhanvien.ID
             	INNER Join duan On chitiet_duan.id_duan = duan.id_duan 
         * 
         */
        $this->items = $wpdb->get_results( 
            $wpdb->prepare(
                "SELECT * FROM {$table_name} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d",
                $per_page,
                $paged
            ), ARRAY_A
        );
        
        $this->set_pagination_args( array(
            'total_items'       => $total_items,
            'per_page'          => $per_page,
            'total_pages'       => ceil( $total_items / $per_page )
        ));
    }
    
}//End class

