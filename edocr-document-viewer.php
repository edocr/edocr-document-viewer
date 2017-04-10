<?php
/*
Plugin Name: edocr Document Viewer
Plugin URI: https://github.com/edocr/edocr-document-viewer
Description: The edocr Document Viewer for Wordpress allows you to embed your documents on your WordPress site using our feature rich document viewer
Author: edocr <info@edocr.com>
Author URI: http://edocr.com
Version: 1.0.2
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Dev environment switch
$EDOCR_DEV = 0;

$wp_edocr_plugin_path = plugin_dir_path( __FILE__ );
$wp_edocr_plugin_url = plugin_dir_url( __FILE__ );
$wp_edocr_embed_url = 'https://edocr.com/embed/';
$wp_edocr_embed_url_dev = 'https://dev.edocr.com/embed/';
$wp_edocr_service_agreement_url = 'https://www.edocr.com/v/aqegexna/edocr-service-agreement';
$wp_edocr_account_creation_url = 'https://www.edocr.com/account/create';
$wp_edocr_homepage_url = 'https://www.edocr.com';
$wp_edocr_search_url = 'https://edocr.com/search';
$wp_edocr_support_email = 'info@edocr.com';

include_once('include/edocr-document-viewer-functions.php');

//Adding Admin Hooks
add_action('admin_menu', 'wp_edocr_options_page');
add_shortcode('edocr', 'wp_edocr_shortcode');

?>
