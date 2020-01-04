<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/login',
    function(Request $request, Response $response) use ($app)
    {

        return $this->view->render($response,
            'login.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'method' => 'post',
                'action' => 'afterlogin',
                'page_title' => 'Login Form',
                'page_heading_1' => 'Login To View Content',
            ]);

    })->setName('login');