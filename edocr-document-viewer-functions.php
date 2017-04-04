<?php
/*
Plugin Name: edocr Document Viewer
Plugin URI: https://github.com/edocr/edocr-document-viewer
Description: The edocr Document Viewer for Wordpress allows you to embed your documents on your WordPress site using our feature rich document viewer
Author: edocr <info@edocr.com>
Author URI: http://edocr.com/
Version: 1.0
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/
  function wp_edocr_shortcode ($atts) {
    global $EDOCR_DEV;
    if (!function_exists('curl_version')) {
      $msg = 'Configuration Error: Missing PHP module: CURL';
      return wp_edocr_error_html($msg);
    }

    $guid = null;

    if (isset($atts['guid'])) {
      $guid = $atts['guid'];
      unset($atts['guid']);
      if ($EDOCR_DEV){
        $url = 'https://dev.edocr.com/embed/' . $guid;
      } else {
        $url = 'https://edocr.com/embed/' . $guid;
      }
      if (!isset($atts['type'])) {
        $atts['type'] = 'viewer';
      }
      $atts['source'] = 'wordpress';

      if (count($atts)){
        $url = $url . '?' . http_build_query($atts);
      }

      $embed = wp_edocr_get_document($url);

      return $embed;
    } else {
      return '';
    }
  }

  function wp_edocr_get_document ($url) {
    global $EDOCR_DEV;
    $timeout = 5;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    if ($EDOCR_DEV) {
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    if (!$data) {
      $result = curl_getinfo($ch);
      $err = 'Error: ' . $result['http_code'] . ' ' . curl_error($ch);

      return wp_edocr_error_html($err);
    } else {
      $result = curl_getinfo($ch);
      if ($result['http_code'] >= 399) {
        $msg = '<h3>Error ' . $result['http_code'] . '</h3><br>We couldn\'t find the edocr.com document you requested. Please check your document GUID (aka. Document ID Code) and try again.';
        if ($result['http_code'] == 403) {
          $msg = '<h3>Error ' . $result['http_code'] . '</h3><br>Embedding the document specified has been disallowed by the document owner. Please try another document or contact the document owner and ask them to enable document embedding in their document settings';
        }
        return wp_edocr_error_html($msg);
      } else {
        return $data;
      }
    }
  }

  function wp_edocr_error_html($message) {
    $err_html = '<div style="border: 3px solid black; padding: 25%; width: 100%; height: 100%;"><p style="text-align: center; font-size: .8em;">' . $message . '</p></div>';
    return $err_html;
  }

  function wp_edocr_options_page_html(){
    require(ABSPATH . 'wp-content/plugins/edocr-document-viewer/edocr-document-viewer-options.php');

  }

  function wp_edocr_options_page() {
    //We only execute any of this code if an admin user is logged in
    //This adds an options sub-menu underneath the settings menu
      add_submenu_page('options-general.php', 'edocr Document Viewer', 'edocr Document Viewer', 'manage_options', 'edocr_viewer', 'wp_edocr_options_page_html');
  }

?>
