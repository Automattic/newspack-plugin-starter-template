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

require_once 'vendor/autoload.php';

Module_Loader::init();
