<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

$app->post(
 '/register',
    function(Request $request, Response $response) use ($app)
    {
        $result = sessionChecker($app);

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];

        if($result !== false)
        {
            $this->get('logger')->info("User/Admin (".$username.") already logged in, registration page => home page.");
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
                    'sign_out_form' => 'block',
                    'back_button_visibility' => 'none',
                ]);
        } else {
            $this->get('logger')->info("Unregistered user entered registration page.");
            return $this->view->render($response,
                'register.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'action' => 'registeruser',
                    'initial_input_box_value' => null,
                    'page_title' => APP_NAME.' | User Registration',
                    'page_heading_2' => ' / New User Registration',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => 'none',
                    'back_button_visibility' => 'block',
                ]);
        }
    })->setName('register');

/**
 * @param $app
 * @return mixed
 */
function sessionChecker($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $store_var = $session_wrapper->getSessionVar('password');
    return $store_var;
}