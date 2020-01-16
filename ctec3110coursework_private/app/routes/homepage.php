<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{
    $isloggedin = ifSetUsername($app)['introduction'];
    $username = ifSetUsername($app)['username'];
    $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];
    $result = sessionCheck($app);
    if($result == true) {
        return $this->view->render($response,
            'valid_login.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'page_heading' => APP_NAME,
                'method' => 'post',
                'action' => 'displaycircutboardstate',
                'action2' => 'displaymessages',
                'action3' => 'logout',
                'page_title' => APP_NAME.' | User Area',
                'is_logged_in' => $isloggedin,
                'username' => $username,
                'sign_out_form' => $sign_out_form_visibility,
                'back_button_visibility' => 'none',
            ]);}
    else {

        return $this->view->render($response,
            'homepageform.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'page_heading' => APP_NAME,
                'method' => 'post',
                'action' => 'login',
                'action2' => 'register',
                'action3' => 'logout',
                'page_title' => APP_NAME.' | Homepage',
                'is_logged_in' => $isloggedin,
                'username' => $username,
                'sign_out_form' => $sign_out_form_visibility,
                'back_button_visibility' => 'none',
            ]);}

})->setName('homepage');

function showSettings($app){

    $settings_model = $app->getContainer()->get('SettingsModel');
    $settings_file = $app->getContainer()->get('settings');

    $settings_model->setSqlQueries($app->getContainer()->get('SQLQueries'));
    $settings_model->setDatabaseConnectionSettings($settings_file['pdo_settings']);
    $settings_model->setDatabaseWrapper($app->getContainer()->get('DatabaseWrapper'));

    $settings = $settings_model->getSettingsFromDB();
    return $settings;
}