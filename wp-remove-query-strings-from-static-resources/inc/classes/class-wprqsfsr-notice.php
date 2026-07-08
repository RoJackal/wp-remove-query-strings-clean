<?php

// Exit if directly accessed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Donate admin notice class.
 *
 * Displays a dismissible admin notice encouraging users to donate.
 * The dismissed state is stored in the database and cleared on plugin
 * deactivation so the notice re-appears after the next activation.
 *
 * @package WP Remove Query Strings From Static Resources
 */

if ( ! class_exists( 'Wprqsfsr_Notice' ) ) {
	/**
	 * Handles the dismissible donate admin notice.
	 */
	class Wprqsfsr_Notice {

		/**
		 * Database option key used to track whether the notice was dismissed.
		 *
		 * @var string
		 */
		private $option_key = 'wprqsfsr_notice_dismissed';

		/**
		 * AJAX action name for dismissing the notice.
		 *
		 * @var string
		 */
		private $ajax_action = 'wprqsfsr_dismiss_notice';

		/**
		 * Nonce action name.
		 *
		 * @var string
		 */
		private $nonce_action = 'wprqsfsr_dismiss_nonce';

		/**
		 * Upgrade to Pro URL.
		 *
		 * @var string
		 */
		private $upgrade_url = 'https://lbcache.com';

		/**
		 * Constructor — registers admin notice and AJAX dismiss handler.
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'show_notice' ) );
			add_action( 'wp_ajax_' . $this->ajax_action, array( $this, 'handle_dismiss' ) );
			add_action( 'upgrader_process_complete', array( $this, 'reset_on_update' ), 10, 2 );
		}

		/**
		 * Renders the dismissible Upgrade to Pro notice.
		 * Only shown to users who can manage options, have not dismissed it yet,
		 * and do not already have the Pro plugin active.
		 */
		public function show_notice() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Hide the notice if the Pro plugin is already active.
			if ( defined( 'LBROWSERC_PRO_PATH' ) ) {
				return;
			}

			if ( get_option( $this->option_key ) ) {
				return;
			}

			$nonce = wp_create_nonce( $this->nonce_action );
			?>
			<div class="notice notice-info is-dismissible" id="wprqsfsr-upgrade-notice">
				<p>
					<strong><?php esc_html_e( '⭐ Unlock the full power of WP Remove Query Strings From Static Resources!', 'wp-remove-query-strings-from-static-resources' ); ?></strong>
					<br>
					<?php
					printf(
						wp_kses(
							/* translators: %s: upgrade link HTML */
							__( 'You are using the free version. Upgrade to <strong>Pro</strong> to unlock Browser caching, GZIP compression, CSS/JS minification, lazy loading, HTML minification, and much more. %s', 'wp-remove-query-strings-from-static-resources' ),
							array(
								'strong' => array(),
								'a'      => array(
									'href'   => array(),
									'target' => array(),
									'rel'    => array(),
									'style'  => array(),
								),
							)
						),
						'<a href="' . esc_url( $this->upgrade_url ) . '" target="_blank" rel="noopener noreferrer" style="color:#00a32a;font-weight:600;text-decoration:none;">&#11088; ' . esc_html__( 'Upgrade to Pro', 'wp-remove-query-strings-from-static-resources' ) . '</a>'
					);
					?>
				</p>
			</div>
			<script>
			(function() {
				var notice = document.getElementById( 'wprqsfsr-upgrade-notice' );
				if ( ! notice ) { return; }
				notice.addEventListener( 'click', function( e ) {
					if ( e.target.classList.contains( 'notice-dismiss' ) ) {
						var xhr = new XMLHttpRequest();
						xhr.open( 'POST', ajaxurl, true );
						xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
						xhr.send( 'action=<?php echo esc_js( $this->ajax_action ); ?>&nonce=<?php echo esc_js( $nonce ); ?>' );
					}
				} );
			}());
			</script>
			<?php
		}

		/**
		 * AJAX handler — saves the dismissed state to the database.
		 */
		public function handle_dismiss() {
			check_ajax_referer( $this->nonce_action, 'nonce' );

			if ( current_user_can( 'manage_options' ) ) {
				// Store with autoload disabled — only needed when admin pages load.
				update_option( $this->option_key, '1', false );
			}

			wp_die();
		}

		/**
		 * Clears the dismissed state so the notice re-appears after the next activation.
		 * Called via register_deactivation_hook().
		 */
		public function reset_notice() {
			delete_option( $this->option_key );
		}

		/**
		 * Resets the notice when the plugin is updated.
		 *
		 * @param WP_Upgrader $upgrader_object WP_Upgrader instance.
		 * @param array       $options         Array of bulk item update data.
		 */
		public function reset_on_update( $upgrader_object, $options ) {
			if ( 'update' === $options['action'] && 'plugin' === $options['type'] && isset( $options['plugins'] ) ) {
				if ( in_array( WPRQSFSR_BASE_FILE, $options['plugins'], true ) ) {
					$this->reset_notice();
				}
			}
		}

	}
}
