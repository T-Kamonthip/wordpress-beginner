<?php

class PAP_Shortcode {

    public function __construct() {
        add_shortcode('api_posts', [$this, 'render']);
    }

    public function render() {

        $api = new PAP_API_Client();
        $posts = $api->get_posts();

        if (!$posts) {
            return "No data found";
        }

        $html = "<ul>";

        foreach ($posts as $post) {
            $html .= "<li>" . esc_html($post->title) . "</li>";
        }

        $html .= "</ul>";

        return $html;
    }

}