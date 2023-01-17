<?php
/**
 * XO Featured Image Tools plugin for WordPress
 *
 * @package xo-featured-image-tools
 *
 * Plugin Name: XO Featured Image Tools
 * Plugin URI: https://xakuro.com/wordpress/
 * Description: Automatically generates the featured image from the image of the post.
 * Author: Xakuro
 * Author URI: https://xakuro.com/
 * License: GPLv2
 * Requires at least: 4.9
 * Requires PHP: 5.6
 * Version: 1.11.1
 * Text Domain: xo-featured-image-tools
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'XO_FEATURED_IMAGE_TOOLS_VERSION', '1.11.1' );

require_once __DIR__ . '/admin.php';

class XO_Featured_Image_Tools {
	public $admin;

	/**
	 * Construction.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		load_plugin_textdomain( 'xo-featured-image-tools' );

		$admin = new XO_Featured_Image_Tools_Admin( $this );
	}

	/**
	 * Gets the default value of the option.
	 *
	 * @since 0.3.0
	 */
	public static function get_default_options() {
		return array(
			'list_posts'               => array( 'post', 'page' ),
			'auto_save_posts'          => array( 'post', 'page' ),
			'external_image'           => false,
			'exclude_small_image'      => false,
			'exclude_small_image_size' => 48,
			'skip_draft'               => true,
		);
	}

	/**
	 * Plugin activation.
	 *
	 * @since 0.3.0
	 */
	public static function activation() {
		$options = get_option( 'xo_featured_image_tools_options' );
		if ( false === $options ) {
			add_option( 'xo_featured_image_tools_options', XO_Featured_Image_Tools::get_default_options() );
		}
	}

	/**
	 * Plugin deactivation.
	 *
	 * @since 0.3.0
	 */
	public static function uninstall() {
		global $wpdb;

		if ( ! is_multisite() ) {
			delete_option( 'xo_featured_image_tools_options' );
		} else {
			$current_blog_id = get_current_blog_id();
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				delete_option( 'xo_featured_image_tools_options' );
			}
			switch_to_blog( $current_blog_id );
		}
	}
}

global $xo_featured_image_tools;
$xo_featured_image_tools = new XO_Featured_Image_Tools();

register_activation_hook( __FILE__, 'XO_Featured_Image_Tools::activation' );
register_uninstall_hook( __FILE__, 'XO_Featured_Image_Tools::uninstall' );
