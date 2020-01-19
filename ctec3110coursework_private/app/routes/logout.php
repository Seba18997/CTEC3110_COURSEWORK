<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @param Request $request
 * @param Response $response
 * @return Response
 */

$app->post('/logout',
    function (Request $request, Response $response) use ($app) {
        $username = ifSetUsername($app)['username'];
        $this->get('logger')->info("User/Admin (" . $username . ") successfully logged out.");
        unsetSession($app);
        $response = $response->withredirect(LANDING_PAGE);
        return $response;

    })->setName('logout');

/**
 * @param $app
 */
function unsetSession($app)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $session_wrapper->unsetSessionVar('username');
    $session_wrapper->unsetSessionVar('password');
    $session_wrapper->unsetSessionVar('sid');
    $session_wrapper->unsetSessionVar('role');
}