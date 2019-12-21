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
    });


function getMessages($app)
{

    $messages_model = $app->getContainer()->get('SoapWrapper');

    $message_connect = $messages_model->createSoapClient();

    $messages_result = $messages_model->getMessagesFromSoap($message_connect, 1);

    var_dump($messages_result);

    return $messages_result;

}

function showMessages($app) {

    $messages_model_class = $app->getContainer()->get('DisplayMessages');

    $message_data = $messages_model_class->getMessageData(getMessages($app));

    var_dump($message_data);

    
}