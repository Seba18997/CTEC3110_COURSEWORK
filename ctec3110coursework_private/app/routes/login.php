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
        $result = SessionCheck($app);
        if(!(is_null($result))) {
            return $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'method' => 'post',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => 'Login Form',
                    'page_heading_1' => 'User logged in',
                ]);}
        else {

            return $this->view->render($response,
                'login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'method' => 'post',
                    'action' => 'afterlogin',
                    'page_title' => 'Login Form',
                    'page_heading_1' => 'Login To View Content',
                ]);}

    })->setName('afterlogin');

function SessionCheck($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $store_var = $session_wrapper->getSessionVar('password');
    return $store_var;
}