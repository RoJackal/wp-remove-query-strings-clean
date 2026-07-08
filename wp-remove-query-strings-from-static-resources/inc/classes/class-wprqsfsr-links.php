<?php

// Exit if directly accessed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Plugin action links class.
 *
 * @package WP Remove Query Strings From Static Resources
 */

if ( ! class_exists( 'Wprqsfsr_Links' ) ) {
	/**
	 * Adds custom links to the plugin's row on the Plugins list table.
	 */
	class Wprqsfsr_Links {

		/**
		 * Upgrade to Pro URL.
		 *
		 * @var string
		 */
		private $upgrade_url = 'https://lbcache.com';

		/**
		 * Constructor — hooks into the plugin action links filter.
		 */
		public function __construct() {
			add_filter(
				'plugin_action_links_' . WPRQSFSR_BASE_FILE,
				array( $this, 'add_action_links' )
			);
		}

		/**
		 * Appends an Upgrade to Pro link to the plugin's action links.
		 *
		 * @param array $links Existing action links.
		 * @return array Modified action links.
		 */
		public function add_action_links( $links ) {
			// Hide all custom links if the Pro plugin is already active.
			if ( defined( 'LBROWSERC_PRO_PATH' ) ) {
				return $links;
			}

			$settings_link = sprintf(
				'<a href="%s">%s</a>',
				esc_url( admin_url( 'admin.php?page=wprqsfsr' ) ),
				esc_html__( 'Settings', 'wp-remove-query-strings-from-static-resources' )
			);

			$upgrade_link = sprintf(
				'<a href="%s" target="_blank" rel="noopener noreferrer" style="color:#00a32a;font-weight:600;">&#11088; %s</a>',
				esc_url( $this->upgrade_url ),
				esc_html__( 'Upgrade to Pro', 'wp-remove-query-strings-from-static-resources' )
			);

			array_unshift( $links, $settings_link );
			$links[] = $upgrade_link;

			return $links;
		}

	}
}
