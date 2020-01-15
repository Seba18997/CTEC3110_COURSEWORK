<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\DriverManager;

$app->post(
    '/registeruser',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_parameters = $request->getParsedBody();
        //var_dump($tainted_parameters);
        $cleaned_parameters = cleanupParameters($app, $tainted_parameters);
        $encrypted = encrypt($app, $cleaned_parameters);
        $hashed_password = hash_password($app, $cleaned_parameters['password']);
        $encoded = encode($app, $encrypted);
        $decrypted = decrypt($app, $encoded);
        $storage_result = storeUserDetails($app, $cleaned_parameters, $hashed_password);
        $libsodium_version = SODIUM_LIBRARY_VERSION;


        $html_output =  $this->view->render($response,
            'register_user_result.html.twig',
            [
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'css_path' => CSS_PATH,
                'page_heading' => APP_NAME,
                'page_heading_1' => 'New User Registration',
                'page_heading_2' => 'New User Registration',
                'username' => $tainted_parameters['username'],
                'password' => $tainted_parameters['password'],
                'email' => $tainted_parameters['email'],
                'sanitised_username' => $cleaned_parameters['sanitised_username'],
                'cleaned_password' => $cleaned_parameters['password'],
                'sanitised_email' => $cleaned_parameters['sanitised_email'],
                'hashed_password' => $hashed_password,
                'libsodium_version' => $libsodium_version,
                'nonce_value_username' => $encrypted['encrypted_username_and_nonce']['nonce'],
                'encrypted_username' => $encrypted['encrypted_username_and_nonce']['encrypted_string'],
                'nonce_value_email' => $encrypted['encrypted_username_and_nonce']['nonce'],
                'encrypted_email' => $encrypted['encrypted_email_and_nonce']['encrypted_string'],
                'encoded_username' => $encoded['encoded_username'],
                'encoded_email' => $encoded['encoded_email'],
                'decrypted_username' => $decrypted['username'],
                'decrypted_email' => $decrypted['email'],
                'storage_result' => $storage_result,
            ]);

        processOutput($app, $html_output);

        return $html_output;
    });

/**
 * @param $app
 * @param array $cleaned_parameters
 * @param string $hashed_password
 * @return string
 */

function storeUserDetails($app, array $cleaned_parameters, string $hashed_password): string
{
    $storage_result = [];
    $store_result = '';
    $database_connection_settings = $app->getContainer()->get('settings');
    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
    $database_connection = DriverManager::getConnection($database_connection_settings['doctrine_settings']);

    $queryBuilder = $database_connection->createQueryBuilder();

    $storage_result = $doctrine_queries::queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password);

    if ($storage_result['outcome'] == 1) {
        $store_result = 'User data was successfully stored using the SQL query: ' . $storage_result['sql_query'];
    } else {
        $store_result = 'There appears to have been a problem when saving your details.  Please try again later.';

    }
    return $store_result;
}

function cleanupParameters($app, $tainted_parameters)
{
    $cleaned_parameters = [];
    $validator = $app->getContainer()->get('Validator');

    $tainted_username = $tainted_parameters['username'];
    $tainted_email = $tainted_parameters['email'];

    $cleaned_parameters['password']
        = $tainted_parameters['password'];

    $cleaned_parameters['sanitised_username']
        = $validator->sanitiseString($tainted_username);

    $cleaned_parameters['sanitised_email']
        = $validator->sanitiseEmail($tainted_email);

    return $cleaned_parameters;
}

function encrypt($app, $cleaned_parameters)
{
    $libsodium_wrapper = $app->getContainer()->get('libSodiumWrapper');

    $encrypted = [];
    $encrypted['encrypted_username_and_nonce']
        = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_username']);

    $encrypted['encrypted_email_and_nonce']
        = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_email']);

    return $encrypted;
}


/**
 * Bcrypt library used
 *
 * @param $app
 * @param $password_to_hash
 * @return string
 */

function hash_password($app, $password_to_hash): string
{
    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
    $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash);
    return $hashed_password;
}


/**
 * @param $base64_wrapper
 * @param $encrypted_data
 * @return array
 */
function encode($app, $encrypted_data)
{
    $base64_wrapper = $app->getContainer()->get('base64Wrapper');

    $encoded = [];
    $encoded['encoded_username'] = $base64_wrapper->encode_base64
    ($encrypted_data['encrypted_username_and_nonce']['nonce_and_encrypted_string']);

    $encoded['encoded_email'] = $base64_wrapper->encode_base64
    ($encrypted_data['encrypted_email_and_nonce']['nonce_and_encrypted_string']);

    return $encoded;
}


/**
 * function decodes base64, then decrypts the cipher code
 *
 * @param $libsocdium wrapper
 * @param $base64_wrapper
 * @param $encoded
 * @return array
 */
function decrypt($app, $encoded): array
{
    $decrypted_values = [];
    $base64_wrapper = $app->getContainer()->get('base64Wrapper');
    $libsodium_wrapper = $app->getContainer()->get('libSodiumWrapper');

    $decrypted_values['username'] = $libsodium_wrapper->decrypt(
        $base64_wrapper,
        $encoded['encoded_username']
    );

    $decrypted_values['email'] = $libsodium_wrapper->decrypt(
        $base64_wrapper,
        $encoded['encoded_email']
    );

    return $decrypted_values;
}