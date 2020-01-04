<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/login',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_parameters  = $request->getParsedBody();
        $username = $tainted_parameters['user_name'];
        $password = $tainted_parameters['password'];
        //var_dump($username);

        $db_usernamePassword = paramsFromDB($app, $username);

        echo "Password are the same (true/ false)";
        $outcome = compare($app, $db_usernamePassword['password'], $password);
        var_dump($outcome);



        return $this->view->render($response,
            'login.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'method' => 'post',
                'action' => 'afterlogin',
                'page_title' => 'Login Form',
                'page_heading_1' => 'Login To View Content',
            ]);

    })->setName('login');

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

function compare($app, $db_pass, $typed_pass)
{

    $compare = $app->getContainer()->get('bcryptWrapper');
    $final = $compare->authenticatePassword($typed_pass, $db_pass);
    return $final;
}