<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */

$app->post('/authenticate',
    function (Request $request, Response $response) use ($app) {
        $posted_data = $request->getParsedBody();

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $session_check = sessionCheckAdmin($app);

        if ($session_check == false) {
            $this->get('logger')->info("Admin is not logged in to authenticate.");
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        } else {
            if ($posted_data['action'] == 'settings_changed') {
                $settingsa = cleanupArray($app, $posted_data);
                $encoded_array = json_encode($settingsa);
                $this->get('logger')->info("Admin (" . $username . ") changed settings successfully.");
                return $this->view->render($response,
                    'settings_changed.html.twig',
                    [
                        'css_path' => CSS_PATH,
                        'landing_page' => LANDING_PAGE,
                        'initial_input_box_value' => null,
                        'page_heading' => APP_NAME,
                        'page_heading_2' => ' / Settings Changed ',
                        'page_title' => APP_NAME . ' | Settings Changed',
                        'encoded_array' => $encoded_array,
                        'action4' => 'changesettings',
                        'action3' => 'logout',
                        'action5' => 'updatesettingsverification',
                        'action6' => 'changesettings',
                        'method' => 'post',
                        'is_logged_in' => $isloggedin,
                        'username' => $username,
                        'sign_out_form' => $sign_out_form_visibility,
                        'back_button_visibility' => 'block',
                    ]);

            } else if ($posted_data['action'] == 'users_changed') {
                $user_id = intval($posted_data['id']);
                $role_changes = changeRole($user_id, $app);
                $this->get('logger')->info("Admin (".$username.") successfully changed role of ".$role_changes['user_name']." to ".$role_changes['desired_role'].".");
                return $this->view->render($response,
                    'user_changed.html.twig',
                    [
                        'css_path' => CSS_PATH,
                        'landing_page' => LANDING_PAGE,
                        'initial_input_box_value' => null,
                        'page_heading' => APP_NAME,
                        'page_heading_2' => ' / Change User Role',
                        'page_title' => APP_NAME.' | Change User Role',
                        'action2' => $posted_data['id'],
                        'action4' => 'manageusers',
                        'action5' => 'updateuserverification',
                        'action3' => 'logout',
                        'method' => 'post',
                        'is_logged_in' => $isloggedin,
                        'username' => $username,
                        'sign_out_form' => $sign_out_form_visibility,
                        'back_button_visibility' => 'block',
                        'usernamex' => $role_changes['user_name'],
                        'old_role' => $role_changes['actual_role'],
                        'new_role' => $role_changes['desired_role'],
                    ]);
            }
        }

    })->setName('authenticate');

function changeRole($user_id, $app)
{
    $theuserid = $user_id - 1;

    $users_data = getUsers($app)['retrieved_users_data'];
    $user_role = $users_data[$theuserid]['role'];
    $user_name = $users_data[$theuserid]['username'];
    $resultx = [];

    if ($user_role == 'user') {
        $resultx['user_id'] = $user_id;
        $resultx['user_name'] = $user_name;
        $resultx['actual_role'] = $user_role;
        $resultx['action'] = 'promote';
        $resultx['desired_role'] = 'admin';
    } else if ($user_role == 'admin') {
        $resultx['user_id'] = $user_id;
        $resultx['user_name'] = $user_name;
        $resultx['actual_role'] = $user_role;
        $resultx['action'] = 'demote';
        $resultx['desired_role'] = 'user';
    }

    return $resultx;
}

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

function cleanupArray($app, $tainted_array)
{
    $validator = $app->getContainer()->get('Validator');
    $cleaned_array = $validator->sanitiseArray($tainted_array);
    return $cleaned_array;
}


/**
 * @param $user_id
 * @param $app
 * @return array
 */
function changeRoleDB($user_id, $app)
{
    $theuserid = $user_id - 1;
    $users_model = $app->getContainer()->get('UsersModel');
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $users_model->setSqlQueries($sql_queries);
    $users_model->setDatabaseConnectionSettings($database_connection_settings);
    $users_model->setDatabaseWrapper($database_wrapper);

    $users_data = getUsers($app)['retrieved_users_data'];
    $user_role = $users_data[$theuserid]['role'];
    $resultx = [];

    if ($user_role == 'user') {
        $resultx['desired_role'] = 'admin';
    } elseif ($user_role == 'admin') {
        $resultx['desired_role'] = 'user';
    }

    $resultx = $users_model->changeUserRole($resultx['desired_role'], $user_id);

    return $resultx;
}
