<?php
/**
 * Plugin Name:     Register Custom Block Styles
 * Plugin URI:      https://github.com/your-username/register-custom-block-styles
 * Description:     A reusable class to register custom block styles with associated stylesheets from the active theme.
 * Author:          Elliott Richmond
 * Author URI:      https://elliottrichmond.co.uk
 * Text Domain:     register-custom-block-styles
 * Requires PHP:	7.4
 * License:			GPLv2 or later
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Register_Custom_Block_Styles
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include the class file.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-register-custom-block-styles.php';
