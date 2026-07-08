<?php

// Exit if directly accessed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Main class of plugin.
 *
 * @package 	WP Remove Query Strings From Static Resources
 */

if ( ! class_exists( 'Wprqsfsr_Core' ) ) {
	/**
	 * Core class of plugin.
	 */
	class Wprqsfsr_Core {

		/**
		 * Construct method of class.
		 */
		public function __construct() {
			// Do not apply in Dashboard.
			if ( ! is_admin() ) {
				add_filter( 'script_loader_src', array( $this, 'remove_query_string' ), 15, 1 );
				add_filter( 'style_loader_src', array( $this, 'remove_query_string' ), 15, 1 );
			}
		}

		/**
		 * Remove all query string parameters from a resource URL.
		 *
		 * Uses explode() to strip everything from the first '?' onward,
		 * handling ?ver=, ?timestamp=, ?v=, &ver= and any other params.
		 *
		 * @param string $src Full URL of the resource file.
		 * @return string Clean URL without any query string parameters.
		 */
		public function remove_query_string( $src ) {
			if ( strpos( $src, '?' ) !== false ) {
				$src = explode( '?', $src )[0];
			}
			return $src;
		}

	}
}
