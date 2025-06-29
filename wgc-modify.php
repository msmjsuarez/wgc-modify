<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://worldgolfcompetition.com
 * @since             1.0.0
 * @package           Wgc_Modify
 *
 * @wordpress-plugin
 * Plugin Name:       WGC Modify
 * Plugin URI:        https://worldgolfcompetition.com
 * Description:       This plugin is for WGC customization.
 * Version:           1.0.0
 * Author:            MJ
 * Author URI:        https://worldgolfcompetition.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wgc-modify
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
define( 'WGC_MODIFY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wgc-modify-activator.php
 */
function activate_wgc_modify() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wgc-modify-activator.php';
	Wgc_Modify_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wgc-modify-deactivator.php
 */
function deactivate_wgc_modify() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wgc-modify-deactivator.php';
	Wgc_Modify_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wgc_modify' );
register_deactivation_hook( __FILE__, 'deactivate_wgc_modify' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wgc-modify.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wgc_modify() {

	$plugin = new Wgc_Modify();
	$plugin->run();

}
run_wgc_modify();
