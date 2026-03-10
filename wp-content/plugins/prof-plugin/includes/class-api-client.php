<?php

class PAP_API_Client {

    private $api_url = "https://jsonplaceholder.typicode.com/posts";

    public function get_posts() {

        $cache = get_transient("pap_api_cache");

        if ($cache) {
            return $cache;
        }

        $response = wp_remote_get($this->api_url);

        if (is_wp_error($response)) {
            return [];
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);

        set_transient("pap_api_cache", $data, 3600);

        return $data;
    }

}