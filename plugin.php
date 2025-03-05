<?php
/**
 * Plugin Name: Publisher Name custom plugin
 * Plugin URI: https://newspack.com
 * Description: One plugin to rule them all.
 * Version: 1.0.0
 * Author: Publisher Name
 * Author URI: Publisher Website
 * Text Domain: publisher-name
 *
 * For more information on WordPress plugin headers, see the following page:
 * https://developer.wordpress.org/plugins/plugin-basics/header-requirements/
 *
 * @package PublisherName
 */

// Ensure that everything is namespaced.
namespace PublisherName;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// This will load composer's autoload.
// Keep in mind that you need to run `composer dump-autoload` after adding new classes.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	// Add admin notice in case the plugin has not been built.
	add_action(
		'admin_notices',
		function() {
			?>
			<div class="notice notice-error">
				<p><?php esc_html_e( 'Publisher Name plugin was not properly built.', 'publisher-name' ); ?></p>
			</div>
			<?php
		}
	);
	return;
}

// Initialize the plugin.

Module_Loader::init();
