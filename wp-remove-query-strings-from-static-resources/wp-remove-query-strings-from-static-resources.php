<?php
/**
 * Plugin Name: WP Remove Query Strings Clean
 * Plugin URI: https://github.com/RoJackal/wp-remove-query-strings-clean
 * Description: Removes query strings from local CSS and JavaScript resources while leaving external and non-static resources unchanged.
 * Version: 2.5.0
 * Author: Rinku Yadav; maintained by RoJackal
 * Update URI: https://github.com/RoJackal/wp-remove-query-strings-clean
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Requires PHP: 8.5
 * Text Domain: wp-remove-query-strings-from-static-resources
 * @package WP_Remove_Query_Strings_Clean
 */
if (!defined('ABSPATH')) {
    exit;
}
require_once __DIR__ . '/inc/classes/class-wprqsfsr-core.php';
add_action('plugins_loaded', static function (): void {
    new Wprqsfsr_Core();
});
