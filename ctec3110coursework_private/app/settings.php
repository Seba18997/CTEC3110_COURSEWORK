<?php

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'm2mapp.%t');
ini_set('xdebug.trace_format', '1');

$settings_setup = new \M2MAPP\SettingsSetup();
$settings_array = $settings_setup->getSettingsFromDB();
$settings = $settings_array['settings'];

define('DIRSEP', DIRECTORY_SEPARATOR);

$app_url = dirname($_SERVER['SCRIPT_NAME']);
$css_path = $app_url . '/css/standard.css';
$log_path = '../../logs/M2MAPP_PROD_01.log';

define('APP_URL', $app_url);
define('CSS_PATH', $css_path);
define('LOG_PATH', $log_path);

define('APP_NAME', $settings['app_name']);
define('LANDING_PAGE', $_SERVER['SCRIPT_NAME']);

$messages_counter = $settings['wsdl_messagecounter'];
define('MESSAGES_COUNTER', $messages_counter);

$wsdl = $settings['wsdl'];
define ('WSDL', $wsdl);
$username = $settings['wsdl_username'];
define ('USERNAME', $username);
$password = $settings['wsdl_password'];
define ('PASSWORD', $password);

define ('BCRYPT_ALGO', PASSWORD_DEFAULT);
define ('BCRYPT_COST', 12);

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
            'host' => $settings['db_host'],
            'dbname' => $settings['db_name'],
            'port' => $settings['db_port'],
            'username' => $settings['db_user'],
            'userpassword' => $settings['db_userpassword'],
            'charset' => $settings['db_charset'],
            'collation' => $settings['db_collation'],
            'options' => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
            ]],
        'doctrine_settings' => [
            'driver' => $settings['doctrine_driver'],
            'host' => $settings['db_host'],
            'dbname' => $settings['db_name'],
            'port' => $settings['db_port'],
            'user' => $settings['db_user'],
            'password' => $settings['db_userpassword'],
            'charset' => $settings['db_charset']
        ]],
];
return $settings;