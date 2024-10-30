<?php
/**
 * Constants for the settings.
 *
 * @package incrementtum
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! defined( 'IPP_SIMPLE_LOADING_GENENERAL_SETTINGS_KEY' ) ) {
	define( 'IPP_SIMPLE_LOADING_GENENERAL_SETTINGS_KEY', array( 'backgroundImage', 'backgroundEffectColor', 'backgroundEffect', 'type', 'enabled', 'fixedDelay', 'loadingText', 'exitAnim', 'displayExitButton', 'entranceAnim', 'entranceDelay', 'exitButtonColor', 'logo', 'advanced', 'preventScrollFromLoading' ) );
}

if ( ! defined( 'IPP_SIMPLE_LOADING_DEFAULT_SETTINGS' ) ) {
	define(
		'IPP_SIMPLE_LOADING_DEFAULT_SETTINGS',
		array(
			'enabled'                  => false,
			'preventScrollFromLoading' => true,
			'backgroundEffect'         => 'none',
			'backgroundEffectColor'    => '#dce4eb33',
			'backgroundImage'          => array(
				'url'                 => '',
				'backgroundSize'      => 'cover',
				'backgroundRepeat'    => 'no-repeat',
				'backgroundBlendMode' => 'overlay',
			),
			'type'                     => 'circle',
			'fixedDelay'               => 800,
			'entranceAnim'             => 'fadeIn',
			'entranceDelay'            => 200,
			'displayExitButton'        => false,
			'exitButtonColor'          => '#FAEE15',
			'loadingText'              => array(
				'enabled'  => false,
				'text'     => 'Lorem ipsum',
				'fontSize' => 14,
				'color'    => '#FAEE15',
				'bold'     => false,
			),
			'exitAnim'                 => 'fadeOut',
			'circle'                   => array(
				'bgColor'         => '#000000e0',
				'size'            => 100,
				'borderThickness' => 10,
				'baseColor'       => '#FAEE15',
				'accentColor'     => '#60b3f7',

			),
			'circle2'                  => array(
				'bgColor'         => '#000000e0',
				'size'            => 100,
				'borderThickness' => 10,
				'baseColor'       => '#FAEE15',
				'accentColor'     => '#60b3f7',

			),
			'circle3'                  => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'spinner'                  => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'spinner2'                 => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'pulse'                    => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'pulse2'                   => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'square'                   => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'square2'                  => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'square3'                  => array(
				'bgColor'     => '#000000e0',
				'size'        => 100,
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'pie'                      => array(
				'size'        => 100,
				'bgColor'     => '#000000e0',
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'bar'                      => array(
				'size'        => 100,
				'bgColor'     => '#000000e0',
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'bar2'                     => array(
				'size'        => 100,
				'bgColor'     => '#000000e0',
				'baseColor'   => '#FAEE15',
				'accentColor' => '#60b3f7',

			),
			'logo'                     => array(
				'size'               => 100,
				'entranceAnim'       => 'fadeIn',
				'entranceDelay'      => 200,
				'imageUrl'           => '',
				'logoAnim'           => 'none',
				'logoAnimDelay'      => 1500,
				'marginBottom'       => 30,
				'isInfiniteLogoAnim' => true,
			),
			'none'                     => array(
				'bgColor' => '#000000e0',
			),
			'advanced'                 => array(
				'selectedPages'         => array(),
				'allPages'              => true,
				'showInHomePage'        => true,
				'allPosts'              => true,
				'selectedPostTypes'     => array(),
				'showOneTimePerSession' => false,
			),
		)
	);
}
