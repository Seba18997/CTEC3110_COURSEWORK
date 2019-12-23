<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/displaymessages',
    function(Request $request, Response $response) use ($app)
    {

            $messages_data = getMessages($app,1);

        $random_token = generateToken($app, 8);

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


function getMessages($app, $counter)
{

    $messages_final_result = [];

    $messages_model = $app->getContainer()->get('SoapWrapper');

    $message_connect = $messages_model->createSoapClient();

    $messages_result = $messages_model->getMessagesFromSoap($message_connect, $counter);

    $message_data_handle = $app->getContainer()->get('Helper');

    for ($i=0;$i<$counter;$i++){

        $messages_final_result['source'] = $message_data_handle->mapDataFromString($messages_result[$i], 'sourcemsisdn');
        $messages_final_result['dest'] = $message_data_handle->mapDataFromString($messages_result[$i], 'destinationmsisdn');
        $messages_final_result['date'] = $message_data_handle->mapDataFromString($messages_result[$i], 'receivedtime');
        $messages_final_result['type'] = $message_data_handle->mapDataFromString($messages_result[$i], 'bearer');
        $messages_final_result['message'] = $message_data_handle->mapDataFromString($messages_result[$i], 'message');

       // todo: message content detection
       // $messages_final_result['message'] = decodeTheMessage($app, $messages_final_result['message']);
    }

    return $messages_final_result;

}

function generateToken($app, $length){

    $token_handle = $app->getContainer()->get('DisplayMessages');

    $final_token = $token_handle->generateToken($length);

    return $final_token;

}

function decodeTheMessage($app, $message){

    $decode_handle = $app->getContainer()->get('DisplayMessages');

    $decoded_message = $decode_handle->decodeMessage($message);

    return $decoded_message;

}
var_dump(getMessages($app, 1));