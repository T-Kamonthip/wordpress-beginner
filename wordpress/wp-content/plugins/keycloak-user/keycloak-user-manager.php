<?php
/**
 * Plugin Name: Keycloak User Manager
 * Description: Manage Keycloak users from WordPress
 * Version: 1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('KUM_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once KUM_PLUGIN_PATH . 'includes/class-keycloak-api.php';
require_once KUM_PLUGIN_PATH . 'admin/admin-page.php';

add_action('admin_menu', function () {
    add_menu_page(
        'Keycloak Users',
        'Keycloak Users',
        'manage_options',
        'keycloak-users',
        'kum_admin_page'
    );
});