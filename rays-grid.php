<?php
/*
  Plugin Name: RAYS Grid
  Plugin URI: https://www.it-rays.org/raysgrid
  Description: WordPress Plugin for showing Grids with Custom Styles.
  Version: 1.0.0
  Author: IT-RAYS
  Author URI: https://www.it-rays.org/
  License: GPLv2
 */

// if called directly, abort.
if (!defined('WPINC')) { die; }

class raysgrid_globals {
    
    public $rsgd_name = 'RAYS Grid';
    public $rsgd_slug = 'raysgrid';
    public $rsgd_prefix = 'raysgrid';
    public $rsgd_table = 'raysgrid_setting';
    
    public function __construct() {
        
        $this->rsgd_constants();
        $this->rsgd_include_files();
        $this->rsgd_init();
        
    }
    
    public function rsgd_init () {
        
        add_action( 'plugins_loaded', array( &$this, 'rsgd_localize_plugin' ) );
        if(is_admin()){
            register_activation_hook( __FILE__, array('raysgrid_Tables', 'rsgd_AddSQL') );
            register_uninstall_hook( __FILE__, array('raysgrid_Base', 'rsgd_uninstall') );
        }
    }
    
    public function rsgd_constants () {
        
        global $table_prefix;
        $rsgd_settings_tbl = $table_prefix . $this->rsgd_table;
        
        defined( 'RSGD_DIR' ) or define ( 'RSGD_DIR', plugin_dir_path(__FILE__) );
        defined( 'RSGD_URI' ) or define ( 'RSGD_URI', plugin_dir_url(__FILE__) );
        define ( 'RSGD_NAME', $this->rsgd_name );
        define ( 'RSGD_SLUG', $this->rsgd_slug );
        define ( 'RSGD_PFX',  $this->rsgd_prefix );
        define ( 'RSGD_TBL',  $rsgd_settings_tbl );  
          
    }
    
    public function rsgd_include_files () {
        
        require_once( RSGD_DIR . '/includes/class-db.php' ); 
        require_once( RSGD_DIR . '/includes/config.php' );
        require_once( RSGD_DIR . '/includes/class-base.php' );
        require_once( RSGD_DIR . '/includes/display-field.php' );
        require_once( RSGD_DIR . '/includes/global-functions.php' );
        require_once( RSGD_DIR . '/includes/admin/vc/raysgrid.php' );
        require_once( RSGD_DIR . '/includes/public/shortcode.php' );
        
    }
    
    public function rsgd_localize_plugin () {
        
        load_plugin_textdomain( RSGD_SLUG, false, RSGD_DIR . '/languages' );
        
    }

}
new raysgrid_globals();
