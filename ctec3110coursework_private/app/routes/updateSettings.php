<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */
    '/updateSettings',
    function(Request $request, Response $response) use ($app)
    {
        $session_check = sessionCheckAdmin($app);

        if($session_check == false)
        {
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        }
        else {
            $settings = $request->getParsedBody();
            updateSettings($app, $settings);
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        }
    })->setName('updateSettings');

function updateSettings($app, $final_settings)
{

    $settings_model = $app->getContainer()->get('SettingsModel');
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $settings_model->setSqlQueries($sql_queries);
    $settings_model->setDatabaseConnectionSettings($database_connection_settings);
    $settings_model->setDatabaseWrapper($database_wrapper);


    $settings = $settings_model->updateSettings($final_settings);


    return $settings;

}

