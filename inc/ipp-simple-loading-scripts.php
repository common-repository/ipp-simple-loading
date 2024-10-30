<?php
/**
 * Init the settings.
 *
 * @package incrementtum
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
require_once plugin_dir_path( __FILE__ ) . 'ipp-simple-loading-settings.php';

add_action( 'admin_enqueue_scripts', 'ipp_simple_loading_admin_enqueue_scripts' );


/**
 * Enqueue scripts and styles.
 *
 * @param string $hook the hook.
 * @return void
 */
function ipp_simple_loading_admin_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_ipp_simple_loading' === $hook ) {
		wp_enqueue_media();

		wp_enqueue_script( 'ipp_simple_loading-script', plugin_dir_url( __FILE__ ) . '../assets/js/admin.min.js', array( 'wp-element' ), '2.2.1', true );
		wp_localize_script(
			'ipp_simple_loading-script',
			'ippLoadingMyvar',
			array(
				'nonce' => wp_create_nonce( 'wp_rest' ),
			)
		);

		$the_pages = ipp_simple_loading_get_pages_list();

		wp_localize_script(
			'ipp_simple_loading-script',
			'ippLoadingThePages',
			$the_pages,
		);

		$the_post_types = ipp_simple_loading_get_post_types();
		wp_localize_script(
			'ipp_simple_loading-script',
			'ippLoadingThePostTypes',
			$the_post_types,
		);

		$the_post_types = ipp_simple_loading_get_post_types();
		wp_localize_script(
			'ipp_simple_loading-script',
			'ippLoadingSiteUrl',
			array(
				'siteUrl' => get_site_url(),
			),
		);

		wp_enqueue_style( 'ipp_simple_loading-admin-css', plugin_dir_url( __FILE__ ) . '../assets/css/admin/main.min.css', array(), '2.2.1' );
		wp_enqueue_style( 'ipp_simple_loading-public-css', plugin_dir_url( __FILE__ ) . '../assets/css/public/main.min.css', array(), '2.2.1' );

	}
}


/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function ipp_simple_loading_public_enqueue_scripts() {
	if ( ipp_simple_loading_should_load() ) {
		wp_enqueue_script( 'ipp_simple_loading-public-script', plugin_dir_url( __FILE__ ) . '../assets/js/public.min.js', array( 'wp-element' ), '2.2.1', false );
		$settings = ipp_loading_get_settings_public_data();
		wp_localize_script( 'ipp_simple_loading-public-script', 'ippLoadingSettings', $settings );
		wp_enqueue_style( 'ipp_simple_loading-public-css', plugin_dir_url( __FILE__ ) . '../assets/css/public/main.min.css', array(), '2.2.1' );
	}
}

add_action( 'wp_enqueue_scripts', 'ipp_simple_loading_public_enqueue_scripts' );




/**
 * Init Loading Container.
 *
 * @return void
 */
function ipp_simple_loading_add_container_div() {
	if ( ipp_simple_loading_should_load() ) {
		echo '<style id="ipp_simple_loading_screen_inline_style">body{visibility:hidden;}</style><noscript><style>body{visibility:visible;}</style></noscript>';
		echo '<div id="ipp_simple_loading_screen"></div>';

	}
}
// Add code after head.
add_action( 'wp_head', 'ipp_simple_loading_add_container_div' );
