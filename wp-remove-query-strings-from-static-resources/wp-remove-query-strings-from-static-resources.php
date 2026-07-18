<?php
/**
 * Plugin Name: WP Remove Query Strings Clean
 * Plugin URI: https://github.com/RoJackal/wp-remove-query-strings-clean
 * Description: Removes query strings from local CSS and JavaScript resources while leaving external and non-static resources unchanged.
 * Version: 2.4.1
 * Author: Rinku Yadav; maintained by RoJackal
 * Update URI: https://github.com/RoJackal/wp-remove-query-strings-clean
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Text Domain: wp-remove-query-strings-from-static-resources
 * @package WP_Remove_Query_Strings_Clean
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!defined('WPRQSFSR_PATH')) {
    define('WPRQSFSR_PATH', wp_normalize_path(plugin_dir_path(__FILE__)));
}
add_action('plugins_loaded', static function (): void {
    require_once WPRQSFSR_PATH . 'inc/classes/class-wprqsfsr-core.php';
    new Wprqsfsr_Core();
});