<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\DriverManager;

$app->post(
    '/registeruser',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_parameters = $request->getParsedBody();
        $cleaned_parameters = cleanupParameters($app, $tainted_parameters);
        $hashed_password = hash_password($app, $cleaned_parameters['password']);

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];
        $username_count = checkDuplicateUsername($app, $cleaned_parameters);
        $params_length = lengthCheck($app, $cleaned_parameters['password'],$cleaned_parameters['sanitised_username']);


        if($username_count == 0 && $params_length == false)
        {
            storeUserDetails($app, $cleaned_parameters, $hashed_password);
            $html_output2 =  $this->view->render($response,
                'register_user_result.html.twig',
                [
                    'landing_page' => $_SERVER["SCRIPT_NAME"],
                    'css_path' => CSS_PATH,
                    'page_heading' => APP_NAME,
                    'page_heading_1' => 'New User Registration',
                    'page_heading_2' => ' / New User Registration',
                    'username' => $tainted_parameters['username'],
                    'password' => $tainted_parameters['password'],
                    'email' => $tainted_parameters['email'],
                    'sanitised_username' => $cleaned_parameters['sanitised_username'],
                    'cleaned_password' => $cleaned_parameters['password'],
                    'sanitised_email' => $cleaned_parameters['sanitised_email'],
                    'hashed_password' => $hashed_password,
                    'is_logged_in' => $isloggedin,
                    'sign_out_form' => $sign_out_form_visibility,
                ]);
            return $html_output2;

        } else {
            $html_output = $this->view->render($response,
                'register.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'action' => 'registeruser',
                    'initial_input_box_value' => null,
                    'page_heading_2' => '/ Password and username must be at least 8 characters',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                ]);

            return $html_output;
        }

    })->setName('register');

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

function checkDuplicateUsername($app, array $cleaned_parameters)
{

    $storage_result = [];
    $store_result = '';
    $cleaned_username = $cleaned_parameters['sanitised_username'];
    $database_connection_settings = $app->getContainer()->get('settings');
    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
    $database_connection = DriverManager::getConnection($database_connection_settings['doctrine_settings']);

    $queryBuilder = $database_connection->createQueryBuilder();

    $username_count = $doctrine_queries::querySelectUsername($queryBuilder, $cleaned_username);

    return $username_count;
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

function lengthCheck($app, $password, $username)
{

    if((strlen($password) < 8) || (strlen($username) < 8))
    {
        $error = "Password and username must be at least 8 chars";
        return $error;
    } else {
        $error = false;
        return $error;
    }
}