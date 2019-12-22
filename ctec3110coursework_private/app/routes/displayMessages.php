<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/displaymessages',
    function(Request $request, Response $response) use ($app)
    {

        $m_result = getMessages($app);

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


function getMessages($app)
{

    $messages_model = $app->getContainer()->get('SoapWrapper');

    $message_connect = $messages_model->createSoapClient();

    $messages_result = $messages_model->getMessagesFromSoap($message_connect, 25);

    return $messages_result;

}

function showMessage($app) {

    $message_data_handle= $app->getContainer()->get('Helper');

    $the_message = $message_data_handle->mapDataFromString(getMessages($app)[0], 'message');

    return $the_message;
}

echo showMessage($app);