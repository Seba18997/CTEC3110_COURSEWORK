<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
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
                'action3' => 'logout',
                'page_title' => 'Login Form',
                'is_logged_in' => $isloggedin,
                'username' => $username,
            ]);}
    else {

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
                'page_title' => APP_NAME,
                'is_logged_in' => $isloggedin,
                'username' => $username,
            ]);}

})->setName('homepage');

