<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/displaycircutboardstate',
    function(Request $request, Response $response) use ($app)
    {

        $switch1 = 'Not defined';
        $switch2 = 'Not defined';
        $switch3 = 'Not defined';
        $switch4 = 'Not defined';
        $fan = 'Not defined';
        $heater = 'Not defined';
        $keypad = 'Not defined';

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
    })->setName('displaycircuitboard');;



