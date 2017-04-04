<?php
/*
Plugin Name: edocr Document Viewer
Plugin URI: http://edocr.com/edocr-document-viewer/
Description: The edocr Document Viewer for Wordpress allows you to embed your documents on your WordPress site using our feature rich document viewer
Author: edocr <info@edocr.com>
Author URI: http://edocr.com/
Version: 1.0
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

//Do not allow direct page load
defined( 'ABSPATH' ) or die( 'Looking for something interesting to read? Check out edocr.com instead!');

//Dev environment switch
$EDOCR_DEV = 0;

include_once('edocr-document-viewer-functions.php');

//Adding Admin Hooks
add_action('admin_menu', 'wp_edocr_options_page');
add_shortcode('edocr', 'wp_edocr_shortcode');

?>
