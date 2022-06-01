<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://linked.in/moeeddev
 * @since             1.0.2
 * @package           Rakuten_Products
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Product Importer
 * Plugin URI:        https://linked.in/moeeddev
 * Description:       This plugin allows you to add products to WooCommerce. 
 * Version:           1.0.0
 * Author:            Moeed Ahmad
 * Author URI:        https://linked.in/moeeddev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-importer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RAKUTEN_PRODUCTS_VERSION', '1.0.0' );

function woo_prod_import_activate( $network_wide ) {
    //replace this with your dependent plugin
    $category_ext = 'categories-for-woo_prod_import/categories-for-woo_prod_import.php';

    // replace this with your version
    $version_to_check = '1.3.5'; 

    $category_error = false;

    if(file_exists(WP_PLUGIN_DIR.'/'.$category_ext)){
        $category_ext_data = get_plugin_data( WP_PLUGIN_DIR.'/'.$category_ext);
        $category_error = !version_compare ( $category_ext_data['Version'], $version_to_check, '>=') ? true : false;
    }   

    if ( $category_error ) {
        
    }

    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

	  // Write your code if WooCommerce Plugin activated.

	} else {

	  // Write your code if WooCommerce Plugin is disabled.
	  // You can display notice message in here.
		echo '<h3>'.__('Please install and activate Woo Commerce', 'ap').'</h3>';

        //Adding @ before will prevent XDebug output
        @trigger_error(__('Please install and activate Woo Commerce', 'ap'), E_USER_ERROR);

	}
}

register_activation_hook(__FILE__, 'woo_prod_import_activate');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rakuten-products-activator.php
 */
function activate_rakuten_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rakuten-products-activator.php';
	Rakuten_Products_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rakuten-products-deactivator.php
 */
function deactivate_rakuten_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rakuten-products-deactivator.php';
	Rakuten_Products_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rakuten_products' );
register_deactivation_hook( __FILE__, 'deactivate_rakuten_products' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rakuten-products.php';


add_action('admin_menu', 'test_plugin_setup_menu');
function test_plugin_setup_menu(){
	add_menu_page( 'WooCommerce Products Importer', 'Woocomerce Importer', 'edit_plugins', 'importer', 'test_init' );
}

function test_init(){
	global $rakuten_admin;
	$rakuten_admin=new Rakuten_Products_Admin();
	$rakuten_admin->show_view();
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rakuten_products() {

	$plugin = new Rakuten_Products();
	$plugin->run();

}
run_rakuten_products();



