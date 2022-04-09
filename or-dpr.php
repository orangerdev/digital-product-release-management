<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ridwan-arifandi.com
 * @since             1.0.0
 * @package           ORDPR
 *
 * @wordpress-plugin
 * Plugin Name:       Orange - Digital Product Release Managmenet
 * Plugin URI:        https://ridwan-arifandi.com
 * Description:       Digital product release management
 * Version:           1.0.0
 * Author:            Ridwan Arifandi
 * Author URI:        https://ridwan-arifandi.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       or-dpr
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
define( 'ORDPR_VERSION',		'1.0.0' );
define( 'ORDPR_MODE',	  		'production'); // remember to switch back to 'production' when you push this file
define( 'ORDPR_DIR', 			plugin_dir_path(__FILE__) );
define( 'ORDPR_URL', 			plugin_dir_url( __FILE__ ) );

define( 'ORDPR_PRODUCT_CPT',	'ordpr-product');
define( 'ORDPR_RELEASE_CPT',	'ordpr-release');
define( 'ORDPR_PRODUCT_TAG_CT',	'ordpr-product-tag');

if( file_exists( ORDPR_DIR . 'vendor/autoload.php' ) ) {
	require_once( ORDPR_DIR . 'vendor/autoload.php' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-or-dpr-activator.php
 */
function activate_or_dpr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-or-dpr-activator.php';
	ORDPR_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-or-dpr-deactivator.php
 */
function deactivate_or_dpr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-or-dpr-deactivator.php';
	ORDPR_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_or_dpr' );
register_deactivation_hook( __FILE__, 'deactivate_or_dpr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-or-dpr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_or_dpr() {

	$plugin = new ORDPR();
	$plugin->run();

}

if(!function_exists('__debug')) :
	function __debug() {
		$bt     = debug_backtrace();
		$caller = array_shift($bt);
		$args   = [
			"file"  => $caller["file"],
			"line"  => $caller["line"],
			"args"  => func_get_args()
		];

		if ( class_exists( 'WP_CLI' ) ) :
			?><pre><?php print_r($args); ?></pre><?php
		else :
			do_action('qm/info', $args);
		endif;
	}
endif;

if(!function_exists('__print_debug')) :
	function __print_debug() {
		$bt     = debug_backtrace();
		$caller = array_shift($bt);
		$args   = [
			"file"  => $caller["file"],
			"line"  => $caller["line"],
			"args"  => func_get_args()
		];

		if('production' !== ORDPR_MODE) :
			?><pre><?php print_r($args); ?></pre><?php
		endif;
	}
endif;

$UpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/orangerdev/digital-product-release-management',
	__FILE__,
	'digital-product-release-management'
);

run_or_dpr();
