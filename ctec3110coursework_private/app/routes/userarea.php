<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */

$app->post('/userarea',
    function (Request $request, Response $response) use ($app)
    {
        $tainted_parameters = $request->getParsedBody();
        $tainted_username = $tainted_parameters['user_name'];
        $password = $tainted_parameters['password'];
        $cleaned_username = cleanupUsername($app, $tainted_username);

        $db_params = paramsFromDB($app, $cleaned_username);

        $outcome = compare($app, $db_params['password'], $password);
        $sid = session_id();
        $user_role = $db_params['role'];

        if ($outcome == true) {
            $result = doSession($app, $db_params['password'], $cleaned_username, $sid, $user_role);
        }

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];
        $role = ifSetUsername($app)['role'];

        if ($outcome == false) {
            $this->get('logger')->info("User (" . $cleaned_username . ") provided invalid credentials during logging in.");
            return $this->view->render($response,
                'invalid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'login',
                    'page_title' => APP_NAME . ' | Invalid Credentials',
                    'page_heading_1' => 'Invalid credentials',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);
        } elseif ($user_role == 'user') {
            $this->get('logger')->info("User (" . $username . ") provided correct credentials during logging in.");
            return $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action3' => 'logout',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => APP_NAME . ' | User Area',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'role' => $role,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);
        } else {
            $this->get('logger')->info("Admin provided correct credentials during logging in.");
            $response = $response->withredirect(LANDING_PAGE . '/adminarea');
            return $response;
        }

    })->setName('userarea');


/**
 * @param $app
 * @param $tainted_username
 * @return mixed
 */

function cleanupUsername($app, $tainted_username)
{

    $validator = $app->getContainer()->get('Validator');

    $cleaned_username = $validator->sanitiseString($tainted_username);

    return $cleaned_username;
}


/**
 * @param $app
 * @param $username
 * @return mixed
 */

function paramsFromDB($app, $username)
{
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $auth_model = $app->getContainer()->get('Authentication');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $auth_model->setSqlQueries($sql_queries);
    $auth_model->setDatabaseConnectionSettings($database_connection_settings);
    $auth_model->setDatabaseWrapper($database_wrapper);

    $params = $auth_model->getParamsDb($username);

    return $params;
}

/**
 * @param $app
 * @param $db_pass
 * @param $typed_pass
 * @return int
 */

function compare($app, $db_pass, $typed_pass)
{
    if ($db_pass == 'Invalid_credentials') {
        $passwordCheck = false;
    } else {

        $compare = $app->getContainer()->get('bcryptWrapper');
        $passwordCheck = $compare->authenticatePassword($typed_pass, $db_pass);
    }

    if ($passwordCheck == true) {
        $outcome = true;
    } else {
        $outcome = false;
    }

    return $outcome;
}

/**
 * @param $app
 * @param $password
 * @param $username
 * @param $sid
 * @param $role
 * @return array
 */
function doSession($app, $password, $username, $sid, $role)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $session_model = $app->getContainer()->get('SessionModel');

    $session_model->setSessionUsername($username);
    $session_model->setSessionPassword($password);
    $session_model->setSessionId($sid);
    $session_model->setSessionRole($role);
    $session_model->setSessionWrapperFile($session_wrapper);
    $session_model->storeData();

    $store_var = array($session_wrapper->getSessionVar('username'),
        $session_wrapper->getSessionVar('password'),
        $session_wrapper->getSessionVar('sid'),
        $session_wrapper->getSessionVar('role'));

    return $store_var;
}

/**
 * @param $app
 * @return mixed
 */
function ifSetUsername($app)
{

    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $username = $session_wrapper->getSessionVar('username');
    $sid = $session_wrapper->getSessionVar('sid');
    $role = $session_wrapper->getSessionVar('role');

    if (!empty($username) || !empty($sid) || !empty($role)) {
        $result['introduction'] = 'You are logged in as ';
        $result['username'] = $username;
        $result['role'] = $role;
        $result['sign_out_form_visibility'] = 'inline';
    } else {
        $result['introduction'] = 'Log in to see messages/circuit board';
        $result['username'] = '';
        $result['role'] = '';
        $result['sign_out_form_visibility'] = 'none';
    }
    return $result;
}