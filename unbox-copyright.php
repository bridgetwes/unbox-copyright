<?php
/**
 * Plugin Name:       Unbox Copyright
 * Description:       WordPress Block that sets up a copyright line with auto updating year and site name pulled from Settings -> General
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Version:           1.3.8
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


require_once plugin_dir_path( __FILE__ ) . 'plugin-update-checker.php';

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
