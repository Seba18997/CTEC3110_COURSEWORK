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
        $response = $response->withRedirect('/ctec3110coursework_public/');
        return $response;

    })->setName('logout');

function unsetSession($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');

    $session_wrapper->unsetSessionVar('username');
    $session_wrapper->unsetSessionVar('password');
    $session_wrapper->unsetSessionVar('sid');
}