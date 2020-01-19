<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

$app->get('/', function(Request $request, Response $response) use ($app)
{
    $isloggedin = ifSetUsername($app)['introduction'];
    $username = ifSetUsername($app)['username'];
    $role = ifSetUsername($app)['role'];
    $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

    $result = sessionCheck($app);

    $session_check = sessionCheckAdmin($app);

    if ($result == true && $session_check == true) {
        $this->get('logger')->info("Admin (".$username.") already logged in, login page => admin page.");
        $response = $response->withredirect(LANDING_PAGE . '/adminarea');
        return $response;
    } elseif ($result == true) {
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
                'action3' => 'logout',
                'page_title' => APP_NAME.' | User Area',
                'is_logged_in' => $isloggedin,
                'username' => $username,
                'role' => $role,
                'sign_out_form' => $sign_out_form_visibility,
                'back_button_visibility' => 'none',
            ]);
    } else {
        $this->get('logger')->info("User/Admin entered Log In page.");
        return $this->view->render($response,
            'homepageform.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'page_heading' => APP_NAME,
                'method' => 'post',
                'action' => 'login',
                'action2' => 'register',
                'action3' => 'logout',
                'page_title' => APP_NAME.' | Homepage',
                'is_logged_in' => $isloggedin,
                'username' => $username,
                'sign_out_form' => $sign_out_form_visibility,
                'back_button_visibility' => 'none',
            ]);
    }

})->setName('homepage');
