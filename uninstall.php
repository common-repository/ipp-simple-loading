<?php
/**
 * Uninstall script.
 *
 * @package incrementtum
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}
delete_option( 'ipp_simple_loading_options' );
