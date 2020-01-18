<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/manageusers',
    function(Request $request, Response $response) use ($app)
    {

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $users_data = getUsers($app)['retrieved_users_data'];
        $counter = getUsers($app)['amount_of_users'];

        $this->get('logger')->info("Users content downloaded from M2M server to database and then presented on a website.");

        return $this->view->render($response,
            'manage_users.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_heading' => APP_NAME,
                'is_logged_in' => $isloggedin,
                'username' => $username,
                'page_heading_2' => ' / Messages ',
                'page_title' => APP_NAME,
                'action' => 'updateuser',
                'action3' => 'logout',
                'method' => 'post',
                'users_data' => $users_data,
                'counter' => '('.$counter.')',
                'sign_out_form' => $sign_out_form_visibility,
                'back_button_visibility' => 'block',
            ]);

    })->setName('manageusers');

function getUsers($app)
{

    $users_model = $app->getContainer()->get('UsersModel');
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $users_model->setSqlQueries($sql_queries);
    $users_model->setDatabaseConnectionSettings($database_connection_settings);
    $users_model->setDatabaseWrapper($database_wrapper);

    $users = $users_model->getUsersData();

    return $users;

}

function changeRole($user_id, $desired_role, $app){
    $sourcex = getUsers($app)['retrieved_users_data'];
    $source = $sourcex[$user_id]['role'];
    $resultx = [];
    if (!empty($source) && $source == 'user' && $desired_role = 'admin')
    {
        $resultx['action'] = 'promote';
        $resultx['role'] = 'admin';
    }
    else if(!empty($source) && $source == 'admin' && $desired_role = 'user')
    {
        $resultx['action'] = 'demote';
        $resultx['role'] = 'user';
    }
    return $resultx;
}

var_dump(changeRole(2, 'admin', $app));

