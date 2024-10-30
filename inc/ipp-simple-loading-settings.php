<?php
/**
 * Init the settings.
 *
 * @package incrementtum
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
require_once plugin_dir_path( __FILE__ ) . 'ipp-simple-loading-constants.php';


/**
 * Register settings.
 *
 * @return void
 */
function ipp_simple_loading_register_settings() {

	register_setting(
		'ipp_simple_loading',
		'ipp_simple_loading_options',
		array(

			'show_in_rest'      => true,
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

}
	add_action( 'admin_init', 'ipp_simple_loading_register_settings' );


/**
 * Recursive combine.
 *
 * @param array $defaults array of defaults.
 * @param array $options array of options.
 * @return array new data.
 */
function ipp_simple_loading_combine( $defaults, $options ) {
	if ( ! isset( $options ) || ! $options ) {
		$options = array();

	}
	// clean up.
	foreach ( array_keys( $options ) as $key ) {
		if ( ! array_key_exists( $key, $defaults ) ) {
			unset( $options[ $key ] );
		}
	}
	foreach ( $defaults as $key => $value ) {
		if ( in_array( $key, array( 'selectedPages', 'selectedPostTypes' ), true ) ) {
			// page ids and post types do not have defaults.
			continue;
		}
		if ( ! isset( $options[ $key ] ) ) {
			$options[ $key ] = $value;
		}
		if ( is_array( $defaults[ $key ] ) ) {
			$options[ $key ] = ipp_simple_loading_combine( $defaults[ $key ], $options[ $key ] );
		}
	}

	return $options;
}



/**
 * Gets the list of pages.
 *
 * @return array pages.
 */
function ipp_simple_loading_get_pages_list() {
	return array_map(
		function( $p ) {
			return array(
				'postId'    => $p->ID,
				'postTitle' => $p->post_title,
			);
		},
		get_pages( array( 'post_status' => 'publish' ) )
	);
}



/**
 * Gets the list of post types.
 *
 * @return array post type.
 */
function ipp_simple_loading_get_post_types() {
	return array_values(
		array_map(
			function( $p ) {
				return array(
					'value' => $p->name,
					'label' => $p->labels->singular_name,
				);
			},
			array_filter(
				get_post_types( array( 'public' => true ), $output = 'objects ' ),
				function( $p ) {
					return 'page' !== $p->name;
				}
			)
		)
	);
}


/**
 * Sets cookie for tracking session on browser if enabled.
 *
 * @return array void.
 */
function ipp_loading_set_init_once_per_loading() {
	$options = ipp_loading_get_settings_data();
	if ( ! $options['enabled'] ) {
		return;
	}
	$advanced = $options['advanced'];
	if ( isset( $advanced ) ) {
		if ( $advanced['showOneTimePerSession'] ) {
			if ( ! isset( $_COOKIE['ipp_loading_session'] ) ) {
				setcookie( 'ipp_loading_session', 1, 0 );
			}
		}
	}
}

add_action( 'init', 'ipp_loading_set_init_once_per_loading' );

/**
 * Checks if loading should enqueue.
 *
 * @return boolean.
 */
function ipp_simple_loading_should_load() {

	if ( is_admin() ) {
		return false;
	}
	// Do not add if in elementor.
	if ( ! empty( $_REQUEST['elementor-preview'] ) ) {
		return false;
	}

	$options = ipp_loading_get_settings_data();
	// Check if enabled.
	if ( ! $options['enabled'] ) {
		return false;
	}
	$advanced = $options['advanced'];
	// Session logic.
	if ( $advanced['showOneTimePerSession'] ) {
		return ! isset( $_COOKIE['ipp_loading_session'] );
	}

	// Pages logic.
	$is_front_page = is_front_page();
	$is_page       = is_page();
	$the_post_id   = get_the_ID();
	if ( $advanced['allPages'] && ( $is_front_page || $is_page ) ) {
		return true;
	}
	if ( $is_front_page ) {
		return $advanced['showInHomePage'];
	}
	if ( $is_page ) {
		return in_array( $the_post_id, $advanced['selectedPages'], true );

	}
	// Check other public post types except pages.
	$the_current_post_object = get_post( $the_post_id, $output = OBJECT );
	if ( isset( $the_current_post_object ) ) {
		$the_current_post_type = $the_current_post_object->post_type;
		if ( 'page' !== $the_current_post_type ) {
			if ( $advanced['allPosts'] ) {
				return true;
			}
			return in_array( $the_current_post_type, $advanced['selectedPostTypes'], true );
		}
	}
	return false;
}
/**
 * Combines array with defaults if not set.
 *
 * @param array $options array of settings.
 * @return array data.
 */
function ipp_simple_loading_combine_defaults( $options ) {
	$defaults = IPP_SIMPLE_LOADING_DEFAULT_SETTINGS;
	if ( ! isset( $options ) || ! $options ) {
		return $defaults;
	}
	$final_options = ipp_simple_loading_combine( $defaults, $options );

	if ( isset( $final_options['advanced'] ) ) {
		// clean up pages stored if ever some are deleted.

		if ( isset( $final_options['advanced']['selectedPages'] ) ) {
			$the_page_ids = array_map(
				function( $p ) {
					return $p['postId'];
				},
				ipp_simple_loading_get_pages_list()
			);
			foreach ( $final_options['advanced']['selectedPages'] as $key => $val ) {
				if ( ! in_array( $val, $the_page_ids, true ) ) {
					unset( $final_options['advanced']['selectedPages'][ $key ] );

				}
			}
		}
		// clean up other post types stored if ever some are deleted.
		if ( isset( $final_options['advanced']['selectedPostTypes'] ) ) {
			$the_post_types = array_map(
				function( $p ) {
					return $p['value'];
				},
				ipp_simple_loading_get_post_types()
			);
			foreach ( $final_options['advanced']['selectedPostTypes'] as $key => $val ) {
				if ( ! in_array( $val, $the_post_types, true ) ) {
					unset( $final_options['advanced']['selectedPostTypes'][ $key ] );

				}
			}
		}
	}
		return $final_options;
}

/**
 * Retrieves the settings data.
 *
 * @return array data.
 */
function ipp_loading_get_settings_data() {
	return ipp_simple_loading_combine_defaults( get_option( 'ipp_simple_loading_options' ) );
}


/**
 * Removes unused settings data for public use.
 *
 * @return array data.
 */
function ipp_loading_get_settings_public_data() {

	$settings = ipp_loading_get_settings_data();
	$type     = $settings['type'];
	$advanced = $settings['advanced'];

	if ( isset( $advanced ) ) {
		unset( $settings['advanced'] );
	}

	if ( isset( $type ) ) {
		$type_key = str_replace( '-', '', $type );
		foreach ( array_keys( $settings ) as $key ) {
			if ( in_array( $key, IPP_SIMPLE_LOADING_GENENERAL_SETTINGS_KEY, true ) ) {
				continue;
			}
			if ( $type_key !== $key ) {
				unset( $settings[ $key ] );

			}
		}
	}
	return $settings;

}


/**
 * Retrieves the settings.
 *
 * @return WP_REST_Response data.
 */
function ipp_simple_loading_get_settings() {
	return new WP_REST_Response( ipp_loading_get_settings_data() );
}
/**
 * Updates the settings.
 *
 * @param  WP_REST_Request $request the updated request.
 * @return WP_REST_Response updated data.
 */
function ipp_simple_loading_save_settings( WP_REST_Request $request ) {
	update_option( 'ipp_simple_loading_options', ipp_simple_loading_combine_defaults( $request->get_json_params() ) );
	return ipp_simple_loading_get_settings();
}



add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ipp_simple_loading/v1',
			'/settings',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => 'ipp_simple_loading_get_settings',
					'permission_callback' => function() {
						return current_user_can( 'manage_options' );
					},
				),
				array(
					'methods'             => 'POST',
					'callback'            => 'ipp_simple_loading_save_settings',
					'permission_callback' => function() {
						return current_user_can( 'manage_options' );
					},
				),
			)
		);

	}
);
