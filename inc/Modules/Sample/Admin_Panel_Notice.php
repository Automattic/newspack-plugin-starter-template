<?php
/**
 * Admin Panel Notice.
 *
 * @package PublisherName
 */

namespace PublisherName\Modules\Sample;

defined( 'ABSPATH' ) || exit;

/**
 * Class to add a notice to the admin panel
 */
class Admin_Panel_Notice {

	/**
	 * Initialize the class
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_bar_menu', [ __CLASS__, 'add_notice' ], 999 );
	}

	/**
	 * Adds a notice to the admin bar
	 *
	 * @param object $wp_admin_bar The Admin bar object.
	 * @return void
	 */
	public static function add_notice( $wp_admin_bar ) {
		$args = array(
			'id'    => 'sample_info',
			'title' => 'Custom Module is enabled',
		);
		$wp_admin_bar->add_node( $args );
	}
}
