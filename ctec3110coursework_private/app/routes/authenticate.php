<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->post(/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */ '/authenticate',
    function(Request $request, Response $response) use ($app)
    {
        $posted_data = $request->getParsedBody();

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $session_check = sessionCheckAdmin($app);

        if ($session_check == false) {
            $this->get('logger')->info("Admin is not logged in to authenticate.");
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        } else {
            if ($posted_data['action'] == 'settings_changed') {
                $settingsa = cleanupArray($app, $posted_data['settings']);
                updateSettings($app, $settingsa);

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
            } elseif ($posted_data['action'] == 'users_changed') {
                //users_changed_related_functions

                return $this->view->render($response,
                    'user_changed.html.twig',
                    [
                        'css_path' => CSS_PATH,
                        'landing_page' => LANDING_PAGE,
                        'initial_input_box_value' => null,
                        'page_heading' => APP_NAME,
                        'page_heading_2' => ' / User Changed ',
                        'page_title' => APP_NAME.' | User Changed',
                        'action4' => 'manageusers',
                        'action5' => 'updateuserverification',
                        'action3' => 'logout',
                        'method' => 'post',
                        'is_logged_in' => $isloggedin,
                        'username' => $username,
                        'sign_out_form' => $sign_out_form_visibility,
                        'back_button_visibility' => 'block',
                        'usernamex' => $role_changes['user_name'],
                        'old_role' => $role_changes['actual_role'],
                        'new_role' => $role_changes['desired_role'],
                    ]);
            }
        }

    })->setName('authenticate');