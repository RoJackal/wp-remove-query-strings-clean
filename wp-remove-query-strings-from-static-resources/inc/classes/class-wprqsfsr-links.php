<?php
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
		 * Donate URL.
		 *
		 * @var string
		 */
		private $donate_url = 'https://paypal.me/RinkuYadav';

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
		 * Appends a Donate link to the plugin's action links.
		 *
		 * @param array $links Existing action links.
		 * @return array Modified action links.
		 */
		public function add_action_links( $links ) {
			$donate_link = sprintf(
				'<a href="%s" target="_blank" rel="noopener noreferrer" style="color:#e76500;">&#9829; %s</a>',
				esc_url( $this->donate_url ),
				esc_html__( 'Donate', 'wprqsfsr' )
			);

			$links[] = $donate_link;

			return $links;
		}

	}
}
