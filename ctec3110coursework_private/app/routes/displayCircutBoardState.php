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

        $switch_state_data = retrieveSwitchStates($app)['retrieved_switch_states'];

        $switch1 = switchState($switch_state_data['switch1']);
        $switch2 = switchState($switch_state_data['switch2']);
        $switch3 = switchState($switch_state_data['switch3']);
        $switch4 = switchState($switch_state_data['switch4']);
        $fan = $switch_state_data['fan'];
        $heater = $switch_state_data['heater'];
        $keypad = $switch_state_data['keypad'];

        return $this->view->render($response,
            'display_board.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'Circut Board State',
                'switch1' => $switch1,
                'switch2' => $switch2,
                'switch3' => $switch3,
                'switch4' => $switch4,
                'fan' => $fan,
                'heater' => $heater,
                'keypad' => $keypad

            ]);

    })->setName('displaycircuitboard');


/**
 * @param $app
 * @return mixed
 */

function retrieveSwitchStates($app)
{

    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $switch_states_model = $app->getContainer()->get('SwitchModel');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $switch_states_model->setSqlQueries($sql_queries);
    $switch_states_model->setDatabaseConnectionSettings($database_connection_settings);
    $switch_states_model->setDatabaseWrapper($database_wrapper);

    $final_states = $switch_states_model->getSwitchState();

    return $final_states;
}

/**
 * @param $state
 * @return null|string
 */

function switchState($state){
    $output = NULL;
    if ($state == 0){
        $output = 'Turned ON';
    } else if ($state = 1) {
        $output = 'Turned OFF';
    }
    return $output;
}