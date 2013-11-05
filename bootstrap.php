<?php

if ( !class_exists( 'WP_Dependency_Loader' ) ) {
	require_once dirname( __FILE__ ) . '/class-wp-dependency-loader.php';
}

if ( !function_exists( 'wp_load_dependency' ) ) {

	/**
	 * @param string $name The folder name of the plugin to load
	 * @param string $file The file name of the plugin to load, if not set, {$name}.php will be loaded
	 */
	function wp_load_dependency( $name, $file = false ) {
		if ( !$file ) {
			$file = $name . '.php';
		}
		$main_file = $name . DIRECTORY_SEPARATOR . $file;

		do_action( 'wp_load_dependency', $name, $file );
	}

}

if ( !has_action( 'wp_load_dependency' ) ) {
	$dep_loader = new WP_Dependency_Loader();
	$dep_loader->register_vendor_directory( WP_PLUGIN_DIR );
	add_action( 'wp_load_dependency', array( $dep_loader, 'load_plugin' ), 10, 2 );
	add_action( 'register_dependency_directory', array( $dep_loader, 'register_vendor_directory' ) );
	add_filter( 'plugins_url', array( $dep_loader, 'filter_plugins_url' ), 10, 3 );
}

do_action( 'register_dependency_directory', dirname( dirname( dirname( __FILE__ ) ) ) );