<?php

function keycloak_login_url() {

    return KEYCLOAK_URL .
    '/protocol/openid-connect/auth?' .
    http_build_query([
        'client_id' => CLIENT_ID,
        'response_type' => 'code',
        'scope' => 'openid',
        'redirect_uri' => REDIRECT_URI
    ]);
}

add_action('init','keycloak_callback');

function keycloak_callback(){

    if(!isset($_GET['keycloak_callback'])) return;

    $code = $_GET['code'];

    $response = wp_remote_post(
        KEYCLOAK_URL.'/protocol/openid-connect/token',
        [
            'body'=>[
                'grant_type'=>'authorization_code',
                'client_id'=>CLIENT_ID,
                'client_secret'=>CLIENT_SECRET,
                'code'=>$code,
                'redirect_uri'=>REDIRECT_URI
            ]
        ]
    );

    $body = json_decode(wp_remote_retrieve_body($response), true);

    $userinfo = wp_remote_get(
        KEYCLOAK_URL.'/protocol/openid-connect/userinfo',
        [
            'headers'=>[
                'Authorization'=>'Bearer '.$body['access_token']
            ]
        ]
    );

    $user = json_decode(wp_remote_retrieve_body($userinfo), true);

    $email = $user['email'];

    if(!email_exists($email)){

        $user_id = wp_create_user(
            $user['preferred_username'],
            wp_generate_password(),
            $email
        );

    } else {

        $user_id = get_user_by('email',$email)->ID;

    }

    wp_set_auth_cookie($user_id);

    wp_redirect(home_url());

    exit;
}