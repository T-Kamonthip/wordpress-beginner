<?php
/*
Plugin Name: Keycloak Login
Description: Login with Keycloak SSO
*/

require_once plugin_dir_path(__FILE__) . 'config.php';
require_once plugin_dir_path(__FILE__) . 'auth.php';

add_shortcode('keycloak_login', 'keycloak_login_button');

function keycloak_login_button() {
    return '<a href="'. keycloak_login_url() .'">Login with Keycloak</a>';
}