<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */

$app->post('/login',
    function (Request $request, Response $response) use ($app) {
        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $result = sessionCheck($app);
        $session_check = sessionCheckAdmin($app);

        $this->get('logger')->info("Log In page opened.");

        if ($result == true && $session_check == true) {
            $this->get('logger')->info("Admin (" . $username . ") already logged in, login page => admin page.");
            $response = $response->withredirect(LANDING_PAGE . '/adminarea');
            return $response;
        } else if ($result == true) {
            $this->get('logger')->info("User (" . $username . ") already logged in, login page => home page.");
            return $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => APP_NAME . ' | User Area',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);
        } else {
            $this->get('logger')->info("User not logged in yet.");
            return $this->view->render($response,
                'login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'userarea',
                    'page_title' => APP_NAME . ' | Log In',
                    'page_heading_2' => ' / Log In',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'block',
                ]);
        }

    })->setName('login');


/**
 * @param $app
 * @return bool
 */
function sessionCheck($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');

    $sessionUsernameSet = $session_wrapper->getSessionVar('username');
    $sessionPasswordSet = $session_wrapper->getSessionVar('password');
    $sessionIdSet = $session_wrapper->getSessionVar('sid');

    if ($sessionUsernameSet == false && $sessionPasswordSet == false && $sessionIdSet == false) {
        $check = false;
    } else {
        $check = true;
    }
    return $check;
}
