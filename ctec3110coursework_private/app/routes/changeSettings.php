<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(

/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */

    '/changeSettings',
    function(Request $request, Response $response) use ($app)
    {

        return $this->view->render($response,
            'change_settings.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_heading' => APP_NAME,
                'page_heading_2' => ' / Change Settings ',
            ]);

    })->setName('changeSettings');


