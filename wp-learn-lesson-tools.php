<?php
/**
 * Plugin Name: WP Learn Lesson Tools
 * Description: A plugin to manage lesson MCP tools for a WordPress site
 * Version: 0.0.1
 * Requires Plugins: wp-feature-api, sensei-lms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Check if the Sensei plugin is installed and active
 */
if ( ! is_plugin_active( 'sensei-lms/sensei-lms.php' ) ) {
	return;
}

/**
 * Check if the WordPress Feature API plugin is installed and active
 */
if ( ! is_plugin_active( 'wp-feature-api/wp-feature-api.php' ) ) {
	return;
}

/**
 * Action hooks to register the lesson features and tools
 */
add_action( 'init', 'wp_learn_register_lesson_features' );

/**
 * Register the lesson features.
 * Uses the WP Feature API to register a new feature for the lessons.
 */
function wp_learn_register_lesson_features() {
	// Register the wp-learn/get-lessons feature
	wp_register_feature( array(
		'id'          => 'wp-learn/get-lessons', // Base ID without type prefix
		'name'        => __( 'Get lessons', 'wp-learn' ),
		'description' => __( 'Get Sensei lessons.', 'wp-learn' ),
		'rest_alias'  => '/wp/v2/lessons', // The Sensei lessons REST route to alias
		'categories'  => array( 'core', 'rest' ),
		'type'        => WP_Feature::TYPE_RESOURCE, // This is a GET request
	) );
}