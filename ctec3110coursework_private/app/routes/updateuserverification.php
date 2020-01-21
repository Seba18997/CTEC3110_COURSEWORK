<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

$app->post('/updateuserverification',
    function (Request $request, Response $response) use ($app) {
        $tainted_params = $request->getParsedBody();
        $outcome = compare($app, $_SESSION['password'], $tainted_params['password']);

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $user_id = intval($tainted_params['changes']);

        if ($outcome == true) {
	$role_changes = changeRoleDB($user_id, $app);
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
