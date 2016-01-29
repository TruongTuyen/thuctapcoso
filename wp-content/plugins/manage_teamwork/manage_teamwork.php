<?php
/**
 * Plugin Name: TT Manage Teamwork
 * Plugin URI: localhost
 * Author: Truong Tuyen Anh
 * Author URI: localhost
 * Version: 1.0
 * Text Domail: manage_teamwork
 * Description: Wordpress Plugin đơn giản demo cách viết một plugin wordpress
 */
define( 'TT_MANAGE_TEAMWORK_URI', plugin_dir_path( __FILE__) );

class TT_Manage_Teamwork{
    public static $tt_db_version = '1.0';
    
    public function __construct(){
        //register_activation_hook( __FILE__, array( $this, 'tt_table_create' ) );
        //register_activation_hook( __FILE__, array( $this, 'tt_import_dummy_data' ) );
        add_action( 'plugins_loaded', array( $this, 'tt_update_db_if_need' ) );
        
        //Require needed files
        
    }
    
    public function tt_table_create(){
        global $wpdb;
        $query = "
         CREATE TABLE {$wpdb->prefix}_duan (
                 id_duan BIGINT NOT NULL AUTO_INCREMENT,
                 tenduan VARCHAR(225) NOT NULL,
                 thoigianbatdau DATETIME NOT NULL,
                 thoigianketthuc DATETIME NOT NULL,
                 PRIMARY KEY (id_duan)   
         );
         
         CREATE TABLE {$wpdb->prefix}_nhanvien ( 
                ID BIGINT NOT NULL AUTO_INCREMENT , 
                hoten VARCHAR(225) NOT NULL , 
                namsinh DATETIME NOT NULL , 
                gioitinh TINYINT(2) NOT NULL , 
                quequan VARCHAR(225) NOT NULL , 
                PRIMARY KEY (ID)
        );
        
        CREATE TABLE {$wpdb->prefix}_chitiet_duan (
        		ID BIGINT NOT NULL AUTO_INCREMENT,
            	id_duan BIGINT NOT NULL,
            	id_nhanvien BIGINT NOT NULL,
            	ghichu TEXT NOT NULL,
            	PRIMARY KEY (ID),
            	CONSTRAINT lkngoai_chitiet_duan_01 FOREIGN KEY (id_duan) REFERENCES {$wpdb->prefix}_duan(id_duan),
             	CONSTRAINT lkngoai_chitiet_duan_02 FOREIGN KEY (id_nhanvien) REFERENCES {$wpdb->prefix}_nhanvien(ID)
        );
        
        CREATE TABLE {$wpdb->prefix}_kynang (
                 id_kynang BIGINT NOT NULL AUTO_INCREMENT,
                 tenkynang VARCHAR(225) NOT NULL,
                 chuthich TEXT NULL,
                 PRIMARY KEY (id_kynang)
         );
         
        CREATE TABLE {$wpdb->prefix}_chitiet_kynang (
        		ID BIGINT NOT NULL AUTO_INCREMENT,
            	id_kynang BIGINT NOT NULL,
            	id_nhanvien BIGINT NOT NULL,
            	ghichu TEXT NULL,
            	PRIMARY KEY (ID),
            	CONSTRAINT lkngoai_chitiet_kynang_01 FOREIGN KEY (id_kynang) REFERENCES {$wpdb->prefix}_kynang(id_kynang),
            	CONSTRAINT lkngoai_chitiet_kynang_02 FOREIGN KEY (id_nhanvien) REFERENCES {$wpdb->prefix}_nhanvien(ID)
        ); 
        ";//query for create table
        
        //Them option tt_db_version
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $query );
        add_option( 'tt_db_version', self::$tt_db_version );
    }
    
    public function tt_import_dummy_data(){
        
    }
    
    public function tt_update_db_if_need(){
        $current_db_version = get_site_option( 'tt_db_version' );
        if( $current_db_version != self::$tt_db_version ){
            $this->tt_table_create();
        }
    }
    
    public function tt_drop_table(){
        global $wpdb;
        
        $array_table = array(
            'duan',
            'nhanvien',
            'chitiet_duan',
            'kynang',
            'chitiet_kynang'
        );
        $check_foreign_key_1 = "SET FOREIGN_KEY_CHECKS=0;";
        $check_foreign_key_2 = "SET FOREIGN_KEY_CHECKS=1;";
        
        $wpdb->query( $check_foreign_key_1 );
        foreach( $array_table as $value ){
            $query = "DROP TABLE IF EXISTS {$wpdb->prefix}_{$value};";
            $wpdb->query( $query );
        }
        $wpdb->query( $check_foreign_key_2 );
    }
    
}

$manage_teamwork = new TT_Manage_Teamwork();

register_activation_hook( __FILE__, array( $manage_teamwork, 'tt_table_create' ) );
register_deactivation_hook( __FILE__, array( $manage_teamwork, 'tt_drop_table' ) );

require_once( TT_MANAGE_TEAMWORK_URI . '/inc/class_table_list_table.php' );
require_once( TT_MANAGE_TEAMWORK_URI . '/admin_view/admin_view_table_nhanvien.php' );
