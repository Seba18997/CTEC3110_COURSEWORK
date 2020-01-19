<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */ '/updatesettings',
    function(Request $request, Response $response) use ($app)
    {
        $session_check = sessionCheckAdmin($app);

        if($session_check == false)
        {
            $this->get('logger')->info("Admin is not logged in to make any changes in settings.");
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        } else {
            $settings = $request->getParsedBody();
            $settingsa = cleanupArray($app, $settings);

            updateSettings($app, $settingsa);

            $isloggedin = ifSetUsername($app)['introduction'];
            $username = ifSetUsername($app)['username'];
            $role = ifSetUsername($app)['role'];
            $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

            $this->get('logger')->info("Admin (".$username.") changed settings successfully.");

            return $this->view->render($response,
                'settings_changed.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'initial_input_box_value' => null,
                    'page_heading' => APP_NAME,
                    'page_heading_2' => ' / Settings Changed ',
                    'page_title' => APP_NAME.' | Settings Changed',
                    'action4' => 'changesettings',
                    'action3' => 'logout',
                    'method' => 'post',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'role' => $role,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'block',
                ]);
        }
    })->setName('updatesettings');

/**
 * @param $app
 * @param $final_settings
 * @return mixed
 */
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

/**
 * @param $app
 * @param $tainted_array
 * @return mixed
 */
function cleanupArray($app, $tainted_array)
{
    $validator = $app->getContainer()->get('Validator');
    $cleaned_array = $validator->sanitiseArray($tainted_array);
    return $cleaned_array;
}
