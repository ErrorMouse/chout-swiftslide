<?php
/**
 * Plugin Name:       Chout - SwiftSlide
 * Description:       Elementor widgets: Five Elastic Columns & Three Columns Slide Out. Select images, set width, height and transition duration.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Chout
 * Requires Plugins:  elementor
 * Author URI:        https://profiles.wordpress.org/nmtnguyen56/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       chout-swiftslide
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// --- Dynamic Update Checker Mode ---
$chout_sslide_update_mode = get_option( 'chout-sslide_update_mode', 'github' );

// Handle toggle
add_action( 'admin_init', function() use ( $chout_sslide_update_mode ) {
	if ( isset( $_GET['chout-sslide_toggle_update'] ) && current_user_can( 'manage_options' ) ) {
		check_admin_referer( 'chout-sslide_toggle_update' );
		$new_mode = ( $chout_sslide_update_mode === 'github' ) ? 'json' : 'github';
		update_option( 'chout-sslide_update_mode', $new_mode, false );
		wp_safe_redirect( admin_url( 'plugins.php' ) );
		exit;
	}
});

require __DIR__ . '/vendor/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

if ( $chout_sslide_update_mode === 'github' ) {
	$myUpdateChecker = PucFactory::buildUpdateChecker(
		'https://github.com/ErrorMouse/chout-swiftslide/',
		__FILE__,
		'chout-swiftslide'
	);
	$myUpdateChecker->setBranch('main');
} else {
	$myUpdateChecker = PucFactory::buildUpdateChecker(
		'https://raw.githubusercontent.com/ErrorMouse/chout-swiftslide/refs/heads/main/chout-swiftslide.json',
		__FILE__,
		'chout-swiftslide'
	);
}

// Add toggle link to plugin row meta
add_filter( 'plugin_row_meta', function( $links, $file ) use ( $chout_sslide_update_mode ) {
	if ( plugin_basename( __FILE__ ) === $file ) {
		$toggle_url = wp_nonce_url( admin_url( 'plugins.php?chout-sslide_toggle_update=1' ), 'chout-sslide_toggle_update' );
		$checked    = ( $chout_sslide_update_mode === 'json' ) ? 'checked' : '';
		
		$toggle_html = '<style>
		.cssl-switch{position:relative;display:inline-block;width:32px;height:18px;vertical-align:middle;margin:0 5px 0 0;}
		.cssl-switch input{opacity:0;width:0;height:0;}
		.cssl-slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background-color:#ccc;transition:.3s;border-radius:18px;}
		.cssl-slider:before{position:absolute;content:"";height:14px;width:14px;left:2px;bottom:2px;background-color:white;transition:.3s;border-radius:50%;box-shadow:0 1px 2px rgba(0,0,0,0.2);}
		.cssl-switch input:checked+.cssl-slider{background-color:#22c55e;}
		.cssl-switch input:checked+.cssl-slider:before{transform:translateX(14px);}
		</style>
		<label class="cssl-switch" title="' . esc_attr__( 'Enable to update via static JSON (prevents API 403 errors). Disable to update via GitHub API.', 'chout-swiftslide' ) . '">
			<input type="checkbox" onchange="window.location.href=\'' . esc_js( $toggle_url ) . '\'" ' . $checked . '>
			<span class="cssl-slider"></span>
		</label>
		<span style="vertical-align:middle;color:#0073aa;font-weight:500;">' . esc_html__( 'Update via JSON', 'chout-swiftslide' ) . '</span>';
		
		$links[] = $toggle_html;
	}
	return $links;
}, 10, 2 );
// --- End Update Checker ---

define( 'CHOUT_SWIFTSLIDE_VERSION', '1.0.1' );
define( 'CHOUT_SWIFTSLIDE_PATH',    plugin_dir_path( __FILE__ ) );
define( 'CHOUT_SWIFTSLIDE_URL',     plugin_dir_url( __FILE__ ) );

function chout_swiftslide_init() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'chout_swiftslide_missing_elementor_notice' );
        return;
    }

    require_once CHOUT_SWIFTSLIDE_PATH . 'includes/plugin.php';
}
add_action( 'plugins_loaded', 'chout_swiftslide_init' );

function chout_swiftslide_missing_elementor_notice() {
    $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'chout-swiftslide' ),
        '<strong>Chout - SwiftSlide</strong>',
        '<strong>Elementor</strong>'
    );
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
}
