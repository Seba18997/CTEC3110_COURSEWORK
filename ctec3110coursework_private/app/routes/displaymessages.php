<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

$app->post('/displaymessages',
    function (Request $request, Response $response) use ($app) {

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $counter = downloadMessages($app)['counter'];
        $messages_data = retrieveMessages($app)['retrieved_messages'];

        $this->get('logger')->info($username . ": Messages content downloaded from M2M server to database and then presented on a website.");

        return $this->view->render($response,
            'display_messages.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_heading' => APP_NAME,
                'is_logged_in' => $isloggedin,
                'username' => $username,
                'page_heading_2' => ' / Messages ',
                'page_title' => APP_NAME . ' | Messages (' . $counter . ')',
                'action3' => 'logout',
                'method' => 'post',
                'messages_data' => $messages_data,
                'counter' => '(' . $counter . ')',
                'sign_out_form' => $sign_out_form_visibility,
                'back_button_visibility' => 'block',
            ]);

    })->setName('displaymessages');


/**
 * @param $app
 * @return mixed
 */
function setDBWrapper($app)
{
    return $app->getContainer()->get('DatabaseWrapper');
}

/**
 * @param $app
 * @return mixed
 */
function setQueries($app)
{
    return $app->getContainer()->get('SQLQueries');
}

/**
 * @param $app
 * @return mixed
 */
function setSettingsFile($app)
{
    return $app->getContainer()->get('settings');
}

/**
 * @param $app
 * @return mixed
 */
function downloadMessages($app)
{
    $downloaded_messages_model = $app->getContainer()->get('DownloadMessagesToDatabase');
    $soap_wrapper = $app->getContainer()->get('SoapWrapper');

    $soap_response = $soap_wrapper->getMessagesFromSoap($soap_wrapper->createSoapClient(), MESSAGES_COUNTER);

    $counter = $soap_wrapper->getCountOfNotNullRowsInSoapResponse();

    $downloaded_messages_model->setSqlQueries(setQueries($app));
    $downloaded_messages_model->setDatabaseConnectionSettings(setSettingsFile($app)['pdo_settings']);
    $downloaded_messages_model->setDatabaseWrapper(setDBWrapper($app));
    $downloaded_messages_model->setMsgCounter($counter);
    $downloaded_messages_model->setSoapResponse($soap_response);

    $final_download_messages['perform_action'] = $downloaded_messages_model->performMainOperation();
    $final_download_messages['counter'] = $counter;

    return $final_download_messages;
}

/**
 * @param $app
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
