<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */ '/updateuserverification',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_params = $request->getParsedBody();
        $outcome = compare($app, $_SESSION['password'], $tainted_params['password']);

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        if ($outcome == true ) {

            $user_id = intval($tainted_params['changes']);
            $role_changes = changeRoleDB($user_id, $app);

             $this->get('logger')->info("User provided invalid credentials during logging in.");
             return $this->view->render($response,
                 'user_changed_success.html.twig',
                 [
                     'css_path' => CSS_PATH,
                     'landing_page' => LANDING_PAGE,
                     'page_heading' => APP_NAME,
                     'method' => 'post',
                     'action' => 'manageusers',
                     'action3' => 'logout',
                     'page_title' => APP_NAME.' | User Changed',
                     'page_heading_2' => ' / User Changed',
                     'is_logged_in' => $isloggedin,
                     'username' => $username,
                     'sign_out_form' => $sign_out_form_visibility,
                     'back_button_visibility' => 'block',
                 ]);
         } else {
             $this->get('logger')->info("User (".$username.") provided correct credentials during logging in.");
             return $this->view->render($response,
                 'user_changed_failure.html.twig',
                 [
                     'css_path' => CSS_PATH,
                     'landing_page' => LANDING_PAGE,
                     'page_heading' => APP_NAME,
                     'method' => 'post',
                     'action3' => 'logout',
                     'action' => 'manageusers',
                     'page_title' => APP_NAME.' | Invalid Credentials',
                     'page_heading_2' => ' / Invalid credentials',
                     'is_logged_in' => $isloggedin,
                     'username' => $username,
                     'sign_out_form' => $sign_out_form_visibility,
                     'back_button_visibility' => 'block',
                 ]);
         }


    })->setName('updateuserverification');

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
