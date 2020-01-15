<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

    '/login',
    function(Request $request, Response $response) use ($app)
    {
        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];

        $result = sessionCheck($app);
        if($result == true) {
            return $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => 'User Area',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                ]);}
        else {
            return $this->view->render($response,
                'login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'userarea',
                    'page_title' => 'Login Form',
                    'page_heading_2' => ' / Log In',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                ]);}

    })->setName('login');


function sessionCheck($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    //getSessionVar() returns 'false' if session variable is not set
    $sessionUsernameSet = $session_wrapper->getSessionVar('username');
    $sessionPasswordSet= $session_wrapper->getSessionVar('password');
    $sessionIdSet = $session_wrapper->getSessionVar('sid');

    if (($sessionUsernameSet && $sessionPasswordSet && $sessionIdSet) == false) {
        $check = false;
    } else {
        $check = true;
    }
    return $check;
}