<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\DriverManager;

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

$app->post('/registeruser',
    function (Request $request, Response $response) use ($app) {
        $tainted_parameters = $request->getParsedBody();
        $cleaned_parameters = cleanupParameters($app, $tainted_parameters);
        $hashed_password = hash_password($app, $cleaned_parameters['password']);

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];

        $username_count = checkDuplicateUsername($app, $cleaned_parameters);
        $username_error = usernameCheck($tainted_parameters['username']);
        $password_error = passwordCheck($tainted_parameters['password']);

        if ($username_count == 0 && $username_error == false && $password_error == false) {
            $this->get('logger')->info("New user successfully registered: " . $cleaned_parameters['sanitised_username']);
            storeUserDetails($app, $cleaned_parameters, $hashed_password);
            return $this->view->render($response,
                'register_user_result.html.twig',
                [
                    'landing_page' => $_SERVER["SCRIPT_NAME"],
                    'css_path' => CSS_PATH,
                    'page_heading' => APP_NAME,
                    'page_title' => APP_NAME . ' | Successful New User Registration: ' . $cleaned_parameters['sanitised_username'],
                    'page_heading_2' => ' / Successful New User Registration',
                    'username' => $tainted_parameters['username'],
                    'password' => $tainted_parameters['password'],
                    'email' => $tainted_parameters['email'],
                    'sanitised_username' => $cleaned_parameters['sanitised_username'],
                    'cleaned_password' => $cleaned_parameters['password'],
                    'sanitised_email' => $cleaned_parameters['sanitised_email'],
                    'hashed_password' => $hashed_password,
                    'is_logged_in' => $isloggedin,
                    'sign_out_form' => 'none',
                    'back_button_visibility' => 'block',
                    'method' => 'post',
                    'action4' => 'login',
                ]);

        } else {
            $this->get('logger')->info("Registration process failed because of not meeting minimal requirements of username/password.");
            if ($username_count !== 0) {
                $username_duplicate = 'Your username already exists in our database.';
            } else {
                $username_duplicate = false;
            }
            return $this->view->render($response,
                'register_error.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'action' => 'registeruser',
                    'initial_input_box_value' => null,
                    'page_heading_2' => ' / New User Registration',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => 'none',
                    'back_button_visibility' => 'block',
                    'username_error' => $username_error,
                    'password_error' => $password_error,
                    'username_duplicate' => $username_duplicate,
                ]);

        }

    })->setName('register');

/**
 * @param $app
 * @param array $cleaned_parameters
 * @param string $hashed_password
 * @return string
 */

function storeUserDetails($app, $cleaned_parameters, $hashed_password)
{
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

/**
 * @param $app
 * @param $cleaned_parameters
 * @return mixed
 */
function checkDuplicateUsername($app, $cleaned_parameters)
{
    $cleaned_username = $cleaned_parameters['sanitised_username'];
    $database_connection_settings = $app->getContainer()->get('settings');
    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
    $database_connection = DriverManager::getConnection($database_connection_settings['doctrine_settings']);

    $queryBuilder = $database_connection->createQueryBuilder();

    $username_count = $doctrine_queries::querySelectUsername($queryBuilder, $cleaned_username);

    return $username_count;
}

/**
 * @param $app
 * @param $tainted_parameters
 * @return array
 */
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

function hash_password($app, $password_to_hash)
{
    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
    $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash);
    return $hashed_password;
}

/**
 * @param $username
 * @return string
 */
function usernameCheck($username)
{
    $error = '';

    if ((strlen($username) <= 4) || (strlen($username) >= 15)) {
        $error = 'Your username must be at least 4 and maximum 15 characters long.';
    } elseif (ctype_alnum($username) == false) {
        $error = 'Your username must contain only letters and digits.';
    }

    return $error;
}

/**
 * @param $password
 * @return string
 */
function passwordCheck($password)
{
    $error = '';

    if ((strlen($password)) <= 8) {
        $error = "Your password must contain at least 8 characters.";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $error = "Your password must contain at least 1 number.";
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $error = "Your password must contain at least 1 capital letter.";
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $error = "Your password must contain at least 1 lowercase letter.";
    }

    return $error;
}
