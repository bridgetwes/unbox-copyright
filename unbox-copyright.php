<?php
/**
 * Plugin Name:       Unbox Copyright
 * Description:       WordPress Block that sets up a copyright line with auto updating year, site name, and tagline pulled from Settings -> General
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Version:           1.3.21
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
 * Default copyright line. Keep this in sync with DEFAULT_COPYRIGHT in src/edit.js
 * and the input attribute default in src/block.json.
 *
 * @return string
 */
function unbox_copyright_default_text() {
	return __( '©[current year] [site title]. All rights reserved.', 'unbox' );
}

/**
 * Use the default line when the saved block has no text.
 *
 * The editor fallback is not written into post content until the field changes,
 * so an unedited block is stored as an empty paragraph.
 *
 * @param string $content Saved block HTML.
 * @return string
 */
function unbox_copyright_with_default_text( $content ) {
	$plain = str_replace( "\xc2\xa0", '', trim( wp_strip_all_tags( (string) $content ) ) );

	if ( $plain !== '' ) {
		return $content;
	}

	$default = esc_html( unbox_copyright_default_text() );
	$count   = 0;
	$updated = preg_replace_callback(
		'/(<p\b[^>]*>)(.*?)(<\/p>)/is',
		static function ( $matches ) use ( $default ) {
			return $matches[1] . $default . $matches[3];
		},
		(string) $content,
		1,
		$count
	);

	if ( $count && is_string( $updated ) ) {
		return $updated;
	}

	return '<p class="wp-block-unbox-copyright">' . $default . '</p>';
}

/**
 * Renders the `unbox-copyright` on the server.
 *
 * @link   https://developer.wordpress.org/reference/functions/current_datetime/
 * @param  array    $block_attributes Block attributes.
 * @param  string   $content          Block default content.
 * @param  WP_Block $block            Block instance.
 * @return string   Returns the content replacing [current year], [site title], and [tag line] wrapped in a <p> tag.
 */
if ( ! function_exists( 'unbox_copyright_render_block_dynamic_year_block' ) ) {
	function unbox_copyright_render_block_dynamic_year_block( $block_attributes, $content, $block ) {
		// Get the current year.
		$current_date = current_datetime();
		$dynamic_year = $current_date->format( 'Y' );

		// Escape site name and tagline for safe output.
		$sitename = esc_html( get_bloginfo( 'name' ) );
		$tagline  = esc_html( get_bloginfo( 'description' ) );

		// Perform case-insensitive replacements on the content.
		// This allows users to type [current year], [Current Year], [CURRENT YEAR], etc.
		// Using str_ireplace() is safer than regex as it doesn't interpret special characters.
		// Replace [tag line] last so a tagline cannot be altered by the other tokens.
		$output = unbox_copyright_with_default_text( $content );
		$output = str_ireplace( '[current year]', $dynamic_year, $output );
		$output = str_ireplace( '[site title]', $sitename, $output );
		$output = str_ireplace( '[tag line]', $tagline, $output );

		// Sanitize output to allow safe HTML tags while preventing XSS.
		// wp_kses_post() allows the same HTML tags that are allowed in post content.
		return wp_kses_post( $output );
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
