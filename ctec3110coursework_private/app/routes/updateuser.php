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

        $this->get('logger')->info("Log In page opened.");

        if ($result == true && $session_check == true)
        {
            $this->get('logger')->info("Admin (".$username.") already logged in, login page => admin page.");
            $changes = $request->getParsedBody();
            var_dump($changes);
            changeUsers($app, $changes);
            return $response;
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


function changeUsers($app, $changes)
{

    $users_model = $app->getContainer()->get('UsersModel');
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $users_model->setSqlQueries($sql_queries);
    $users_model->setDatabaseConnectionSettings($database_connection_settings);
    $users_model->setDatabaseWrapper($database_wrapper);

    $users = $users_model->changeUserData($changes);

    return $users;

}
