<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->post(
/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */
    '/afterlogin',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_parameters  = $request->getParsedBody();
        $tainted_username = $tainted_parameters['user_name'];
        $password = $tainted_parameters['password'];
        $cleaned_username = cleanupUsername($app, $tainted_username);

        $db_usernamePassword = paramsFromDB($app, $cleaned_username);

        $outcome = compare($app, $db_usernamePassword['password'], $password);


        if($outcome == 1 )
        {
            return $this->view->render($response,
                'invalid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'method' => 'post',
                    'action' => 'login',
                    'page_title' => 'Login Form',
                    'page_heading_1' => 'Invalid credentials',
                ]);
        } else {

            return $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'method' => 'post',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => 'Login Form',
                    'page_heading_1' => 'User logged in',
                ]);}

    })->setName('afterlogin');


/**
 * @param $app
 * @param $tainted_username
 * @return mixed
 */

function cleanupUsername($app, $tainted_username)
{

    $validator = $app->getContainer()->get('Validator');

    $tainted_username = $tainted_username;

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

    $final_states = $auth_model->getUsernamePassword($username);

    return $final_states;
}

/**
 * @param $app
 * @param $db_pass
 * @param $typed_pass
 * @return int
 */

function compare($app, $db_pass, $typed_pass)
{
    if($db_pass == 1)
    {
        $outcome = 1;
    }

    $compare = $app->getContainer()->get('bcryptWrapper');
    $outcome = $compare->authenticatePassword($typed_pass, $db_pass);

    if($outcome == true)
    {
        $outcome = 2;
        return $outcome;

    }else{

        $outcome = 1;
        return $outcome;

    }
}

