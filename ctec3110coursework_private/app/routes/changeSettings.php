<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

    '/changeSettings',
    function(Request $request, Response $response) use ($app)
    {

        $settings = changeSettings($app);
        var_dump($settings['settings']['app_name']);
        return $this->view->render($response,
            'change_settings.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_heading' => APP_NAME,
                'page_heading_2' => ' / Change Settings ',
                'action3' => 'logout',
                'method' => 'post',
                'app_name' => $settings['settings']['app_name'],
                'wsdl' => $settings['settings']['wsdl'],
                'wsdl_username' => $settings['settings']['wsdl_username'],
                'wsdl_password' => $settings['settings']['wsdl_password'],
                'wsdl_messagecounter' => $settings['settings']['wsdl_messagecounter'],
                'db_host' => $settings['settings']['db_host'],
                'db_name' => $settings['settings']['db_name'],
                'db_port' => $settings['settings']['db_port'],
                'db_user' => $settings['settings']['db_user'],
                'db_userpassword' => $settings['settings']['db_userpassword'],
                'db_charset' => $settings['settings']['db_charset'],
                'db_collation' => $settings['settings']['db_collation'],
                'doctrine_driver' => $settings['settings']['doctrine_driver'],
            ]);

    })->setName('changeSettings');

function changeSettings($app)
{

    $settings_model = $app->getContainer()->get('SettingsModel');
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $settings_model->setSqlQueries($sql_queries);
    $settings_model->setDatabaseConnectionSettings($database_connection_settings);
    $settings_model->setDatabaseWrapper($database_wrapper);


    $settings = $settings_model->getSettingsFromDB();


    return $settings;

}