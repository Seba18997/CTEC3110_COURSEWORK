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

        $messages_data = retrieveMessages($app)['retrieved_messages'];

        $counter = downloadMessages($app)['counter'];

        return $this->view->render($response,
            'display_messages.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'Messages',
                'method' => 'post',
                'messages_data' => $messages_data,
                'counter' => $counter,
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

function downloadMessages($app)
{
    $downloaded_messages_model = $app->getContainer()->get('DownloadMessagesToDatabase');
    $soap_wrapper = $app->getContainer()->get('SoapWrapper');
    $counter = $soap_wrapper->getCountOfNotNullRowsInSoapResponse();

    $downloaded_messages_model->setSqlQueries(setQueries($app));
    $downloaded_messages_model->setDatabaseConnectionSettings(setSettingsFile($app)['pdo_settings']);
    $downloaded_messages_model->setDatabaseWrapper(setDBWrapper($app));
    $downloaded_messages_model->setMsgCounter($counter);

    $final_download_messages['perform_action'] = $downloaded_messages_model->performMainOperation();
    $final_download_messages['counter'] = $counter;

    return $final_download_messages;
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

    $final_messages = $messages_model->getMessagesFromDB();

    return $final_messages;
}
var_dump(downloadMessages($app));