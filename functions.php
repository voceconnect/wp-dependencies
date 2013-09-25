<?php

if ( ! function_exists( 'wp_composer_load_plugin ') ) {
	/**
	 * @param string $name The folder name of the plugin to load
	 * @param string $file The file name of the plugin to load, if not set, {$name}.php will be loaded
	 * @return bool True/False whether the plugin was found and loaded
	 */
	function wp_composer_load_plugin( $name, $file = false) {
		if(!$file) {
			$file = $name . '.php';
		}
		$main_file = $name . DIRECTORY_SEPARATOR . $file;

		//try wordpress plugins directory first as that is where composer puts wordpress-plugins by default
		if(file_exists(WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $main_file)) {
			return include_once( WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $main_file );
		}

		if(file_exists( dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . $main_file)) {
			return include_once( dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . $main_file );
		}
	}
}