<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */
    '/displaycircutboardstate',
    function(Request $request, Response $response) use ($app)
    {
        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];

        $switch_state_data = checkIfSwitchStatesChangedandDisplay($app)['get'];

        $switch1 = $switch_state_data['switch1'];
        $switch2 = $switch_state_data['switch2'];
        $switch3 = $switch_state_data['switch3'];
        $switch4 = $switch_state_data['switch4'];
        $fan = $switch_state_data['fan'];
        $heater = $switch_state_data['heater'];
        $keypad = $switch_state_data['keypad'];

        return $this->view->render($response,
            'display_board.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_heading' => APP_NAME,
                'is_logged_in' => $isloggedin,
                'username' => $username,
                'page_title' => APP_NAME.' | Circuit Board',
                'page_heading_2' => ' / Circuit Board',
                'action3' => 'logout',
                'method' => 'post',
                'switch1' => $switch1,
                'switch2' => $switch2,
                'switch3' => $switch3,
                'switch4' => $switch4,
                'fan' => $fan,
                'heater' => $heater,
                'counter' => '',
                'keypad' => $keypad,
                'sign_out_form' => $sign_out_form_visibility,
                'back_button_visibility' => 'block',

            ]);

    })->setName('displaycircuitboard');


function checkIfSwitchStatesChangedandDisplay($app)
{

    $messages_model = $app->getContainer()->get('DisplayMessages');
    $helper = $app->getContainer()->get('Helper');
    $switch_states_model = $app->getContainer()->get('SwitchModel');
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $messages_model->setSqlQueries($sql_queries);
    $messages_model->setDatabaseConnectionSettings($database_connection_settings);
    $messages_model->setDatabaseWrapper($database_wrapper);

    $switch_states_model->setSqlQueries($sql_queries);
    $switch_states_model->setDatabaseConnectionSettings($database_connection_settings);
    $switch_states_model->setDatabaseWrapper($database_wrapper);

    $newest_message = $messages_model->getNewestMessageFromDB();

    $decoded_message = $helper->decodeMessage($newest_message);

    $final_states['newest'] = $newest_message;

    $final_states['decoded'] = $decoded_message;

    $final_states['update'] = $switch_states_model->updateSwitchStates($decoded_message);

    $final_states['get'] = $switch_states_model->getSwitchState()['retrieved_switch_states'];

    return $final_states;

}

