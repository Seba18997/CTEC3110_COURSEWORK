<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->post('/updateuserverification',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_password = $request->getParsedBody();
        var_dump($_SESSION['password']);
        var_dump($tainted_password['password']);
        $outcome = compare($app, $_SESSION['password'], $tainted_password['password']);

        if($outcome == true) {
            echo "same pass";
        }

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];
        $sign_out_form_visibility = ifSetUsername($app)['sign_out_form_visibility'];
        $role = ifSetUsername($app)['role'];

         if($outcome == false ) {
             $this->get('logger')->info("User (".$cleaned_username.") provided invalid credentials during logging in.");
             return $this->view->render($response,
                 'invalid_login.html.twig',
                 [
                     'css_path' => CSS_PATH,
                     'landing_page' => LANDING_PAGE,
                     'page_heading' => APP_NAME,
                     'method' => 'post',
                     'action' => '',
                     'page_title' => APP_NAME.' | Invalid Credentials',
                     'page_heading_1' => 'Invalid credentials',
                     'is_logged_in' => $isloggedin,
                     'username' => $username,
                     'sign_out_form' => $sign_out_form_visibility,
                     'back_button_visibility' => 'none',
                 ]);
         }
         elseif($user_role == 'user')
         {
             $this->get('logger')->info("User (".$username.") provided correct credentials during logging in.");
             return $this->view->render($response,
                 'valid_login.html.twig',
                 [
                     'css_path' => CSS_PATH,
                     'landing_page' => LANDING_PAGE,
                     'page_heading' => APP_NAME,
                     'method' => 'post',
                     'action3' => 'logout',
                     'action' => 'displaycircutboardstate',
                     'action2' => 'displaymessages',
                     'page_title' => APP_NAME.' | User Area',
                     'is_logged_in' => $isloggedin,
                     'username' => $username,
                     'role' => $role,
                     'sign_out_form' => $sign_out_form_visibility,
                     'back_button_visibility' => 'none',
                 ]);
         }
         else
         {
             $this->get('logger')->info("Admin provided correct credentials during logging in.");
             $response = $response->withredirect(LANDING_PAGE.'/adminarea');
             return $response;
         }


    })->setName('updateuserverification');




