<?php
/**
 * Maui Marketing - MMTF
 *
 * @wordpress-plugin
 * Plugin Name:  MM Tour Filtering
 * Plugin URI:   https://hawaiitours.com/
 * Description:  Custom functionality
 * Version:      0.0.2
 * Author URI:   https://mauimarketing.com/
 */

/**
 * Plugin File
 * 
 * The filename of the main plugin file including the path.
 * Used for plugin activation/deactivation hooks.
 * 
 * @var string
 */
define( 'MauiMarketing\MMTF\PLUGIN_FILE',  __FILE__ );

/**
 * Plugin ID
 * 
 * The filename of the main plugin file relative to the plugins directory.
 * 
 * @var string
 */
define( 'MauiMarketing\MMTF\PLUGIN_ID',  plugin_basename( __FILE__ ) );

/**
 * Plugin URL
 * 
 * Full URL of the main plugin folder
 * Has a trailing slash.
 * 
 * @var string
 */
define( 'MauiMarketing\MMTF\PLUGIN_URL', plugin_dir_url(  __FILE__ ) );

/**
 * Plugin path
 * 
 * Full path of the main plugin folder
 * Has a trailing slash.
 * 
 * @var string
 */
define( 'MauiMarketing\MMTF\PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define('MM_AVIA_TEMPLATE_FILE', get_template_directory() . '/config-templatebuilder/avia-template-builder/php');
//
if (MM_AVIA_TEMPLATE_FILE) {
    if (file_exists(MM_AVIA_TEMPLATE_FILE . '/shortcode-template.class.php')) {
        require_once( MM_AVIA_TEMPLATE_FILE . '/shortcode-template.class.php');
    }else{
        require_once( MM_AVIA_TEMPLATE_FILE . '/class-shortcode-template.php');
    }
}

/* Include all the .php files in the /includes/ folder */
foreach( glob( plugin_dir_path( __FILE__ ) . 'includes/' . "*.php" ) as $file ){   
    require_once( "$file" ); 
}

// /* Autoload the classes */
$namespaces = [
    "MauiMarketing\\MMTF\\" => "classes",
];

MauiMarketing\MMTF\Core\Autoloader\load_package( __DIR__, $namespaces );
