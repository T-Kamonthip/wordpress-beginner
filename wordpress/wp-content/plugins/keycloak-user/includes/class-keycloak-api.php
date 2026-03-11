<?php

class Keycloak_API
{

    private $base_url = 'http://localhost:8080';
    private $realm = 'myrealm';

    private $admin_user = 'admin';
    private $admin_password = 'Zara@123';
    private $client_id = 'admin-cli';

    private function get_token()
    {

        $cached = get_transient('kc_admin_token');

        if ($cached) {
            return $cached;
        }

        $response = wp_remote_post(
            $this->base_url . '/realms/master/protocol/openid-connect/token',
            [
                'body' => [
                    'grant_type' => 'password',
                    'client_id' => $this->client_id,
                    'username' => $this->admin_user,
                    'password' => $this->admin_password
                ]
            ]
        );

        echo wp_remote_retrieve_response_message($response);

        $body = json_decode(wp_remote_retrieve_body($response), true);

        $token = $body['access_token'];

        set_transient('kc_admin_token', $token, 300);

        return $token;
    }

    public function create_user($data)
    {

        $token = $this->get_token();

        $response = wp_remote_post(
            $this->base_url . '/admin/realms/' . $this->realm . '/users',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($data)
            ]
        );

        error_log(print_r($response, true));

        return $response;
    }

    public function get_users()
    {

        $token = $this->get_token();

        $response = wp_remote_get(
            $this->base_url . '/admin/realms/' . $this->realm . '/users',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]
        );

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public function delete_user($user_id)
    {

        $token = $this->get_token();

        return wp_remote_request(
            $this->base_url . '/admin/realms/' . $this->realm . '/users/' . $user_id,
            [
                'method' => 'DELETE',
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]
        );
    }

    public function update_user($user_id, $data)
    {

        $token = $this->get_token();

        return wp_remote_request(
            $this->base_url . '/admin/realms/' . $this->realm . '/users/' . $user_id,
            [
                'method' => 'PUT',
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($data)
            ]
        );
    }
}