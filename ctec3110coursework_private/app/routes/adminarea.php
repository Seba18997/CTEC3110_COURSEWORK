<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */

$app->get('/adminarea',
    function (Request $request, Response $response) use ($app) {
        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $role = ifSetUsername($app)['role'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $session_check = sessionCheckAdmin($app);

        if ($session_check == false) {
            $this->get('logger')->info("Admin is not logged in");
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        } else {
            $this->get('logger')->info("Admin (" . $username . ") logged in successfully or already logged in.");
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
                    'action4' => 'changesettings',
                    'action5' => 'manageusers',
                    'action6' => 'logs',
                    'page_title' => APP_NAME . ' | Admin Area',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'role' => $role,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);
        }

    })->setName('adminarea');

/**
 * @param $app
 * @return bool
 */

function sessionCheckAdmin($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    //getSessionVar() returns 'false' if session variable is not set
    $sessionRoleSet = $session_wrapper->getSessionVar('role');

    if ($sessionRoleSet !== 'admin') {
        $check = false;
    } else {
        $check = true;
    }
    return $check;
}
