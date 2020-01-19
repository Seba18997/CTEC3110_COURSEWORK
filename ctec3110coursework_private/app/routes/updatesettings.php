<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/updatesettings',
    function(Request $request, Response $response) use ($app)
    {
        $session_check = sessionCheckAdmin($app);

        if($session_check == false)
        {
            $this->get('logger')->info("Admin is not logged in to make any changes in settings.");
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        }
        else
        {
            $settings = $request->getParsedBody();
            $settingsa = cleanupArray($app, $settings);

            updateSettings($app, $settingsa);

            $isloggedin = ifSetUsername($app)['introduction'];
            $username = ifSetUsername($app)['username'];
            $role = ifSetUsername($app)['role'];
            $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

            $this->get('logger')->info("Admin (".$username.") changed settings successfully.");

            return $this->view->render($response,
                'settings_changed.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'initial_input_box_value' => null,
                    'page_heading' => APP_NAME,
                    'page_heading_2' => ' / Settings Changed ',
                    'page_title' => APP_NAME.' | Settings Changed',
                    'action4' => 'changesettings',
                    'action3' => 'logout',
                    'method' => 'post',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'role' => $role,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'block',
                ]);
        }
    })->setName('updatesettings');

