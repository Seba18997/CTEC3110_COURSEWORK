<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/adminarea',
    function(Request $request, Response $response) use ($app)
    {
        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $role = ifSetUsername($app)['role'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

            return $this->view->render($response,
                'admin_area.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action3' => 'logout',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'action4' => 'changeSettings',
                    'page_title' => APP_NAME.' | User Area',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'role' => $role,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);

    })->setName('adminarea');


