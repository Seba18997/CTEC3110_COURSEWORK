<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/updatesettingsverification',
    function(Request $request, Response $response) use ($app)
    {

        $tainted_params = $request->getParsedBody();
        $outcome = compare($app, $_SESSION['password'], $tainted_params['password']);


        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];


        if($outcome == true ) {

            $user_id = intval($tainted_params['changes']);
            $role_changes = changeRoleDB($user_id, $app);

            $this->get('logger')->info("User provided invalid credentials during logging in.");
            return $this->view->render($response,
                'user_changed_success.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'manageusers',
                    'page_title' => APP_NAME.' | Invalid Credentials',
                    'page_heading_1' => 'Invalid credentials',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);
        }
        else
        {
            $this->get('logger')->info("User (".$username.") provided correct credentials during logging in.");
            return $this->view->render($response,
                'user_changed_failure.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'manageusers',
                    'page_title' => APP_NAME.' | Invalid Credentials',
                    'page_heading_1' => 'Invalid credentials',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'none',
                ]);
        }

    })->setName('updatesettingsverification');


