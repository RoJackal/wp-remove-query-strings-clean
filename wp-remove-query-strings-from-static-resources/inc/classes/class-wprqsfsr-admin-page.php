<?php
/**
 * Admin page class.
 *
 * Registers a top-level Dashboard menu page titled "Remove Query Strings" that shows
 * the current plugin status, a Pro feature list, and an Upgrade to Pro CTA.
 * The page (and menu item) is hidden when the Pro plugin is already active.
 *
 * @package WP Remove Query Strings From Static Resources
 */

if ( ! class_exists( 'Wprqsfsr_Admin_Page' ) ) {
	/**
	 * Registers and renders the Remove Query Strings admin page.
	 */
	class Wprqsfsr_Admin_Page {

		/**
		 * Upgrade to Pro URL.
		 *
		 * @var string
		 */
		private $upgrade_url = 'https://lbcache.com';

		/**
		 * Constructor — hooks into admin_menu and admin_enqueue_scripts.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'register_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		}

		/**
		 * Registers the top-level "Remove Query Strings" menu page.
		 * Hidden when the Pro plugin is already active.
		 */
		public function register_menu() {
			if ( defined( 'LBROWSERC_PRO_PATH' ) ) {
				return;
			}

			add_menu_page(
				__( 'Remove Query Strings', 'wprqsfsr' ),
				__( 'Remove Query Strings', 'wprqsfsr' ),
				'manage_options',
				'wprqsfsr',
				array( $this, 'render_page' ),
				'dashicons-performance',
				80
			);
		}

		/**
		 * Enqueues inline styles only on the admin page.
		 *
		 * @param string $hook Current admin page hook suffix.
		 */
		public function enqueue_styles( $hook ) {
			if ( 'toplevel_page_wprqsfsr' !== $hook ) {
				return;
			}

			$css = '
				/* ── Admin Page ───────────────────────────────── */
				#wprqsfsr-wrap {
					max-width: 860px;
					margin: 30px 20px 0;
					font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
				}
				#wprqsfsr-wrap h1.wprqsfsr-title {
					font-size: 26px;
					font-weight: 700;
					color: #1d2327;
					margin-bottom: 6px;
					display: flex;
					align-items: center;
					gap: 10px;
				}
				#wprqsfsr-wrap h1.wprqsfsr-title .wprqsfsr-badge {
					font-size: 11px;
					font-weight: 600;
					background: #e7f5e7;
					color: #00a32a;
					padding: 2px 9px;
					border-radius: 20px;
					letter-spacing: .4px;
				}
				#wprqsfsr-wrap .wprqsfsr-subtitle {
					color: #646970;
					font-size: 14px;
					margin-bottom: 28px;
				}

				/* Cards */
				.wprqsfsr-card {
					background: #fff;
					border: 1px solid #e2e4e7;
					border-radius: 10px;
					padding: 24px 28px;
					margin-bottom: 24px;
					box-shadow: 0 1px 4px rgba(0,0,0,.05);
				}
				.wprqsfsr-card h2 {
					font-size: 15px;
					font-weight: 600;
					color: #1d2327;
					margin: 0 0 18px;
					padding-bottom: 12px;
					border-bottom: 1px solid #f0f0f1;
				}

				/* Status grid */
				.wprqsfsr-status-grid {
					display: grid;
					grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
					gap: 14px;
				}
				.wprqsfsr-status-item {
					display: flex;
					align-items: flex-start;
					gap: 12px;
					background: #f9f9f9;
					border: 1px solid #ebebeb;
					border-radius: 8px;
					padding: 14px 16px;
				}
				.wprqsfsr-status-item .wprqsfsr-icon { font-size: 22px; line-height: 1; flex-shrink: 0; }
				.wprqsfsr-item-label  { font-size: 12px; color: #646970; margin-bottom: 3px; }
				.wprqsfsr-item-value  { font-size: 14px; font-weight: 600; color: #1d2327; }
				.wprqsfsr-ok   { color: #00a32a; }
				.wprqsfsr-warn { color: #d63638; }

				/* Pro features grid */
				.wprqsfsr-features-grid {
					display: grid;
					grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
					gap: 12px;
				}
				.wprqsfsr-feature-item {
					display: flex;
					align-items: center;
					gap: 10px;
					padding: 12px 16px;
					background: #f9f9f9;
					border: 1px solid #ebebeb;
					border-radius: 8px;
					font-size: 14px;
					color: #3c434a;
				}

				/* CTA banner */
				.wprqsfsr-cta {
					background: linear-gradient(135deg, #0e1629 0%, #1a2f5e 100%);
					border-radius: 12px;
					padding: 32px 36px;
					color: #fff;
					display: flex;
					align-items: center;
					justify-content: space-between;
					gap: 24px;
					flex-wrap: wrap;
					margin-bottom: 30px;
				}
				.wprqsfsr-cta h2 { font-size: 20px; font-weight: 700; margin: 0 0 8px; color: #fff; border: none; padding: 0; }
				.wprqsfsr-cta p  { margin: 0; font-size: 14px; color: rgba(255,255,255,.75); max-width: 500px; }
				.wprqsfsr-cta-btn {
					display: inline-block;
					background: #00a32a;
					color: #fff !important;
					font-size: 15px;
					font-weight: 700;
					padding: 13px 28px;
					border-radius: 8px;
					text-decoration: none !important;
					white-space: nowrap;
					flex-shrink: 0;
					transition: background .2s;
				}
				.wprqsfsr-cta-btn:hover { background: #008a22; }
			';

			wp_register_style( 'wprqsfsr-admin', false );
			wp_enqueue_style( 'wprqsfsr-admin' );
			wp_add_inline_style( 'wprqsfsr-admin', $css );
		}

		/**
		 * Renders the admin page.
		 */
		public function render_page() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// ── Status checks ────────────────────────────────────────────
			$removal_active = true; // Always active on the frontend if the plugin is active

			$server_software = isset( $_SERVER['SERVER_SOFTWARE'] )
				? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) )
				: __( 'Unknown', 'wprqsfsr' );
			$is_apache = ( stripos( $server_software, 'apache' ) !== false );

			// ── Pro feature list ─────────────────────────────────────────
			$pro_features = array(
				array( 'icon' => '⚡', 'label' => __( 'GZIP / Brotli Compression', 'wprqsfsr' ) ),
				array( 'icon' => '🎨', 'label' => __( 'CSS Minification', 'wprqsfsr' ) ),
				array( 'icon' => '📜', 'label' => __( 'JavaScript Minification', 'wprqsfsr' ) ),
				array( 'icon' => '🖼️', 'label' => __( 'Image Lazy Loading', 'wprqsfsr' ) ),
				array( 'icon' => '🗜️', 'label' => __( 'HTML Minification', 'wprqsfsr' ) ),
				array( 'icon' => '🔗', 'label' => __( 'DNS Prefetch & Preconnect', 'wprqsfsr' ) ),
				array( 'icon' => '📦', 'label' => __( 'Combine CSS & JS Files', 'wprqsfsr' ) ),
				array( 'icon' => '🚀', 'label' => __( 'Critical CSS Inlining', 'wprqsfsr' ) ),
				array( 'icon' => '🛡️', 'label' => __( 'Security Headers', 'wprqsfsr' ) ),
				array( 'icon' => '📊', 'label' => __( 'Performance Dashboard', 'wprqsfsr' ) ),
				array( 'icon' => '🔄', 'label' => __( 'One-click Cache Purge', 'wprqsfsr' ) ),
				array( 'icon' => '🎯', 'label' => __( 'Priority Support', 'wprqsfsr' ) ),
			);
			?>
			<div id="wprqsfsr-wrap">

				<h1 class="wprqsfsr-title">
					<?php esc_html_e( 'WP Remove Query Strings From Static Resources', 'wprqsfsr' ); ?>
					<span class="wprqsfsr-badge"><?php esc_html_e( 'FREE', 'wprqsfsr' ); ?></span>
				</h1>
				<p class="wprqsfsr-subtitle"><?php esc_html_e( 'Boost your WordPress site speed by removing query strings from static resources.', 'wprqsfsr' ); ?></p>

				<!-- ── Status ─────────────────────────────────────────── -->
				<div class="wprqsfsr-card">
					<h2><?php esc_html_e( '📋 Plugin Status', 'wprqsfsr' ); ?></h2>
					<div class="wprqsfsr-status-grid">

						<div class="wprqsfsr-status-item">
							<div class="wprqsfsr-icon"><?php echo $removal_active ? '✅' : '❌'; ?></div>
							<div>
								<div class="wprqsfsr-item-label"><?php esc_html_e( 'Query Strings Removal', 'wprqsfsr' ); ?></div>
								<div class="wprqsfsr-item-value <?php echo $removal_active ? 'wprqsfsr-ok' : 'wprqsfsr-warn'; ?>">
									<?php echo $removal_active ? esc_html__( 'Active', 'wprqsfsr' ) : esc_html__( 'Inactive', 'wprqsfsr' ); ?>
								</div>
							</div>
						</div>

						<div class="wprqsfsr-status-item">
							<div class="wprqsfsr-icon"><?php echo $is_apache ? '✅' : '⚠️'; ?></div>
							<div>
								<div class="wprqsfsr-item-label"><?php esc_html_e( 'Web Server', 'wprqsfsr' ); ?></div>
								<div class="wprqsfsr-item-value <?php echo $is_apache ? 'wprqsfsr-ok' : 'wprqsfsr-warn'; ?>">
									<?php echo esc_html( $server_software ); ?>
								</div>
							</div>
						</div>

						<div class="wprqsfsr-status-item">
							<div class="wprqsfsr-icon">🔌</div>
							<div>
								<div class="wprqsfsr-item-label"><?php esc_html_e( 'Plugin Version', 'wprqsfsr' ); ?></div>
								<div class="wprqsfsr-item-value">
									<?php
									$plugin_data = get_plugin_data( WPRQSFSR_FILE );
									echo esc_html( isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : '—' );
									?>
								</div>
							</div>
						</div>

						<div class="wprqsfsr-status-item">
							<div class="wprqsfsr-icon">🌐</div>
							<div>
								<div class="wprqsfsr-item-label"><?php esc_html_e( 'PHP Version', 'wprqsfsr' ); ?></div>
								<div class="wprqsfsr-item-value"><?php echo esc_html( PHP_VERSION ); ?></div>
							</div>
						</div>

					</div><!-- .wprqsfsr-status-grid -->
				</div><!-- .wprqsfsr-card -->

				<!-- ── Pro Features ───────────────────────────────────── -->
				<div class="wprqsfsr-card">
					<h2><?php esc_html_e( '🔒 Pro Features — Not Available in Free', 'wprqsfsr' ); ?></h2>
					<div class="wprqsfsr-features-grid">
						<?php foreach ( $pro_features as $feature ) : ?>
							<div class="wprqsfsr-feature-item">
								<span><?php echo esc_html( $feature['icon'] ); ?></span>
								<?php echo esc_html( $feature['label'] ); ?>
							</div>
						<?php endforeach; ?>
					</div>

                    <p style="text-align: center;font-size: 16px;padding-top: 14px;"><?php esc_html_e( 'Browser caching and much more', 'wprqsfsr' ); ?>... ❤️ !</p>

				</div><!-- .wprqsfsr-card -->

				<!-- ── Upgrade CTA ────────────────────────────────────── -->
				<div class="wprqsfsr-cta">
					<div>
						<h2><?php esc_html_e( '⭐ Unlock the Full Power with PRO', 'wprqsfsr' ); ?></h2>
						<p><?php esc_html_e( 'Get Browser caching, GZIP compression, CSS/JS minification, lazy loading, HTML minification, and much more — all in one plugin. Boost your PageSpeed score to 100.', 'wprqsfsr' ); ?></p>
					</div>
					<a href="<?php echo esc_url( $this->upgrade_url ); ?>" target="_blank" rel="noopener noreferrer" class="wprqsfsr-cta-btn">
						<?php esc_html_e( '⭐ Upgrade to Pro', 'wprqsfsr' ); ?>
					</a>
				</div>

			</div><!-- #wprqsfsr-wrap -->
			<?php
		}

	}
}
