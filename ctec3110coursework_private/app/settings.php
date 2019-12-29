<?php

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'm2mapp.%t');
ini_set('xdebug.trace_format', '1');

define('DIRSEP', DIRECTORY_SEPARATOR);

$app_url = dirname($_SERVER['SCRIPT_NAME']);
$css_path = $app_url . '/css/standard.css';

define('CSS_PATH', $css_path);
define('APP_NAME', 'M2MAPP');
define('LANDING_PAGE', $_SERVER['SCRIPT_NAME']);

$token_length = 4;
define('TOKEN_LENGTH', $token_length);

$messages_counter = 50;
define('MESSAGES_COUNTER', $messages_counter);

$wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';
define ('WSDL', $wsdl);
$username = "19_Sebastian";
define ('USERNAME', $username);
$password = "passXDword123";
define ('PASSWORD', $password);

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'class_path' => __DIR__ . '/src/',
        'view' => [
            'template_path' => __DIR__ . '/templates/',
            'twig' => [
                'cache' => false,
                'auto_reload' => true,
            ]],
        'pdo_settings' => [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'coursework',
            'port' => '3306',
            'user_name' => 'p3tuser',
            'user_password' => 'password',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
            ],
        ]
    ],
];

return $settings;
