<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://worldgolfcompetition.com/
 * @since      1.0.0
 *
 * @package    Wgc_Modify
 * @subpackage Wgc_Modify/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wgc_Modify
 * @subpackage Wgc_Modify/includes
 * @author     MJ <mj.layasan@worldgolfcompetition.com>
 */
class Wgc_Modify_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wgc-modify',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
