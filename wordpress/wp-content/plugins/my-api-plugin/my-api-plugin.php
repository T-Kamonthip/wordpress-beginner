<?php
/**
 * Plugin Name: My API Plugin
 * Description: Example plugin connect REST API
 * Version: 1.0
 * Author: Dev
 */

if (!defined('ABSPATH')) {
    exit;
}

function my_api_get_data() {

    $response = wp_remote_get("https://jsonplaceholder.typicode.com/posts");

    if (is_wp_error($response)) {
        return "API Error";
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    return $data;
}

function my_api_shortcode() {

    $data = my_api_get_data();

    if (!$data) {
        return "No data";
    }

    $output = "<ul>";

    foreach ($data as $post) {
        $output .= "<li>" . esc_html($post->title) . "</li>";
    }

    $output .= "</ul>";

    return $output;
}

add_shortcode('my_api_posts', 'my_api_shortcode');