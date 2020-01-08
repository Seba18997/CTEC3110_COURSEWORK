<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

    '/displaymessages',
    function(Request $request, Response $response) use ($app)
    {

        $token_length = TOKEN_LENGTH;

        $messages_data = retrieveMessages($app)['retrieved_messages'];

        $random_token = generateToken($app, $token_length);

        return $this->view->render($response,
            'display_messages.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'Messages',
                'messages_data' => $messages_data,
                'token' => $random_token,

            ]);

    })->setName('displaymessages');


/**
 * @param $app
 * @param $database_wrapper
 * @return mixed
 */

function retrieveMessages($app)
{

    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $messages_model = $app->getContainer()->get('DisplayMessages');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $messages_model->setSqlQueries($sql_queries);
    $messages_model->setDatabaseConnectionSettings($database_connection_settings);
    $messages_model->setDatabaseWrapper($database_wrapper);

    $final_messages = $messages_model->getMessages();

    return $final_messages;
}

/**
 * @param $app
 * @param $length
 * @return mixed
 */

function generateToken($app, $length){

    $token_handle = $app->getContainer()->get('Helper');

    $final_token = $token_handle->generateToken($length);

    return $final_token;

}
