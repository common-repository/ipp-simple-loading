<?php
/**
 * Plugin Name:       Ipp Simple Loading
 * Description:       A Simple Loading component by Incrementtum.
 * Requires at least: 6.1.1
 * Requires PHP:      7.4.33
 * Version:           2.2.1
 * Author:            johnguaz
 * Author URI:        https://incrementtum.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ipp_simple_loading
 *
 * @package incrementtum
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}




add_action( 'admin_menu', 'ipp_simple_loading_init_menu' );

/**
 * Init Admin Menu.
 *
 * @return void
 */
function ipp_simple_loading_init_menu() {
	add_menu_page( __( 'Ipp Simple Loading', 'ipp_simple_loading' ), __( 'Ipp Simple Loading', 'ipp_simple_loading' ), 'manage_options', 'ipp_simple_loading', 'ipp_simple_loading_admin_page', 'dashicons-image-rotate' );
}

/**
 * Init Admin Page.
 *
 * @return void
 */
function ipp_simple_loading_admin_page() {
	require_once plugin_dir_path( __FILE__ ) . 'templates/app.php';
}

require_once plugin_dir_path( __FILE__ ) . 'inc/ipp-simple-loading-scripts.php';
