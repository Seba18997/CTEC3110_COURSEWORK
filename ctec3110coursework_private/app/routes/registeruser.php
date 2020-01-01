<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->post(
    '/registeruser',
    function(Request $request, Response $response) use ($app)
    {

        $html_output =  $this->view->render($response,
            'register_user_result.html.twig',
            [
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'css_path' => CSS_PATH,
                'page_title' => APP_NAME,
                'page_heading_1' => 'New User Registration',
                'page_heading_2' => 'New User Registration',
                'username' => $tainted_parameters['username'],
                'password' => $tainted_parameters['password'],
                'email' => $tainted_parameters['email'],
                'requirements' => $tainted_parameters['requirements'],
                'sanitised_username' => $cleaned_parameters['sanitised_username'],
                'cleaned_password' => $cleaned_parameters['password'],
                'sanitised_email' => $cleaned_parameters['sanitised_email'],
                'sanitised_requirements' => $cleaned_parameters['sanitised_requirements'],
                'hashed_password' => $hashed_password,
                'libsodium_version' => $libsodium_version,
                'nonce_value_username' => $encrypted['encrypted_username_and_nonce']['nonce'],
                'encrypted_username' => $encrypted['encrypted_username_and_nonce']['encrypted_string'],
                'nonce_value_email' => $encrypted['encrypted_username_and_nonce']['nonce'],
                'encrypted_email' => $encrypted['encrypted_email_and_nonce']['encrypted_string'],
                'nonce_value_dietary_requirements' => $encrypted['encrypted_username_and_nonce']['nonce'],
                'encrypted_requirements' => $encrypted['encrypted_dietary_requirements_and_nonce']['encrypted_string'],
                'encoded_username' => $encoded['encoded_username'],
                'encoded_email' => $encoded['encoded_email'],
                'encoded_requirements' => $encoded['encoded_requirements'],
                'decrypted_username' => $decrypted['username'],
                'decrypted_email' => $decrypted['email'],
                'decrypted_dietary_requirements' => $decrypted['dietary_requirements'],
                'storage_result' => $storage_result,
            ]);

        processOutput($app, $html_output);

        return $html_output;
    });