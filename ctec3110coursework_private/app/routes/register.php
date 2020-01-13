<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/register',
    function(Request $request, Response $response) use ($app)
    {
        $result = SessionChecker($app);

        if(!(is_null($result)))
        {
            $html_output2 = $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'method' => 'post',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => 'Login Form',
                    'page_heading_1' => 'User logged in',
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
                    'action' => 'registeruser',
                    'initial_input_box_value' => null,
                    'page_heading_1' => 'New User Registration',
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

function SessionChecker($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $store_var = $session_wrapper->getSessionVar('password');
    return $store_var;
}