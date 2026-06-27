<?php
/**
 * Welcome Notice class.
 */
class ST_Logistics_Welcome_Notice {

	/**
	** Constructor.
	*/
	public function __construct() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Render Notice
		add_action( 'admin_notices', [$this, 'st_logistics_render_notice'] );

		// Enque AJAX Script
		add_action( 'admin_enqueue_scripts', [$this, 'st_logistics_admin_enqueue_scripts'], 5 );

		// Dismiss
		add_action( 'admin_enqueue_scripts', [$this, 'st_logistics_notice_enqueue_scripts'], 5 );
		add_action( 'wp_ajax_sb_st_logistics_dismissed_handler', [$this, 'st_logistics_dismissed_handler'] );

		// Reset
		add_action( 'switch_theme', [$this, 'st_logistics_reset_notices'] );
		add_action( 'after_switch_theme', [$this, 'st_logistics_reset_notices'] );

		// Install Plugins
		add_action( 'wp_ajax_stlogistics_install_activate_st_demo_importer', [$this, 'st_logistics_install_activate_st_demo_importer'] );
		add_action( 'wp_ajax_nopriv_stlogistics_install_activate_st_demo_importer', [$this, 'st_logistics_install_activate_st_demo_importer'] );

		add_action( 'wp_ajax_st_logistics_cancel_elementor_redirect', [$this, 'st_logistics_cancel_elementor_redirect'] );
	}

	public function st_logistics_cancel_elementor_redirect() {
		exit;
	}

	/**
	** Get plugin status.
	*/
	public function st_logistics_get_plugin_status( $plugin_path ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
	
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
			return 'not_installed';
		} else {
			$plugin_updates = get_site_transient( 'update_plugins' );
			$plugin_needs_update = is_object($plugin_updates) && isset($plugin_updates->response) && is_array($plugin_updates->response) 
				? array_key_exists($plugin_path, $plugin_updates->response) 
				: false;
	
			if ( in_array( $plugin_path, (array) get_option( 'active_plugins', array() ), true ) || is_plugin_active_for_network( $plugin_path ) ) {
				return $plugin_needs_update ? 'active_update' : 'active';
			} else {
				return $plugin_needs_update ? 'inactive_update' : 'inactive';
			}    
		}
	}
	

	/**
	** Install a plugin.
	*/
	public function st_logistics_install_plugin( $plugin_slug ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		if ( false === filter_var( $plugin_slug, FILTER_VALIDATE_URL ) ) {
			$api = plugins_api(
				'plugin_information',
				[
					'slug'   => $plugin_slug,
					'fields' => [
						'short_description' => false,
						'sections'          => false,
						'requires'          => false,
						'rating'            => false,
						'ratings'           => false,
						'downloaded'        => false,
						'last_updated'      => false,
						'added'             => false,
						'tags'              => false,
						'compatibility'     => false,
						'homepage'          => false,
						'donate_link'       => false,
					],
				]
			);

			$download_link = $api->download_link;
		} else {
			$download_link = $plugin_slug;
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$install = $upgrader->install( $download_link );

		if ( false === $install ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Update a plugin.
	*/
	public function st_logistics_update_plugin( $plugin_path ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$upgrade = $upgrader->upgrade( $plugin_path );

		if ( false === $upgrade ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Update all plugins.
	*/
	public function st_logistics_update_all_plugins() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$upgrade = $upgrader->bulk_upgrade([
			'elementor/elementor.php',
			'st-demo-importer/st-demo-importer.php'
		]);

		if ( false === $upgrade ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Activate a plugin.
	*/
	public function st_logistics_activate_plugin( $plugin_path ) {

		if ( ! current_user_can( 'install_plugins' ) ) {
			return false;
		}

		$activate = activate_plugin( $plugin_path, '', false, false ); // TODO: last argument changed to false instead of true

		if ( is_wp_error( $activate ) ) {
			return false;
		} else {
			return true;
		}
	}


	/**
	** Install ST Demo Impoter.
	*/
	public function st_logistics_install_activate_st_demo_importer() {
		check_ajax_referer( 'nonce', 'nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions to install the plugin.', 'st-logistics' ) );
			wp_die();
		}

		$plugin_status = $this->st_logistics_get_plugin_status( 'st-demo-importer/st-demo-importer.php' );

		if ( 'not_installed' === $plugin_status ) {
			$this->st_logistics_install_plugin( 'st-demo-importer' );
			$this->st_logistics_activate_plugin( 'st-demo-importer/st-demo-importer.php' );

		} else {
			if ( 'inactive' === $plugin_status ) {
				$this->st_logistics_activate_plugin( 'st-demo-importer/st-demo-importer.php' );
			} elseif ( 'inactive_update' === $plugin_status || 'active_update' === $plugin_status ) {
				$this->st_logistics_update_plugin( 'st-demo-importer/st-demo-importer.php' );
				$this->st_logistics_activate_plugin( 'st-demo-importer/st-demo-importer.php' );
			}
		}

		if ( 'active' === $this->st_logistics_get_plugin_status( 'st-demo-importer/st-demo-importer.php' ) ) {
			wp_send_json_success();
		}

		wp_send_json_error( esc_html__( 'Failed to initialize or activate importer plugin.', 'st-logistics' ) );

		wp_die();
	}

	/**
	** Render Notice
	*/
	public function st_logistics_render_notice() {

	$screen = get_current_screen();

	if ( $screen && 'stdemoimporter-wizard' !== $screen->parent_base ) {
		$transient_name = sprintf( '%s_activation_notice', get_template() );

		if ( ! get_transient( $transient_name ) ) {
			?>
			<div class="notice notice-success is-dismissible st-logistics-notice" data-notice="<?php echo esc_attr( $transient_name ); ?>">
				<button type="button" class="notice-dismiss"></button>

				<?php $this->st_logistics_render_notice_content(); ?>
			</div>
			<?php
		}
	}
}

	/**
	** Render Notice Content
	*/
	public function st_logistics_render_notice_content() {
		$action = 'install-activate';
		$freemius_passed = 'false';
		$redirect_url = 'admin.php?page=stdemoimporter-wizard';
		$st_demo_importer_status = $this->st_logistics_get_plugin_status('st-demo-importer/st-demo-importer.php');
	
		if ('active' === $st_demo_importer_status) {
			$action = 'default';
		}
	
		$screen = get_current_screen();
		$flex_attr = '';
		$display_attr = 'display: inline-block !important';
	
		if ('toplevel_page_stdemoimporter-wizard' === $screen->id) {
			$flex_attr = 'display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center';
			$display_attr = 'display: none !important';
		} ?>
	
		<div class="st-logistics-welcome-message" style="<?php echo esc_attr($flex_attr); ?>">
			<h1 style="<?php echo esc_attr($display_attr); ?>">
				<?php esc_html_e('Welcome to ST Logistics', 'st-logistics'); ?>
			</h1>
			<p>
				<?php esc_html_e('STLogistics is a clean, modern, and fully responsive WordPress theme designed for Logistics clinics, wellness centers, yoga studios, and holistic healing businesses. It features customizable homepage sections, mobile-friendly layouts, SEO optimization, and compatibility with WooCommerce, Elementor, and MetForm. Perfect for creating a professional and calming online presence for wellness brands, doctors, spas, and organic lifestyle businesses.', 'st-logistics'); ?>
			</p>
			<div class="st-logistics-action-buttons">
				<a href="<?php echo esc_url(admin_url($redirect_url)); ?>" class="button button-primary" data-action="<?php echo esc_attr($action); ?>" data-freemius="<?php echo esc_attr($freemius_passed); ?>">
					<?php esc_html_e('Get Started with St Demo Importer', 'st-logistics'); ?>
					<span class="dashicons dashicons-arrow-right-alt"></span>
				</a>
				<a href="<?php echo esc_url('https://striviothemes.com/product/logistics-wordpress-theme/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_admin_banner'); ?>" class="button button-primary st-logistics-buy-now" target="_blank">
					<?php esc_html_e('Buy Now', 'st-logistics'); ?>
				</a>
				<a href="<?php echo esc_url('https://striviothemes.com/preview/st-logistic-pro/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_admin_banner'); ?>" class="button button-primary st-logistics-view-demo" target="_blank">
					<?php esc_html_e('Demo', 'st-logistics'); ?>
				</a>
			</div>
		</div>
		<?php
	}
	

	/**
	** Reset Notice.
	*/
	public function st_logistics_reset_notices() {
		delete_transient( sprintf( '%s_activation_notice', get_template() ) );
	}

	/**
	** Dismissed handler
	*/
	public function st_logistics_dismissed_handler() {
        check_ajax_referer('sb_dismiss_notice_nonce', 'nonce');

        if ( ! current_user_can('administrator') ) {
            return;
        }

		if ( isset( $_POST['notice'] ) ) {
			set_transient( sanitize_text_field( wp_unslash( $_POST['notice'] ) ), true, 0 );
		}
	}

	/**
	** Notice Enqunue Scripts
	*/
	public function st_logistics_notice_enqueue_scripts( $page ) {
		wp_enqueue_script( 'jquery' );

        // Generate a nonce
        $nonce = wp_create_nonce('sb_dismiss_notice_nonce');

		ob_start();
		?>
		<script>
			jQuery(function($) {
				$( document ).on( 'click', '.st-logistics-notice .notice-dismiss', function () {
					jQuery.post( 'ajax_url', {
						action: 'sb_st_logistics_dismissed_handler',
						notice: $( this ).closest( '.st-logistics-notice' ).data( 'notice' ),
                        nonce: '<?php echo $nonce; ?>', // Pass the nonce here
					});
					$( '.st-logistics-notice' ).hide();
				} );
			});
		</script>
		<?php
		$script = str_replace( 'ajax_url', admin_url( 'admin-ajax.php' ), ob_get_clean() );

		wp_add_inline_script( 'jquery', str_replace( ['<script>', '</script>'], '', $script ) );
	}

	/**
	** Register scripts and styles for welcome notice.
	*/
	public function st_logistics_admin_enqueue_scripts( $page ) {
		global $pagenow;

		$screen = get_current_screen();
		$screen_id = ( $screen && isset( $screen->id ) ) ? $screen->id : '';
		$screen_base = ( $screen && isset( $screen->base ) ) ? $screen->base : '';

		// Enqueue Scripts on all admin pages
		wp_enqueue_script( 'st-logistics-welcome-notic-js', get_template_directory_uri() . '/inc/activation/js/welcome-notice.js', ['jquery'], false, true );

		wp_localize_script( 'st-logistics-welcome-notic-js', 'st_logistics_localize', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'elementor_nonce' => wp_create_nonce( 'nonce' ),
			'st_demo_importer_nonce' => wp_create_nonce( 'nonce' ),
			'failed_message' => esc_html__( 'Something went wrong, contact support.', 'st-logistics' ),
		] );

		// Enqueue Styles on all admin pages
		$style_file = get_template_directory() . '/inc/activation/css/welcome-notice.css';
		$style_ver  = file_exists( $style_file ) ? filemtime( $style_file ) : false;
		wp_enqueue_style( 'st-logistics-welcome-notic-css', get_template_directory_uri() . '/inc/activation/css/welcome-notice.css', array(), $style_ver );
	}

}

new ST_Logistics_Welcome_Notice();
