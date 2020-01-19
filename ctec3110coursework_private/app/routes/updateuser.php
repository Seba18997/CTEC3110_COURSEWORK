<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/updateuser',
    function(Request $request, Response $response) use ($app)
    {

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $result = sessionCheck($app);
        $session_check = sessionCheckAdmin($app);

        if ($result == true && $session_check == true)
        {
            $changes = $request->getParsedBody();
            $user_id = intval($changes['id']);
            $role_changes = changeRole($user_id, $app);
            $this->get('logger')->info("Admin (".$username.") changes role of ".$role_changes['user_name']." to ".$role_changes['desired_role']);
            return $this->view->render($response,
                'user_changed.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'initial_input_box_value' => null,
                    'page_heading' => APP_NAME,
                    'page_heading_2' => ' / User Changed ',
                    'page_title' => APP_NAME.' | User Changed',
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
        else if($result == true)
        {
            $this->get('logger')->info("User (".$username.") already logged in, login page => home page.");
            return $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => APP_NAME.' | User Area',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);
        }
        else
        {
            $this->get('logger')->info("User not logged in yet.");
            return $this->view->render($response,
                'login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'userarea',
                    'page_title' => APP_NAME.' | Log In',
                    'page_heading_2' => ' / Log In',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'block',
                ]);
        }

    })->setName('updateuser');


function changeRole($user_id, $app)
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
    $user_name = $users_data[$theuserid]['username'];
    $resultx = [];

    if ($user_role == 'user')
    {
        $resultx['user_id'] = $user_id;
        $resultx['user_name'] = $user_name;
        $resultx['actual_role'] = $user_role;
        $resultx['action'] = 'promote';
        $resultx['desired_role'] = 'admin';
    }
    else if($user_role == 'admin')
    {
        $resultx['user_id'] = $user_id;
        $resultx['user_name'] = $user_name;
        $resultx['actual_role'] = $user_role;
        $resultx['action'] = 'demote';
        $resultx['desired_role'] = 'user';
    }

    $resultx['final_change'] = $users_model->changeUserRole($resultx['desired_role'], $user_id);

    return $resultx;
}
