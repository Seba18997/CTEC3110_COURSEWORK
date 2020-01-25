<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */

$app->post('/logs',
    function (Request $request, Response $response) use ($app) {

        $session_check = sessionCheckAdmin($app);
        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $logs_data = retrieveLogs($app)['log_file'];
        $log_counter = retrieveLogs($app)['log_counter'];

        if ($session_check == false) {
            $this->get('logger')->info("Admin is not logged in while entering /logs");
            $response = $response->withredirect(LANDING_PAGE);
            return $response;
        } else {
            $this->get('logger')->info("Admin (" . $username . ") successfully entered /logs.");
            return $this->view->render($response,
                'browse_logs.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'initial_input_box_value' => null,
                    'page_heading' => APP_NAME,
                    'page_heading_2' => ' / Browse Logs (' . $log_counter . ')',
                    'page_title' => APP_NAME . ' | Browse Logs (' . $log_counter . ')',
                    'action3' => 'logout',
                    'method' => 'post',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                    'logsdata' => $logs_data,
                    'sign_out_form' => $sign_out_form_visibility,
                    'back_button_visibility' => 'block',
                ]);
        }

    })->setName('logs');

/**
 * @param $app
 * @return mixed
 */
function retrieveLogs($app)
{
    $logs = $app->getContainer()->get('Logs');

    $logs->setLogFile(LOG_PATH);

    $final_logs = $logs->readLogFile();

    return $final_logs;
}

