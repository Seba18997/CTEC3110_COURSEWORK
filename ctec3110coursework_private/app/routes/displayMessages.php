<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/displaymessages',
    function(Request $request, Response $response) use ($app)
    {

<<<<<<< Updated upstream
        $m_result = getMessages($app);
=======
        $counter = MESSAGE_COUNTER;

        $messages_data = retrieveMessages($app);

        $random_token = generateToken($app, 8);
>>>>>>> Stashed changes

        return $this->view->render($response,
            'display_messages.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'Messages',
                'result' => $m_result,

            ]);
    })->setName('homepage');


<<<<<<< Updated upstream
function getMessages($app)
{

    $messages_model = $app->getContainer()->get('SoapWrapper');

    $message_connect = $messages_model->createSoapClient();

    $messages_result = $messages_model->getMessagesFromSoap($message_connect, 25);

    return $messages_result;
=======
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
>>>>>>> Stashed changes

    return $final_messages;
}

function showMessage($app) {

<<<<<<< Updated upstream
    $message_data_handle= $app->getContainer()->get('Helper');
=======
    $token_handle = $app->getContainer()->get('Helper');
>>>>>>> Stashed changes

    $the_message = $message_data_handle->mapDataFromString(getMessages($app)[0], 'message');

    return $the_message;
}
<<<<<<< Updated upstream

echo showMessage($app);
=======
/*
function decodeTheMessage($app, $message){

    $decode_handle = $app->getContainer()->get('DisplayMessages');

    $decoded_message = $decode_handle->decodeMessage($message);

    return $decoded_message;

}
*/
>>>>>>> Stashed changes
