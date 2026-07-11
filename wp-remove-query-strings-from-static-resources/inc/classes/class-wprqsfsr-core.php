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
		 * Remove all query string parameters from local CSS and JS resource URLs.
		 *
		 * Uses explode() to strip everything from the first '?' onward,
		 * handling ?ver=, ?timestamp=, ?v=, &ver= and any other params.
		 * Strictly targets files with .css or .js extensions to protect dynamic scripts.
		 * Ignores external resources to prevent breaking third-party APIs.
		 *
		 * @param string $src Full URL of the resource file.
		 * @return string Clean URL without any query string parameters, or original URL for external/non-static resources.
		 */
		public function remove_query_string( $src ) {
			if ( strpos( $src, '?' ) !== false ) {
				$path = (string) wp_parse_url( $src, PHP_URL_PATH );
				$ext  = pathinfo( $path, PATHINFO_EXTENSION );

				// Only process files that end in .css or .js
				if ( in_array( strtolower( $ext ), array( 'css', 'js' ), true ) ) {
					$src_host  = wp_parse_url( $src, PHP_URL_HOST );
					$site_host = wp_parse_url( home_url(), PHP_URL_HOST );

					if ( empty( $src_host ) || $src_host === $site_host ) {
						$src = explode( '?', $src )[0];
					}
				}
			}
			return $src;
		}

	}
}
