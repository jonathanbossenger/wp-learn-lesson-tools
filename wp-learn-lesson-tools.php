<?php
/**
 * Plugin Name: WP Learn Lesson Tools
 * Description: A plugin to manage lesson MCP tools for a WordPress site
 * Version: 0.0.1
 * Requires Plugins: wordpress-mcp, wp-feature-api, sensei-lms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Check if the Sensei plugin is installed and active
 */
if ( ! is_plugin_active( 'sensei/sensei.php' ) ) {
	return;
}

/**
 * Check if the WordPress MCP plugin is installed and active
 */
if ( ! is_plugin_active( 'wordpress-mcp/wordpress-mcp.php' ) ) {
	return;
}

/**
 * Check if the WordPress Feature API plugin is installed and active
 */
if ( ! is_plugin_active( 'wordpress-feature-api/wordpress-feature-api.php' ) ) {
	return;
}


add_action( 'init', 'wp_learn_register_lesson_features' );
add_action( 'init', 'wp_learn_register_lesson_tools' );
/**
 * Register the lesson features.
 * Uses the WP Feature API to register a new feature for the lessons.
 */
function wp_learn_register_lesson_features() {
	wp_register_feature( array(
		'id'          => 'wp-learn/lessons', // Base ID without type prefix
		'name'        => __( 'Get lessons', 'wp-learn' ),
		'description' => __( 'Get Sensei lessons.', 'wp-learn' ),
		'rest_alias'  => '/wp/v2/lessons', // The REST route to alias
		'categories'  => array( 'core', 'rest' ),
		'type'        => WP_Feature::TYPE_RESOURCE, // This is a GET request
	) );
}

/*
 * Register the MCP tool
 * This tool will be used to get lessons from the lessons feature.
 */
function wp_learn_register_lesson_tools() {
	// Register the GET lessons tool
	new Automattic\WordpressMcp\Core\RegisterMcpTool([
		'name'        => 'get_lessons',
		'description' => 'Get Sensei lessons from the lessons feature',
		'type'        => 'read',
		'inputSchema'          => array(
			'type'       => 'object',
			'properties' => new stdClass(),
			'required'   => new stdClass(),
		),
		'callback'    => function() {
			$feature = wp_find_feature( 'wp-learn/lessons' );
			return $feature->call();
		},
		'permissions_callback' => '__return_true',
	]);
}