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

        $download_data = downloadMessages($app);

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
                'download_data' => $download_data,
                'token' => $random_token,

            ]);

    })->setName('displaymessages');




function setDBWrapper($app){
    return $app->getContainer()->get('DatabaseWrapper');
}

function setQueries($app){
    return $app->getContainer()->get('SQLQueries');
}

function setSettingsFile($app){
    return $app->getContainer()->get('settings');
}

/**
 * @param $app
 * @param $database_wrapper
 * @return mixed
 */

function retrieveMessages($app)
{

    $messages_model = $app->getContainer()->get('DisplayMessages');

    $messages_model->setSqlQueries(setQueries($app));
    $messages_model->setDatabaseConnectionSettings(setSettingsFile($app)['pdo_settings']);
    $messages_model->setDatabaseWrapper(setDBWrapper($app));

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

function downloadMessages($app)
{
    $downloaded_messages_model = $app->getContainer()->get('DownloadMessagesToDatabase');

    $downloaded_messages_model->setSqlQueries(setQueries($app));
    $downloaded_messages_model->setDatabaseConnectionSettings(setSettingsFile($app)['pdo_settings']);
    $downloaded_messages_model->setDatabaseWrapper(setDBWrapper($app));

    $final_download_messages = $downloaded_messages_model->storePreparedMessages();

    return $final_download_messages;
}


