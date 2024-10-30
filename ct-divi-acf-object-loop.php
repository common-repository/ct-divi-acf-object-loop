<?php
/*
Plugin Name: CT Divi ACF Object Loop
Plugin URI:  https://divicoding.com/downloads/divi-acf-object-loop/
Description: Add a new module to the Divi collection that will show ACF Post Object or Relationship field info in a grid.
Version:     1.0.5
Author:      Divi Coding
Author URI:  https://divicoding.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ct-aol
Domain Path: /languages

Divi ACF Object Loop is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Divi ACF Object Loop is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Divi ACF Object Loop. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CTAOL_VERSION', '1.0.5' );
define( 'CTAOL_FILE', __FILE__ );
define( 'CTAOL_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'CTAOL_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Init extension
if ( ! function_exists( 'ctaol_initialize_extension' ) ) {
	function ctaol_initialize_extension() {
		require_once CTAOL_DIR_PATH . 'includes/CtDiviAcfObjectLoop.php';
		require_once CTAOL_DIR_PATH . 'includes/CtAOLUtils.php';
	}

	add_action( 'divi_extensions_init', 'ctaol_initialize_extension' );
}