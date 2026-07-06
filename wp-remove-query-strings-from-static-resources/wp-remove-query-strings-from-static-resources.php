<?php
/**
 * Plugin Name:	WP Remove Query Strings From Static Resources
 * Description:	Boost your WordPress site speed by removing query strings from CSS and JS files — improve your GTmetrix, PageSpeed, and Pingdom scores instantly.
 * Author:		Rinku Yadav
 * Author URI:	https://lbcache.com
 * License:		GPLv2 or later
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.html
 * Version:		2.2
 * Requires at least: 5.0
 * Requires PHP:	7.4
 * Text Domain: wprqsfsr
 * 
 * @package     WP Remove Query Strings From Static Resources
 */

// Exit if directly accessed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin directory path.
if ( ! defined( 'WPRQSFSR_PATH' ) ) {
	define( 'WPRQSFSR_PATH', wp_normalize_path( plugin_dir_path( __FILE__ ) ) );
}

// Plugin directory URL.
if ( ! defined( 'WPRQSFSR_URL' ) ) {
	define( 'WPRQSFSR_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin file path.
if ( ! defined( 'WPRQSFSR_FILE' ) ) {
	define( 'WPRQSFSR_FILE', __FILE__ );
}

// Plugin basename.
if ( ! defined( 'WPRQSFSR_BASE_FILE' ) ) {
	define( 'WPRQSFSR_BASE_FILE', plugin_basename( __FILE__ ) );
}

// Load notice class at top level so register_deactivation_hook fires reliably.
require_once WPRQSFSR_PATH . 'inc/classes/class-wprqsfsr-notice.php';
$wprqsfsr_notice = new Wprqsfsr_Notice();

// Clear dismissed state on deactivation so notice reappears after re-activation.
register_deactivation_hook( WPRQSFSR_FILE, array( $wprqsfsr_notice, 'reset_notice' ) );

// Initialise frontend and remaining admin classes after all plugins have loaded.
add_action( 'plugins_loaded', function() {

	// Load core class — strips query strings on the frontend.
	require_once WPRQSFSR_PATH . 'inc/classes/class-wprqsfsr-core.php';
	new Wprqsfsr_Core();

	// Load plugin action links class and admin page (admin only).
	if ( is_admin() ) {
		require_once WPRQSFSR_PATH . 'inc/classes/class-wprqsfsr-links.php';
		new Wprqsfsr_Links();

		require_once WPRQSFSR_PATH . 'inc/classes/class-wprqsfsr-admin-page.php';
		new Wprqsfsr_Admin_Page();
	}

} );
