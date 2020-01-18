<?php

$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(
    $container['settings']['view']['template_path'],
    $container['settings']['view']['twig'],
    [
      'debug' => true // This line should enable debug mode
    ]
  );

  $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
  $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

  return $view;
};

$container['logger'] = function ($container) {
    $logger = new \Monolog\Logger('M2MAPP_Logger');
    $file_handler = new \Monolog\Handler\StreamHandler(LOG_PATH);
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['Helper'] = function ($container) {
    $helper = new M2MAPP\Helper();
    return $helper;
};

$container['DisplayMessages'] = function ($container) {
    $model = new M2MAPP\MessagesModel();
    return $model;
};

$container['SoapWrapper'] = function ($container) {
    $swrapper = new M2MAPP\SoapWrapper();
    return $swrapper;
};

$container['DatabaseWrapper'] = function ($container) {
    $dwrapper = new M2MAPP\DatabaseWrapper();
    return $dwrapper;
};

$container['SQLQueries'] = function ($container) {
    $queries = new M2MAPP\SQLQueries();
    return $queries;
};

$container['Validator'] = function ($container) {
    $validator = new M2MAPP\Validator();
    return $validator;
};

$container['DownloadMessagesToDatabase'] = function ($container) {
    $downloader = new M2MAPP\DownloadMessagesToDatabase();
    return $downloader;
};

$container['SwitchModel'] = function ($container) {
    $smodel = new M2MAPP\SwitchModel();
    return $smodel;
};

$container['doctrineSqlQueries'] = function ($container) {
    $doctrine_sql_queries = new \M2MAPP\DoctrineSqlQueries();
    return $doctrine_sql_queries;
};

$container['bcryptWrapper'] = function ($container) {
    $wrapper = new \M2MAPP\BcryptWrapper();
    return $wrapper;
};

$container['SessionWrapper'] = function ($container) {
    $snwrapper = new \M2MAPP\SessionWrapper();
    return $snwrapper;
};

$container['SessionModel'] = function ($container) {
    $snmodel= new \M2MAPP\SessionModel();
    return $snmodel;
};

$container['Authentication'] = function ($container) {
    $auth = new \M2MAPP\Authentication();
    return $auth;
};

$container['SettingsModel'] = function ($container) {
    $stmodel = new \M2MAPP\SettingsModel();
    return $stmodel;
};

$container['UsersModel'] = function ($container) {
    $usrmodel = new \M2MAPP\UsersModel();
    return $usrmodel;
};

$container['Logs'] = function ($container) {
    $clogger = new \M2MAPP\Logger();
    return $clogger;
};