<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */
    '/logout',
    function(Request $request, Response $response) use ($app)
    {
        unsetSession($app);
        return $this->view->render($response,
            'logout.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'You have successfully logged out. Thank you for using our app!',

            ]);

    })->setName('logout');

function unsetSession($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');

    $session_wrapper->unsetSessionVar('password');

}