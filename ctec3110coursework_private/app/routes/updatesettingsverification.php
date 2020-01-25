<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

$app->post('/updatesettingsverification',
    function(Request $request, Response $response) use ($app)
    {

        $tainted_params = $request->getParsedBody();
        $outcome = compare($app, $_SESSION['password'], $tainted_params['password']);

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        if($outcome == true ) {
            $encoded_array_post = $tainted_params['encoded_array'];
            $decoded_array = json_decode($encoded_array_post, true);
            updateSettings($app, $decoded_array);
            return $this->view->render($response,
                'settings_changed_success.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'changesettings',
                    'action3' => 'logout',
                    'page_title' => APP_NAME.' | Settings Changed',
                    'page_heading_2' => ' / Settings Changed',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'block',
                ]);
        } else {
            return $this->view->render($response,
                'settings_changed_failure.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'changesettings',
                    'action3' => 'logout',
                    'page_title' => APP_NAME.' | Invalid Credentials',
                    'page_heading_2' => ' / Invalid credentials',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'block',
                ]);
        }

    })->setName('updatesettingsverification');


