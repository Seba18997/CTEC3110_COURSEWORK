<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/register',
    function(Request $request, Response $response) use ($app)
    {
        $result = sessionChecker($app);
        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form = ifSetUsername($app)['sign_out_form'];
        if($result !== false)
        {
            $html_output2 = $this->view->render($response,
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
                    'sign_out_form' => $sign_out_form,
                ]);

            processOutput($app, $html_output2);
            return $html_output2;
        }
        else {
            $html_output = $this->view->render($response,
                'register.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'action' => 'registeruser',
                    'initial_input_box_value' => null,
                    'page_heading_2' => ' / User Registration',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'sign_out_form' => $sign_out_form,
                ]);

            processOutput($app, $html_output);
            return $html_output;
        }

    })->setName('register');

function processOutput($app, $html_output)
{
    $process_output = $app->getContainer()->get('processOutput');
    $html_output = $process_output->processOutput($html_output);
    return $html_output;
}

function sessionChecker($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $store_var = $session_wrapper->getSessionVar('password');
    return $store_var;
}