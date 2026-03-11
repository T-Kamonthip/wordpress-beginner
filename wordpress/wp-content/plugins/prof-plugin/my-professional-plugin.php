<?php
/**
 * Plugin Name: Professional API Plugin
 * Description: Example professional WordPress plugin with REST API
 * Version: 1.0
 * Author: Dev
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PAP_PATH', plugin_dir_path(__FILE__));

require_once PAP_PATH . 'includes/class-api-client.php';
require_once PAP_PATH . 'includes/class-shortcode.php';
require_once PAP_PATH . 'includes/class-admin-page.php';

class Professional_API_Plugin {

    public function __construct() {

        new PAP_API_Client();
        new PAP_Shortcode();
        new PAP_Admin_Page();

    }

}

new Professional_API_Plugin();