<?php
/**
 * Module Loader
 *
 * @package PublisherName
 */

namespace PublisherName;

defined( 'ABSPATH' ) || exit;

/**
 * Module Loader
 */
class Module_Loader {

	const MODULES_OPTION_NAME = __NAMESPACE__ . '-modules';

	/**
	 * Initialize the class
	 *
	 * @return void
	 */
	public static function init() {

		add_action( 'admin_menu', [ __CLASS__, 'add_admin_menu' ] );
		add_filter( 'allowed_options', [ __CLASS__, 'add_allowed_options' ] );
		add_action( 'plugins_loaded', [ __CLASS__, 'load_modules' ] );
	}

	/**
	 * Add the admin menu.
	 *
	 * @return void
	 */
	public static function add_admin_menu() {
		add_options_page(
			'Custom Modules',
			'Custom Modules',
			'manage_options',
			'custom-modules',
			[ __CLASS__, 'render_admin_page' ]
		);
	}

	/**
	 * Add the custom modules to the allowed options.
	 *
	 * @param array $options The allowed options.
	 * @return array
	 */
	public static function add_allowed_options( $options ) {
		$options['custom-modules'] = [ self::MODULES_OPTION_NAME ];
		return $options;
	}

	/**
	 * Render the admin page.
	 *
	 * @return void
	 */
	public static function render_admin_page() {
		$current_active_modules = get_option( self::MODULES_OPTION_NAME );
		if ( ! is_array( $current_active_modules ) ) {
			$current_active_modules = [];
		}
		$available_modules = self::get_available_modules();
		?>
		<div class="wrap">
			<h1>Custom Modules</h1>
			<p>Enable or disable Custom modules</p>
			<form method="post" action="options.php">
				<?php wp_nonce_field( 'custom-modules-options' ); ?>
				<input type="hidden" name="option_page" value="custom-modules">
				<input type="hidden" name="action" value="update">
				<table class="form-table" role="presentation">
					<tbody>
						<?php foreach ( $available_modules as $module ) : ?>
							<?php $checked = in_array( $module['path'], $current_active_modules, true ) ? 'checked' : ''; ?>
							<tr>
								<th scope="row"><?php echo esc_html( $module['name'] ); ?></th>
								<td>
									<fieldset>
										<legend class="screen-reader-text">
											<span><?php echo esc_html( $module['name'] ); ?></span>
										</legend>
										<label for="<?php echo esc_attr( $module['slug'] ); ?>">
											<input name="<?php echo esc_attr( self::MODULES_OPTION_NAME ); ?>[]" type="checkbox" value="<?php echo esc_attr( $module['path'] ); ?>" <?php echo esc_attr( $checked ); ?>>
											Enabled
										</label>
										<p class="description">
											<?php echo esc_html( $module['description'] ); ?>
										</p>
									</fieldset>
								</td>
							</tr>
						<?php endforeach; ?>
					<tbody>

				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Get the available modules in the file system.
	 *
	 * @return array
	 */
	private static function get_available_modules() {
		$modules_dir = __DIR__ . '/Modules';
		$dirs = scandir( $modules_dir );
		$modules = [];
		foreach ( $dirs as $dir ) {
			if ( '.' === $dir || '..' === $dir ) {
				continue;
			}
			$module_file = $modules_dir . '/' . $dir . '/module.php';
			if ( file_exists( $module_file ) ) {
				$modules[ $dir ] = [
					'slug'        => $dir,
					'path'        => $module_file,
					'name'        => $dir,
					'description' => '',
				];
			}

			$info_file = $modules_dir . '/' . $dir . '/info.json';
			if ( file_exists( $info_file ) ) {
				$info = json_decode( file_get_contents( $info_file ), true ); // phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
				if ( ! empty( $info['name'] ) ) {
					$modules[ $dir ]['name'] = $info['name'];
				}
				if ( ! empty( $info['description'] ) ) {
					$modules[ $dir ]['description'] = $info['description'];
				}
			}
		}
		return $modules;
	}

	/**
	 * Load the active modules.
	 *
	 * @return void
	 */
	public static function load_modules() {
		$active_modules = get_option( self::MODULES_OPTION_NAME, [] );
		if ( ! empty( $active_modules ) ) {
			foreach ( $active_modules as $module ) {
				if ( file_exists( $module ) ) {
					require_once $module;
				}
			}
		}
	}
}
