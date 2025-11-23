<?php
/**
 * Plugin Name:       Unbox Copyright
 * Description:       WordPress Block that sets up a copyright line with auto updating year and site name pulled from Settings -> General
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Version:           1.3.17
 * Author:            Bridget Wessel
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       unbox
 * GitHub Plugin URI: bridgetwes/unbox-copyright
 * GitHub Branch:     main
 *
 * @package           create-block
 */

  // Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if unbox-github-updater plugin is active and show warning
 */
function unbox_copyright_check_dependencies() {
    // Check if unbox-github-updater plugin is active
    if (!is_plugin_active('unbox-github-updater/unbox-github-updater.php')) {
        // Add warning to plugin row meta
        add_filter('plugin_row_meta', 'unbox_copyright_add_dependency_warning', 10, 2);
    }
}
add_action('admin_init', 'unbox_copyright_check_dependencies');

/**
 * Add warning about missing unbox-github-updater plugin
 */
function unbox_copyright_add_dependency_warning($links, $file) {
    if ($file === plugin_basename(__FILE__)) {
        $warning = '<div style="margin-top: 8px; padding: 8px; background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px; color: #856404;"><strong>⚠️ Warning:</strong> The Unbox GitHub Updater plugin is not installed or active. This plugin is required for automatic updates. You can download the latest release of the Unbox GitHub Updater <a href="https://github.com/bridgetwes/unbox-github-updater">here</a>.</div>';
        $links[] = $warning;
    }
    return $links;
}

 /**
 * Renders the `unbox-copyright` on the server.
 *
 * @link   https://developer.wordpress.org/reference/functions/current_datetime/
 * @param  array    $attributes Block attributes.
 * @param  string   $content    Block default content.
 * @param  WP_Block $block      Block instance.
 * @return string   Returns the content replacing [current year] and [site title] wrapped in a <p> tag.
 */
if ( ! function_exists( 'unbox_copyright_render_block_dynamic_year_block' ) ) {
	function unbox_copyright_render_block_dynamic_year_block( $block_attributes, $content, $block ) {
		//Replace what is saved in the page with the current year.
		// Get the current year.
		$current_date = current_datetime();
		$dynamic_year = $current_date->format('Y');

		$sitename = get_bloginfo('name');

		$output = str_replace("[current year]", $dynamic_year, $content);
		$output = str_replace("[site title]", $sitename, $output);

		return $output;
	}
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_unbox_copyright_block_init() {
	register_block_type(
		__DIR__ . '/build',
		array(
			'render_callback' => 'unbox_copyright_render_block_dynamic_year_block',
		)
	);
}
add_action( 'init', 'create_block_unbox_copyright_block_init' );
