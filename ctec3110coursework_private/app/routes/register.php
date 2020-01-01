<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/register',
    function(Request $request, Response $response) use ($app)
    {

        $sid = session_id();

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

    })->setName('register');

function processOutput($app, $html_output)
{
    $process_output = $app->getContainer()->get('processOutput');
    $html_output = $process_output->processOutput($html_output);
    return $html_output;
}